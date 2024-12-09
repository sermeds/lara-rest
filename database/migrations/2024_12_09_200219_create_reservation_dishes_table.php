<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservation_dishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade'); // Связь с бронированием
            $table->foreignId('dish_id')->constrained()->onDelete('cascade'); // Связь с блюдом
            $table->integer('quantity'); // Количество блюд
            $table->decimal('price', 10, 2); // Цена блюда на момент заказа
            $table->timestamps(); // Временные метки
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_dishes');
    }
};
