<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hall_id',
        'name',
        'description',
        'start_time',
        'end_time',
        'is_public',
    ];

    protected $dates = ['deleted_at'];

    // Связь с моделью Hall
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
}
