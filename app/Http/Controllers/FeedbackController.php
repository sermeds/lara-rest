<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Http\Requests\Store\StoreFeedbackRequest;
use App\Http\Requests\Update\UpdateFeedbackRequest;
use App\Services\FeedbackService;

class FeedbackController extends Controller
{
    protected $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function index()
    {
        return $this->feedbackService->all();
    }

    public function store(StoreFeedbackRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $validated = $request->validated();
        $feedback = $this->feedbackService->createFeedback($validated);
        return response()->json($feedback, 201);
    }

    public function show($id)
    {
        return $this->feedbackService->findOrFail($id);
    }

    public function update(UpdateFeedbackRequest $request, $id)
    {
        $validated = $request->validated();
        $feedback = $this->feedbackService->updateFeedback($id, $validated);
        return response()->json($feedback, 200);
    }

    public function destroy($id)
    {
        $this->feedbackService->deleteFeedback($id);
        return response(null, 204);
    }
}
