<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'account_tier',
        'premium_expires_at',
        'verification_status',
        'verification_document_path',
        'phone',
        'is_trusted_farmer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_trusted_farmer' => 'boolean',
        'premium_expires_at' => 'datetime',
    ];

    /**
     * Get the products for the user.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the partnerships for the user.
     */
    public function partnerships(): HasMany
    {
        return $this->hasMany(Partnership::class, 'exporter_id');
    }

    public function incomingPartnerships(): HasMany
    {
        return $this->hasMany(Partnership::class, 'farmer_id');
    }

    public function systemNotifications(): HasMany
    {
        return $this->hasMany(SystemNotification::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'favorites')
            ->withTimestamps();
    }

    public function isPremium(): bool
    {
        return app(\App\Services\PremiumAccessService::class)->isPremium($this);
    }

    public function premiumBadgeLabel(): string
    {
        if ($this->role === 'admin') {
            return 'Admin';
        }

        return $this->isPremium() ? 'Premium' : 'Free';
    }
}

