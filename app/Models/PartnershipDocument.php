<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnershipDocument extends Model
{
    public const TYPES = [
        'mou' => 'MoU / Perjanjian',
        'invoice' => 'Invoice',
        'surat_jalan' => 'Surat Jalan',
        'kontrak' => 'Kontrak',
    ];

    protected $fillable = [
        'partnership_id',
        'type',
        'file_path',
        'original_name',
        'uploaded_by',
    ];

    public function partnership(): BelongsTo
    {
        return $this->belongsTo(Partnership::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
