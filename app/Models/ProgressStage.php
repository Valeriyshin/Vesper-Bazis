<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int        id
 * @property string     title_ru
 * @property string     title_kk
 * @property string     title
 * @property array|null details_ru
 * @property array|null details_kk
 * @property array|null details
 * @property array|null images
 * @property int        weight
 * @property Carbon     created_at
 * @property Carbon     updated_at
 */
class ProgressStage extends Model
{
    protected $casts = [
        'details_ru' => 'array',
        'details_kk' => 'array',
        'images'     => 'array',
    ];

    protected $fillable = [
        'title_ru',
        'title_kk',
        'details_ru',
        'details_kk',
        'images',
        'weight',
    ];

    protected $appends = ['title', 'details'];

    public static function listing(): Collection
    {
        return self::query()
            ->orderBy('weight')
            ->get();
    }

    /**
     * Localized title accessor
     */
    public function title(): Attribute
    {
        return Attribute::make(
            get: function() {
                $locale = app()->getLocale(); // ru или kk
                return $this->{"title_{$locale}"} ?? null;
            }
        );
    }

    /**
     * Localized details accessor
     */
    public function details(): Attribute
    {
        return Attribute::make(
            get: function() {
                $locale = app()->getLocale(); // ru или kk
                return $this->{"details_{$locale}"} ?? null;
            }
        );
    }

    protected static function booted(): void
    {
        static::creating(function($m) {
            if ($m->weight === null) {
                $m->weight = static::max('weight') + 1;
            }
        });
    }
}
