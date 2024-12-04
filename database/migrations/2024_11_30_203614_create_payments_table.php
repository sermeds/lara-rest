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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // id — уникальный идентификатор
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade'); // связь с бронированием
            $table->decimal('amount', 10, 2); // сумма оплаты
            $table->string('payment_status'); // статус оплаты
            $table->timestamp('payment_date'); // дата оплаты
            $table->string('payment_method'); // метод оплаты
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
