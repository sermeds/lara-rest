<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\Store\StoreEventRequest;
use App\Http\Requests\Update\UpdateEventRequest;
use App\Services\EventService;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        return$this->eventService->all();
    }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();
        $event = $this->eventService->createEvent($validated);
        return response()->json($event, 201);
    }

    public function show($id)
    {
        return $this->eventService->findOrFail($id);
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $validated = $request->validated();
        $event = $this->eventService->updateEvent($id, $validated);
        return response()->json($event, 200);
    }

    public function destroy($id)
    {
        $this->eventService->deleteEvent($id);

        return response(null, 204);
    }
}
