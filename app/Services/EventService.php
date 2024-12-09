<?php

namespace App\Services;

use App\Models\Event;

class EventService
{
    public function all()
    {
        return Event::all();
    }

    public function findOrFail($id)
    {
        return Event::findOrFail($id);
    }

    public function createEvent(array $data)
    {
        return Event::create($data);
    }

    public function updateEvent($id, array $data)
    {
        $event = $this->findOrFail($id);
        return $event->update($data);
    }

    public function deleteEvent($id)
    {
        $event = $this->findOrFail($id);
        return $event->delete();
    }
}
