<?php

namespace Database\Seeders;

use App\Models\ProgressStage;
use App\Models\TemplateString;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgressStageSeeder2 extends Seeder
{
    const READINESS = 45;

    const DATA = [
        [
            'title'   => 'НОЯБРЬ 2025',
            'details' => [
                'Ведется монтаж монолитных железобетонных каркасов домов.',
                'Ведется каменная кладка стен.',
                'Ведутся внутренние строительно-монтажные работы.',
            ],
            'imgs'    => [
                '/stages/11.25/1.jpg',
                '/stages/11.25/2.jpg',
                '/stages/11.25/3.jpg',
            ],
        ],
        [
            'title'   => 'ҚАРАША 2025',
            'details' => [
                'Ғимараттардың монолитті темір бетон қаңқаларын салу жұмыстары жүргізілуде.',
                'Қабырғаларды тастан қалау жұмыстары атқарылуда.',
                'Ішкі құрылыс-монтаж жұмыстары жүргізілуде.',
            ],
            'imgs'    => [
                '/stages/11.25/1.jpg',
                '/stages/11.25/2.jpg',
                '/stages/11.25/3.jpg',
            ],
        ],
    ];

    public function run(): void
    {
//        $model = new ProgressStage();
//        $model->title_ru = self::DATA[0]['title'];
//        $model->title_kk = self::DATA[1]['title'];
//        $model->details_ru = self::DATA[0]['details'];
//        $model->details_kk = self::DATA[1]['details'];
//        $imgs = [];
//        foreach (self::DATA[0]['imgs'] as $img) {
//            $imgs[] = $this->storeImage($img);
//        }
//        $model->images = $imgs;
//        $model->save();
//        TemplateString::setup('progress','percentage',self::READINESS,'ru');
//        TemplateString::setup('progress','percentage',self::READINESS,'kk');
        $pss = ProgressStage::all();
        foreach ($pss as $n=>$ps) {
            $ps->weight = $n+2;
            $ps->save();
        }
        $ps->weight = 1;
        $ps->save();
    }

    private function storeImage(string $publicPath): string
    {
        do {
            $unique = Str::random() . '.' . pathinfo($publicPath, PATHINFO_EXTENSION);
        } while (file_exists(storage_path('app/public/progress/' . $unique)));
        copy(
            public_path($publicPath),
            storage_path('app/public/progress/' . $unique)
        );
        return 'progress/' . $unique;
    }
}
