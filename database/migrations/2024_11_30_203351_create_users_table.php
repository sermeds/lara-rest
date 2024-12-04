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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id — уникальный идентификатор
            $table->string('username'); // имя пользователя
            $table->string('email')->unique(); // email
            $table->string('password'); // хэшированный пароль
            $table->string('role'); // роль пользователя (например, "клиент", "администратор", "сотрудник")
            $table->string('phone_number')->nullable(); // номер телефона
            $table->timestamp('date_joined')->nullable(); // дата регистрации
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // removed (мягкое удаление)
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
