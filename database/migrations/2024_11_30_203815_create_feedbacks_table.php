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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('cafe_id'); // Если будет связь с отдельной таблицей кафе
            $table->tinyInteger('rating')->unsigned(); // Рейтинг от 1 до 5
            $table->text('comment')->nullable(); // Текст отзыва
            $table->timestamps();
            $table->softDeletes(); // Мягкое удаление
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
