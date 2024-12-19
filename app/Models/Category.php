<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Traits\HasUniqueSlug;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Translatable;

    public $translatedAttributes = ['name', 'slug', 'description', 'status'];
    protected $fillable = [
        'parent_id',
        'thumbnail',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')
            ->with(['translations']);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getFormattedName(string $locale): string
    {
        $name = $this->translations->firstWhere('locale', $locale)?->name;
        $parentName = $this->parent?->translations->firstWhere('locale', $locale)?->name;

        return $parentName ? "{$parentName} > {$name}" : ($name ?? '-');
    }
}
