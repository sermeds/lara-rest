<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\BonusPointsController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\AboutPageController;
use App\Http\Controllers\AuthController;

// Роуты для пользователей
Route::apiResource('users', UserController::class);

// Роуты для залов
Route::apiResource('halls', HallController::class);

// Роуты для столиков
Route::apiResource('tables', TableController::class);

// Роуты для событий
Route::apiResource('events', EventController::class);

// Роуты для акций
Route::apiResource('promotions', PromotionController::class);

// Роуты для бронирований
Route::apiResource('reservations', ReservationController::class);

// Роуты для платежей
Route::apiResource('payments', PaymentController::class);

// Роуты для отзывов
Route::apiResource('feedbacks', FeedbackController::class);

// Роуты для чеков
Route::apiResource('receipts', ReceiptController::class);

// Роуты для бонусных баллов
Route::apiResource('bonus-points', BonusPointsController::class);

// Роуты для блюд
Route::apiResource('dishes', DishController::class);

// Роуты для страницы "О кафе"
Route::get('about-page', [AboutPageController::class, 'show']);
Route::put('about-page', [AboutPageController::class, 'update']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/webhooks/payment', [PaymentWebhookController::class, 'handle']);

//Route::middleware(['auth:sanctum', 'role:admin,user'])->group(function () {
//    Route::apiResource('reservations', ReservationController::class);
//});

