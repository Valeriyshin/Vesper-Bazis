<?php

namespace Database\Seeders;

use App\Models\TemplateString;
use Illuminate\Database\Seeder;

class KkLangSeeder2 extends Seeder
{

    const DATA = [
        'progress_modal' => [
            'h1'     => 'Progress',
            'finish' => 'Құрылыстың аяқталу мерзімі - 2027 ж. ақпан.',
        ],
    ];

    public function run(): void
    {
        foreach (self::DATA as $module => $data) {
            foreach ($data as $key => $value_kk) {
                TemplateString::setup(
                    $module,
                    $key,
                    $value_kk,
                    'kk',
                );
            }
        }

    }
}
