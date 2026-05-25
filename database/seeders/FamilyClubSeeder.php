<?php

namespace Database\Seeders;

use App\Models\FamilyClub;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FamilyClubSeeder extends Seeder
{

    const DATA = [
        [
            'img'  => 'fc.jpg',
            'text' => "INTELLECTUAL FITNESS SUITE – пространство, вдохновленное бутиковыми wellness club, где все продумано до мелочей. Приватность сочетается с технологичностью. Каждая деталь интерьера, свет, гармония температуры воздуха и влажности – работают на восстановление Вашей энергии.",
        ],
        [
            'img'  => 'fc2.jpg',
            'text' => "FIRST STEP CLUB – мультисенсорное пространство с элементами волшебства для самых маленьких. Здесь любимые резиденты Vesper делают свои первые шаги: в мир игр со сверстниками, в мир знаний об окружающем и главное – в свой внутренний мир, раскрывая таланты.",
        ],
        [
            'img'  => 'fc3.jpg',
            'text' => "RESIDENTS LOUNGE & COWORKING LIBRARY \n Традиции европейских салонов в современном прочтении. Отдельная board games space для настольных игр в like-minded кругу.",
        ],
    ];

    public function run(): void
    {
        foreach (self::DATA as $item) {
            $model = new FamilyClub();
            $model->image = static::storeImage($item['img']);
            $model->text_ru = $item['text'];
            $model->text_kk = $item['text'];
            $model->save();
        }
    }

    private function storeImage(string $filename):string
    {
        do{
            $unique=Str::random().'.'.pathinfo($filename, PATHINFO_EXTENSION);
        }while(file_exists(storage_path('app/public/fc/'.$unique)));
        copy(
            resource_path('blocks/points/assets/'.$filename),
            storage_path('app/public/fc/'.$unique)
        );
        return 'fc/'.$unique;
    }
}
