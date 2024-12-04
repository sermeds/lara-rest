<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'cafe_id',
        'rating',
        'comment',
    ];

    protected $dates = ['deleted_at'];

    // Связь с моделью User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
