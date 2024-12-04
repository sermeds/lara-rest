<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'discount_percentage',
        'start_date',
        'end_date',
        'hall_id',
        'is_active',
    ];

    protected $dates = ['deleted_at'];

    // Связь с моделью Hall
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
}
