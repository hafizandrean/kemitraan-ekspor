<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partnership extends Model
{
    use HasFactory;

    public const WORKFLOW_STAGES = [
        'negotiation' => 'Negosiasi',
        'contract_signed' => 'Kontrak Ditandatangani',
        'shipping' => 'Pengiriman Barang',
        'completed' => 'Selesai',
    ];

    public const WORKFLOW_ORDER = [
        'negotiation',
        'contract_signed',
        'shipping',
        'completed',
    ];

    protected $fillable = [
        'product_id',
        'farmer_id',
        'exporter_id',
        'status',
        'workflow_stage',
        'total_nilai_kontrak',
        'file_kontrak',
        'rating',
        'review',
        'rated_at',
        'completed_at',
    ];

    protected $casts = [
        'total_nilai_kontrak' => 'decimal:2',
        'rated_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function exporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'exporter_id');
    }

    public function timelineEvents(): HasMany
    {
        return $this->hasMany(PartnershipTimelineEvent::class)->orderBy('created_at');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(PartnershipTransaction::class)->orderByDesc('transaction_date');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(PartnershipDocument::class)->latest();
    }

    public function isParticipant(User $user): bool
    {
        return $this->farmer_id === $user->id || $this->exporter_id === $user->id;
    }

    public function workflowStageLabel(): string
    {
        if ($this->status === 'pending') {
            return 'Menunggu Persetujuan';
        }

        if ($this->status === 'rejected') {
            return 'Ditolak';
        }

        return self::WORKFLOW_STAGES[$this->workflow_stage] ?? 'Aktif';
    }

    public function isSuccessful(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return in_array($this->status, ['rejected', 'cancelled'], true);
    }
}
