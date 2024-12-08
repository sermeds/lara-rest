<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_id',
        'receipt_number',
        'amount',
        'issued_at',
        'tax_amount',
        'pdf_url',
        'status',
    ];

    protected $dates = ['deleted_at'];

    // Связь с моделью Payment
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
