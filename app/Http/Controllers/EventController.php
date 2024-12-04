<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\Store\StoreEventRequest;
use App\Http\Requests\Update\UpdateEventRequest;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();
        $event = Event::create($validated);
        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return $event;
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $validated = $request->validated();
        $event = Event::findOrFail($id);
        $event->update($validated);
        return response()->json($event, 200);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response(null, 204);
    }
}
