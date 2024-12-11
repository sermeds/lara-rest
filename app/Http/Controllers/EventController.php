<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\Store\StoreEventRequest;
use App\Http\Requests\Update\UpdateEventRequest;
use App\Services\EventService;
use Illuminate\Support\Facades\Request;

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

    public function show($id)
    {
        return $this->eventService->findOrFail($id);
    }

    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();

        // Проверяем, является ли запрос массивом
        $events = is_array($validated[0] ?? null) ? $validated : [$validated];

        $createdEvents = [];
        foreach ($events as $event) {
            $createdEvents[] = $this->eventService->createEvent($event);
        }

        return response()->json($createdEvents, 201, options: JSON_UNESCAPED_UNICODE);
    }

    public function update(UpdateEventRequest $request, $id = null)
    {
        $validated = $request->validated();

        // Если передан массив данных
        if (is_array($validated[0] ?? null)) {
            $updatedEvents = [];
            foreach ($validated as $event) {
                if (!isset($event['id'])) {
                    return response()->json(['error' => 'ID is required for update.'], 400);
                }
                $updatedEvents[] = $this->eventService->updateEvent($event['id'], $event);
            }
            return response()->json($updatedEvents, 200, options: JSON_UNESCAPED_UNICODE);
        }

        // Если данные для одного элемента
        $event = $this->eventService->updateEvent($id, $validated);
        return response()->json($event, 200, options: JSON_UNESCAPED_UNICODE);
    }

    public function destroy(Request $request, $id = null)
    {
        if ($id !== null) {
            $this->eventService->deleteEvent($id);
            return response(null, 204);
        }

        $ids = $request->input('ids');
        if (!is_array($ids)) {
            return response()->json(['error' => 'IDs must be an array.'], 400);
        }

        foreach ($ids as $id) {
            $this->eventService->deleteEvent($id);
        }

        return response(null, 204);
    }
}
