<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $dates = ['created_at'];

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'balance',
        'description'
    ];

    /**
     * Get the formatted date and time.
     *
     * @return string
     */
    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at->format('d-m-Y h:i A');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
