<?php

namespace Database\Seeders;

use App\Models\FamilyClub;
use Illuminate\Database\Seeder;

class KkFcSeeder extends Seeder
{
    const DATA = [
        'INTELLECTUAL FITNESS%' => 'INTELLECTUAL FITNESS SUITE — әрбір деталі ойластырылған бутиктік wellness club форматынан шабыт алған кеңістік.Жеке еркіндік пен технология үйлесімділігі. Интерьердің әр бөлшегі, жарық, ауа температурасы мен ылғалдылықтың үйлесімділігі - сіздің энергияңызды қалпына келтіруге бағытталған.',
        'FIRST STEP CLUB%' => 'FIRST STEP CLUB – ең кішкентайларға арналған, сиқыр элементтері бар мультисенсорлық кеңістік. Мұнда Vesper резиденттерінің сүйікті балалары алғашқы қадамдарын жасайды: құрдастарымен ойындар әлеміне, қоршаған орта туралы білім әлеміне және ең бастысы – өз ішкі әлеміне, қабілеттері мен таланттарын аша отырып.',
        'RESIDENTS LOUNGE%' => "RESIDENTS LOUNGE & COWORKING LIBRARY\nЕуропалық салондар дәстүрлерінің заманауи интерпретациясы. Пікірлес қауымдастықта үстел ойындарын ойнауға арналған жеке board games space."
    ];

    public function run(): void
    {
        foreach (self::DATA as $key => $value) {
            FamilyClub::query()
                ->where('text_ru', 'LIKE', $key)
                ->update(['text_kk' => $value]);
        }
    }
}
