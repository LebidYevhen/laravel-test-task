<?php

namespace App\Http\Controllers;

use App\Http\Requests\{EventCreateRequest, EventUpdateRequest};
use App\Models\{Event, Venue};
use App\Services\EventService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Redirect};
use Illuminate\View\View;

class EventController extends Controller
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request): View
    {
        $events = DB::table('events')
            ->when($request->has('sort_field'), function ($query) use ($request) {
                $sortField = $request->input('sort_field');
                $sortDir = $request->input('sort_dir', 'asc');
                $query->orderBy($sortField, $sortDir);
            })
            ->paginate(10);

        if (
            $request->header('hx-request')
            && $request->header('hx-target') == 'events-table-container'
        ) {
            return view('events.partials.table', ['events' => $events]);
        }

        return view('events.index', [
            'events' => $events
        ]);
    }

    public function create(Event $event): View
    {
        return view('events.single.create', [
            'event' => $event,
            'venues' => Venue::all(),
        ]);
    }

    public function store(EventCreateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $event = Event::create($validated);
        $event->poster = $this->eventService->handlePoster($request);
        $event->save();

        return Redirect::route('event.edit', [
            'event' => $event->id
        ])->with('status', 'event-created');
    }

    public function edit(Event $event): View
    {
        return view('events.single.edit', [
            'event' => $event,
            'venues' => Venue::all(),
        ]);
    }

    public function update(EventUpdateRequest $request, Event $event): RedirectResponse
    {
        $posterName = $this->eventService->handlePoster($request);

        if (!$posterName) {
            $event->update($request->validated());
        } else {
            $event->poster = $posterName;
            $event->update($request->except('poster'));
        }

        return Redirect::route('event.edit', [
            'event' => $event->id
        ])->with('status', 'event-updated');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return Redirect::route('events.index')->with('status', 'event-deleted');
    }
}
