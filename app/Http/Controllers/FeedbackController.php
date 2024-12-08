<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Http\Requests\Store\StoreFeedbackRequest;
use App\Http\Requests\Update\UpdateFeedbackRequest;

class FeedbackController extends Controller
{
    public function index()
    {
        return Feedback::all();
    }

    public function store(StoreFeedbackRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $validated = $request->validated();
        $feedback = Feedback::create($validated);
        return response()->json($feedback, 201);
    }

    public function show(Feedback $feedback)
    {
        return $feedback;
    }

    public function update(UpdateFeedbackRequest $request, $id)
    {
        $validated = $request->validated();
        $feedback = Feedback::findOrFail($id);
        $feedback->update($validated);
        return response()->json($feedback, 200);
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return response(null, 204);
    }
}
