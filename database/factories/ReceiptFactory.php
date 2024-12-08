<?php

namespace Database\Factories;

use App\Models\Receipt;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiptFactory extends Factory
{
    protected $model = Receipt::class;

    public function definition()
    {
        return [
            'payment_id' => Payment::factory(),
            'receipt_number' => $this->faker->unique()->uuid,
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'issued_at' => $this->faker->dateTime(),
            'tax_amount' => $this->faker->randomFloat(2, 1, 50),
            'pdf_url' => $this->faker->url(),
            'status' => $this->faker->randomElement(['issued', 'cancelled']),
        ];
    }
}
