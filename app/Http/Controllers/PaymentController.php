<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Http\Requests\Update\UpdatePaymentRequest;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Traits\ReservationKeyGenerator;

class PaymentController extends Controller
{
    use ReservationKeyGenerator;

    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        return $this->paymentService->all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $payment = $this->paymentService->createPayment($validated);

        return response()->json($payment, 201, options:JSON_UNESCAPED_UNICODE);
    }

    public function show($id)
    {
        return $this->paymentService->findOrFail($id);
    }

    public function update(UpdatePaymentRequest $request, $id)
    {
        $validated = $request->validated();
        $payment = $this->paymentService->updatePayment($id, $validated);
        return response()->json($payment, 200, options:JSON_UNESCAPED_UNICODE);
    }

    public function destroy($id)
    {
        $this->paymentService->deletePayment($id);
        return response(null, 204);
    }
}
