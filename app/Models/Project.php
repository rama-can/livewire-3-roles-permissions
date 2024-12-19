<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'tags',
        'url',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && Storage::exists($this->thumbnail)) {
            return Storage::url($this->thumbnail);
        } else {
            return asset('images/placeholder-image.webp');
        }
    }
}
