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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
            $table->string('receipt_number')->unique(); // Уникальный номер чека
            $table->decimal('amount', 10, 2); // Сумма в чеке
            $table->timestamp('issued_at'); // Время выдачи чека
            $table->decimal('tax_amount', 10, 2)->nullable(); // Налог (опционально)
            $table->string('pdf_url')->nullable(); // Ссылка на PDF-чек
            $table->enum('status', ['issued', 'cancelled'])->default('issued'); // Статус чека
            $table->timestamps();
            $table->softDeletes(); // Мягкое удаление
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
