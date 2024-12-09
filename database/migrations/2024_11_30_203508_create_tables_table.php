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
        Schema::create('tables', function (Blueprint $table) {
            $table->id(); // id — уникальный идентификатор
            $table->foreignId('hall_id')->constrained('halls')->onDelete('cascade'); // связь с залом
            $table->integer('table_number'); // номер столика
            $table->integer('capacity'); // количество мест
            $table->boolean('is_available')->default(true); // доступность
            $table->integer('x'); // x координата
            $table->integer('y'); // y координата
            $table->integer('base_price'); // y координата
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
