<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Setting extends Model
{
    use Auditable, HasUuids;

    protected $fillable = [
        'group',
        'key',
        'value',
        'attributes',
        'type',
    ];

    protected $casts = [
        'attributes' => 'array',
    ];
}
