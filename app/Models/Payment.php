<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reservation_id',
        'amount',
        'payment_status',
        'payment_date',
        'payment_method',
    ];

    protected $dates = ['deleted_at'];

    // Связь с моделью Reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
