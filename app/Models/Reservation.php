<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PENDING = 'pending'; // Ожидание оплаты
    const STATUS_SUCCESSFUL = 'successful'; // Оплачено
    const STATUS_CANCELLED = 'cancelled'; // Отменено

    protected $fillable = [
        'user_id',
        'table_id',
        'hall_id',
        'reservation_date',
        'start_time',
        'end_time',
        'status',
        'guests_count',
        'special_requests',
        'guest_name',
        'guest_phone',
        'total_price',
    ];

    protected $dates = ['deleted_at'];

    // Связь с моделью User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с моделью Table
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Связь с моделью Hall
    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'reservation_dishes')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }


}
