<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [ // fillable: mengatur data (field) yang boleh diisi
        'user_id',
        'title',
        'type', // 'monthly', 'quarterly', 'annual'
        'period_start',
        'period_end',
        'total_income',
        'total_expenses',
        'net_income',
        'content',
        'file_path'
    ];

    protected $casts = [ // casts: mengubah format data otomatis
        'period_start' => 'date',
        'period_end' => 'date',
        'total_income' => 'decimal:2',
        'total_expenses' => 'decimal:2',
        'net_income' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi Many to One dengan tabel user (1 user dapat membuat banyak laporan)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}