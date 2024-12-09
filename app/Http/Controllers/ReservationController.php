<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Requests\Store\StoreReservationRequest;
use App\Http\Requests\Update\UpdateReservationRequest;
use App\Services\PaymentService;
use App\Services\ReservationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Traits\ReservationKeyGenerator;

class ReservationController extends Controller
{
    use ReservationKeyGenerator;

    protected $reservationService;
    protected $paymentService;

    public function __construct(ReservationService $reservationService, PaymentService $paymentService)
    {
        $this->reservationService = $reservationService;
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        return $this->reservationService->all();
    }

    public function store(StoreReservationRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $validated = $request->validated();

        $reservation = $this->reservationService->createReservation($validated);

        print("reservation blablbalblablalb" . $reservation . "\n");

        $paymentData  = [
            'reservation_id' => $reservation->id,
            'amount' => 500,
        ];

        $payment = $this->paymentService->createPayment($paymentData);

        $paymentLink = $this->paymentService->generatePaymentLink($payment->id);

        return response()->json($paymentLink, 201);
    }

    public function show($id)
    {
        return $this->reservationService->findOrFail($id);
    }

    public function update(UpdateReservationRequest $request, $id)
    {
        $validated = $request->validated();
        $reservation = $this->reservationService->updateReservation($id, $validated);
        return response()->json($reservation, 200);
    }

    public function destroy($id)
    {
        $this->reservationService->deleteReservation($id);
        return response(null, 204);
    }
}
