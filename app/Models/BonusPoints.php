<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusPoints extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'points',
        'expiration_date',
    ];

    protected $dates = ['deleted_at'];

    // Связь с моделью User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
