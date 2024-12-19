<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function (Model $model) {
            self::audit('created', $model, []);
        });

        static::updated(function (Model $model) {
            self::audit('updated', $model, $model->getOriginal());
        });

        static::deleted(function (Model $model) {
            self::audit('deleted', $model, $model->getOriginal());
        });
    }

    protected static function audit($description, $model, $oldValues)
    {
        $newValues = $model->getAttributes();
        $serialize = function ($array) {
            return array_map(function ($value) {
                return is_scalar($value) ? $value : json_encode($value);
            }, $array);
        };

        $newValues = $serialize($newValues);
        $oldValues = $serialize($oldValues);

        $differences = array_diff_assoc($newValues, $oldValues);
        AuditLog::create([
            'description'   => $description,
            'subject_id'  => (string) $model->id ?? null,
            'subject_type'  => get_class($model) ?? null,
            'user_id'     => \Illuminate\Support\Facades\Auth::user()->id ?? null,
            'properties'    => json_encode([
                'old' => array_intersect_key($oldValues, $differences),
                'new' => $differences,
            ]),
            'host'          => request()->ip() ?? null,
            'user_agent'    => request()->userAgent() ?? null,
        ]);
    }
}
