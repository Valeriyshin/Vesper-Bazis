<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int         $id
 * @property string      $module
 * @property string      $key
 * @property string|null $value_ru
 * @property string|null $value_kk
 * @property string|null $value
 * @property string|null $hint
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class TemplateString extends Model
{
    protected $fillable = [
        'value_ru',
        'value_kk',
        'module',
        'key',
        'hint',
        'comment',
    ];

    private static ?string $lang = null;

    protected function value(): Attribute
    {
        return Attribute::make(
            get: function(mixed $value, array $attributes) {
                $prefix = self::$lang ?? app()->getLocale();
                return $attributes['value_' . $prefix];
            },
            set: function(string $value) {
                $prefix = self::$lang ?? app()->getLocale();
                return ['value_' . $prefix => $value];
            }
        );
    }

    public static function setup(string  $module,
                                 string  $key,
                                 string  $value,
                                 string  $lang,
                                 ?string $comment = null,
                                 ?string $hint = null,
                                 bool    $update = true): self
    {
        if (!$update) {
            $exits = self::query()
                ->where('module', $module)
                ->where('key', $key)
                ->exists();
            if ($exits) {
                throw new \Exception("Template string {$module}:{$key} already exists");
            }
        }
        $model = self::query()
            ->where('module', $module)
            ->where('key', $key)
            ->first();
        if (!$model) {
            $model = new self();
            $model->module = $module;
            $model->key = $key;
        }
        $val = 'value_' . $lang;
        $model->$val = $value;
        if ($comment !== null) $model->comment = $comment;
        if ($hint !== null) $model->hint = $hint;
        $model->save();
        return $model;
    }

    public static function loadModule(string $module): Collection
    {
        return self::query()
            ->where('module', $module)
            ->get()
            ->pluck('value', 'key');
    }

    public static function loadAll(): array
    {
        $result = [];
        $modules = self::query()
            ->pluck('module');
        foreach ($modules as $module) {
            $result[$module] = self::loadModule($module);
        }
        return $result;
    }

}
