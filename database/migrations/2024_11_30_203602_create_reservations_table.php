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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id(); // id — уникальный идентификатор
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // авторизованный пользователь
            $table->foreignId('table_id')->nullable()->constrained('tables')->onDelete('cascade'); // столик (если бронируется столик)
            $table->foreignId('hall_id')->nullable()->constrained('halls')->onDelete('cascade'); // зал (если бронируется зал)
            $table->date('reservation_date'); // дата бронирования
            $table->time('start_time'); // время начала
            $table->time('end_time'); // время окончания
            $table->string('status'); // статус бронирования
            $table->integer('guests_count'); // количество гостей
            $table->text('special_requests')->nullable(); // особые запросы
            $table->string('guest_name')->nullable(); // имя гостя
            $table->string('guest_phone')->nullable(); // телефон гостя
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
