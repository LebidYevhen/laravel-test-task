<?php

namespace App\Http\Controllers;

use App\Http\Requests\{VenueCreateRequest, VenueUpdateRequest};
use App\Models\Venue;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\{DB, Redirect};
use Illuminate\View\View;

class VenueController extends Controller
{
    public function index(Request $request): View
    {
        $venues = DB::table('venue')
            ->when($request->has('sort_field'), function ($query) use ($request) {
                $sortField = $request->input('sort_field');
                $sortDir = $request->input('sort_dir', 'asc');
                $query->orderBy($sortField, $sortDir);
            })
            ->paginate(10);

        if (
            $request->header('hx-request')
            && $request->header('hx-target') == 'venue-table-container'
        ) {
            return view('venue.partials.table', ['venues' => $venues]);
        }

        return view('venue.index', [
            'venues' => $venues
        ]);
    }

    public function create(Venue $venue): View
    {
        return view('venue.single.create', [
            'venue' => $venue,
            'venues' => Venue::all(),
        ]);
    }

    public function store(VenueCreateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $venue = Venue::create($validated);

        return Redirect::route('venue.edit', [
            'venue' => $venue->id
        ])->with('status', 'venue-created');
    }

    public function edit(Venue $venue): View
    {
        return view('venue.single.edit', [
            'venue' => $venue,
        ]);
    }

    public function update(VenueUpdateRequest $request, Venue $venue): RedirectResponse
    {
        $validated = $request->validated();

        $venue->update($validated);

        return Redirect::route('venue.edit', [
            'venue' => $venue->id
        ])->with('status', 'venue-updated');
    }

    public function destroy(Venue $venue): RedirectResponse
    {
        $venue->delete();

        return Redirect::route('venue.index')->with('status', 'venue-deleted');
    }
}
