<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnershipTransaction extends Model
{
    protected $fillable = [
        'partnership_id',
        'quantity_kg',
        'transaction_date',
        'notes',
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    public function partnership(): BelongsTo
    {
        return $this->belongsTo(Partnership::class);
    }
}
