<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmer_id',
        'exporter_id',
        'product_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the farmer (Petani) in the conversation.
     */
    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    /**
     * Get the exporter (Eksportir) in the conversation.
     */
    public function exporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'exporter_id');
    }

    /**
     * Get the product (if any) linked to this conversation.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get all messages in this conversation.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get all reports linked to this conversation.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Scope a query to sort conversations by latest activity.
     */
    public function scopeLatestActive($query)
    {
        return $query->orderByRaw('COALESCE(last_message_at, updated_at) DESC');
    }

    /**
     * Count unread messages for a specific user in this conversation.
     */
    public function unreadMessagesCountFor(User $user): int
    {
        return $this->messages()
            ->where('is_read', false)
            ->where('sender_id', '!=', $user->id)
            ->count();
    }

    /**
     * Get the latest message in this conversation.
     */
    public function latestMessage(): ?Message
    {
        return $this->messages()->latest()->first();
    }
}