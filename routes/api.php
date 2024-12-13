<?php

use App\Http\Controllers\PaymentWebhookController;
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
use App\Http\Controllers\AdminController;

// Роуты для залов
Route::apiResource('halls', HallController::class)->only(['index', 'show']);

// Роуты для столиков
Route::apiResource('tables', TableController::class)->only(['index', 'show']);

// Роуты для событий
Route::apiResource('events', EventController::class)->only(['index', 'show']);

// Роуты для акций
Route::apiResource('promotions', PromotionController::class)->only(['index', 'show']);

// Роуты для бронирований
Route::apiResource('reservations', ReservationController::class)->only(['store']);

// Роуты для блюд
Route::apiResource('dishes', DishController::class)->only(['index', 'show']);

// Роуты для страницы "О кафе"
Route::get('about-page', [AboutPageController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/webhooks/payment', [PaymentWebhookController::class, 'handle']);

Route::middleware(['auth:sanctum', 'role:admin,user'])->group(function () {
    // Роуты для бонусных баллов
    Route::apiResource('bonus-points', BonusPointsController::class);
    // Роуты для отзывов
    Route::apiResource('feedbacks', FeedbackController::class);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Роуты для пользователей
    Route::apiResource('users', UserController::class);
    // Роуты для залов
    Route::apiResource('halls', HallController::class)->except(['index', 'show']);
    // Роуты для столиков
    Route::apiResource('tables', TableController::class)->except(['index', 'show']);
    // Роуты для событий
    Route::apiResource('events', EventController::class)->except(['index', 'show']);
    // Роуты для акций
    Route::apiResource('promotions', PromotionController::class);
    // Роуты для бронирований
    Route::apiResource('reservations', ReservationController::class)->except(['store']);
    // Роуты для платежей
    Route::apiResource('payments', PaymentController::class)->except(['index', 'show']);
    // Роуты для чеков
    Route::apiResource('receipts', ReceiptController::class);
    // Роуты для блюд
    Route::apiResource('dishes', DishController::class)->except(['index', 'show']);
    Route::put('about-page', [AboutPageController::class, 'update']);

    Route::get('/admin/data', [AdminController::class, 'index']);
    Route::post('/admin/clear-cache', [AdminController::class, 'clearCache']);
});
