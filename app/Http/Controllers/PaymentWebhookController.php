<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessWebhook;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:payments,id',
            'status' => 'required|string|in:success,failed',
        ]);

        ProcessWebhook::dispatch($data);

        return response()->json(['message' => 'Webhook accepted'], 202, options:JSON_UNESCAPED_UNICODE);
    }

}
