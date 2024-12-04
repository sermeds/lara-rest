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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // id — уникальный идентификатор
            $table->foreignId('hall_id')->constrained('halls')->onDelete('cascade'); // связь с залом
            $table->string('name'); // название события
            $table->text('description')->nullable(); // описание
            $table->timestamp('start_time'); // начало события
            $table->timestamp('end_time'); // окончание события
            $table->boolean('is_public')->default(true); // доступность для бронирования
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
