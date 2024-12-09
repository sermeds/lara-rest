<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hall_id',
        'table_number',
        'capacity',
        'is_available',
        'x',
        'y',
        'base_price',
    ];

    protected $dates = ['deleted_at'];

    // Связь с моделью Hall
    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}
