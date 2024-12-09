<?php

namespace App\Services;

use App\Models\Feedback;

class FeedbackService
{
    public function all()
    {
        return Feedback::all();
    }

    public function findOrFail($id)
    {
        return Feedback::findOrFail($id);
    }

    public function createFeedback(array $data)
    {
        return Feedback::create($data);
    }

    public function updateFeedback($id, array $data)
    {
        $feedback = $this->findOrFail($id);
        return $feedback->update($data);
    }

    public function deleteFeedback($id)
    {
        $feedback = $this->findOrFail($id);
        return $feedback->delete();
    }
}
