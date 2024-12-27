<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShortLink extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'url',
        'code',
        'clicks',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    // public function getShortUrlAttribute(): string
    // {
    //     return route('short-link', $this->code);
    // }

    // public function getQrCodeAttribute(): string
    // {
    //     return 'https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=' . urlencode($this->short_url);
    // }

    // public function scopeActive($query)
    // {
    //     return $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
    // }

    // public function scopeExpired($query)
    // {
    //     return $query->where('expires_at', '<=', now());
    // }

    // public function scopeSearch($query, $search)
    // {
    //     return $query->where('name', 'like', "%$search%")
    //         ->orWhere('url', 'like', "%$search%")
    //         ->orWhere('code', 'like', "%$search%");
    // }
}
