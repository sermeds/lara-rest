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
        Schema::create('halls', function (Blueprint $table) {
            $table->id(); // id — уникальный идентификатор
            $table->string('name'); // название зала
            $table->integer('capacity'); // вместимость
            $table->text('description')->nullable(); // описание
            $table->string('schemeImg')->nullable(); // путь к схеме зала
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
