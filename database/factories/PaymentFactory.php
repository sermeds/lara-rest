<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'reservation_id' => Reservation::factory(),
            'amount' => $this->faker->randomFloat(2, 20, 500),
            'payment_status' => $this->faker->randomElement(['paid', 'pending', 'canceled']),
            'payment_date' => $this->faker->dateTime(),
            'payment_method' => $this->faker->randomElement(['card', 'cash']),
        ];
    }
}