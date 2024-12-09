<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationDish extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'dish_id',
        'quantity',
        'price',
    ];

    // Связь с моделью Reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // Связь с моделью Dish
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}

