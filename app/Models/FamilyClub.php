<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int         id
 * @property int         weight
 * @property string      image
 * @property string|null text_ru
 * @property string|null text_kk
 * @property string|null text
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 */
class FamilyClub extends Model
{
    protected $fillable = ['weight', 'image', 'text_ru', 'text_kk'];

    private static ?string $lang = null;

    /**
     * @return Collection<self>
     */
    public static function listing():Collection
    {
        return self::query()
            ->orderBy('weight')
            ->get();
    }

    protected function text(): Attribute
    {
        return Attribute::make(
            get: function(mixed $value, array $attributes) {
                $prefix = self::$lang ?? app()->getLocale();
                return $attributes['text_' . $prefix];
            },
            set: function(string $value) {
                $prefix = self::$lang ?? app()->getLocale();
                return ['text_' . $prefix => $value];
            }
        );
    }

    protected static function booted(): void
    {
        static::creating(function ($m) {
            if ($m->weight === null) {
                // если порядок должен быть «внутри модуля»
                $m->weight = static::max('weight') + 1;
            }
        });
    }


}
