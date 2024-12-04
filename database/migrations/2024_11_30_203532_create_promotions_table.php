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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id(); // id — уникальный идентификатор
            $table->string('name'); // название акции
            $table->text('description')->nullable(); // описание
            $table->integer('discount_percentage')->nullable(); // размер скидки
            $table->date('start_date'); // начало акции
            $table->date('end_date'); // окончание акции
            $table->foreignId('hall_id')->nullable()->constrained('halls')->onDelete('cascade'); // связь с залом
            $table->boolean('is_active')->default(true); // активность
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
