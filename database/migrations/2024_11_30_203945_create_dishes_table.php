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
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название блюда
            $table->integer('weight')->unsigned(); // Выход блюда в граммах
            $table->decimal('cost', 10, 2); // Стоимость блюда
            $table->string('image')->nullable(); // Ссылка на изображение
            $table->enum('type', ['Salads', 'Snacks', 'Hot', 'Desserts', 'Drinks']); // Категория блюда
            $table->timestamps();
            $table->softDeletes(); // Мягкое удаление
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
