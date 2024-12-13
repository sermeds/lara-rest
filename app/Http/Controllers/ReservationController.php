<?php

namespace App\Http\Controllers;

use App\Exceptions\ReservationConflictException;
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

        try {
            $reservation = $this->reservationService->createReservation($validated);

            $paymentData = [
                'reservation_id' => $reservation->id,
                'amount' => $reservation->total_price,
            ];

            $payment = $this->paymentService->createPayment($paymentData);

            $paymentLink = $this->paymentService->generatePaymentLink($payment->id);

            return response()->json($paymentLink, 201, options:JSON_UNESCAPED_UNICODE);

        } catch (ReservationConflictException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'suggested_time' => $e->getData()['suggested_time'] ?? null,
            ], 409, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            // Логируем ошибку
            Log::error('Ошибка создания бронирования', [
                'error' => $e->getMessage(),
            ]);

            return response()->json(['message' => "Ошибка создания бронирования."], 409, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function show($id)
    {
        return $this->reservationService->findOrFail($id);
    }

    public function update(UpdateReservationRequest $request, $id)
    {
        $validated = $request->validated();
        $reservation = $this->reservationService->updateReservation($id, $validated);
        return response()->json($reservation, 200, options:JSON_UNESCAPED_UNICODE);
    }

    public function destroy($id)
    {
        $this->reservationService->deleteReservation($id);
        return response(null, 204);
    }
}
