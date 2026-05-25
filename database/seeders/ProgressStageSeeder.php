<?php

namespace Database\Seeders;

use App\Models\ProgressStage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgressStageSeeder extends Seeder
{
    const DATA = [
        [
            'title'   => 'ОКТЯБРЬ 2025',
            'details' => [
                'Ведется монтаж монолитных железобетонных каркасов домов.',
                'Ведется каменная кладка стен.',
                'Ведутся работы по устройству кровли.',
            ],
            'imgs'    => [
                '/stages/10.25/1.jpg',
                '/stages/10.25/2.jpg',
                '/stages/10.25/3.jpg',
            ],
        ],
        [
            'title'   => 'СЕНТЯБРЬ 2025',
            'details' => [
                'Ведется каменная кладка стен.',
                'Ведутся внутренние строительно-монтажные работы.',
            ],
            'imgs'    => [
                '/stages/09.25/1.jpg',
                '/stages/09.25/2.jpg',
                '/stages/09.25/3.jpg',
            ],
        ],
        [
            'title'   => 'АВГУСТ 2025',
            'details' => [
                'Ведется каменная кладка стен.',
                'Ведутся внутренние строительно-монтажные работы.',
            ],
            'imgs'    => [
                '/stages/08.25/1.jpg',
                '/stages/08.25/2.jpg',
                '/stages/08.25/3.jpg',
                '/stages/08.25/4.jpg',
            ],
        ],
    ];

    public function run(): void
    {
        foreach (self::DATA as $data) {
            $model = new ProgressStage();
            $model->title_ru = $data['title'];
            $model->title_kk = $data['title'];
            $model->details_ru = $data['details'];
            $model->details_kk = $data['details'];
            $imgs = [];
            foreach ($data['imgs'] as $img) {
                $imgs[] = $this->storeImage($img);
            }
            $model->images = $imgs;
            $model->save();
        }
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
