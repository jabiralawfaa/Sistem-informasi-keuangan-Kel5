<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Receipt extends Model
{
    protected $fillable = [
        'receipt_number',
        'title',
        'description',
        'amount',
        'issued_date',
        'issued_by',
        'recipient_name',
        'recipient_address'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'issued_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'receipt_id');
    }
}