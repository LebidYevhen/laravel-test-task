<?php

namespace App\Http\Controllers;

use App\Http\Requests\{EventCreateRequest, EventUpdateRequest};
use App\Models\{Event, Venue};
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{DB, Redirect};
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class EventController extends Controller
{
    public function index(): View
    {
        return view('events.index', [
            'events' => DB::table('events')->paginate(10)
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
        $event->poster = $this->handlePoster($request);
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
        $event->poster = $this->handlePoster($request);

        $event->update($request->except('poster'));

        return Redirect::route('event.edit', [
            'event' => $event->id
        ])->with('status', 'event-updated');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return Redirect::route('events.index')->with('status', 'event-deleted');
    }

    private function handlePoster($request)
    {
        $image = $request->file('poster');
        $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();

        $img = Image::read($image->path());
        if ($img->width() > 1200) {
            $img->crop(600, 600, position: 'center-center');
        }

        $img->save(public_path('storage') . '/' . $imageName);

        return $imageName;
    }
}
