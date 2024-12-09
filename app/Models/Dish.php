<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dish extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'weight',
        'cost',
        'image',
        'type',
    ];

    protected $dates = ['deleted_at'];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_dishes')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

}
