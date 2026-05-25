<?php

namespace Database\Seeders;

use App\Models\ProgressStage;
use Illuminate\Database\Seeder;

class KkPsSeeder extends Seeder
{

    const DATA = [
        'ОКТЯБРЬ 2025'  => [
            'title'   => 'ҚАЗАН 2025',
            'details' => [
                'Үйлердің монолитті темірбетон қаңқаларының монтажы жүргізілуде.',
                'Қабырғалардың тас қалауы жүргізілуде.',
                'Шатырды орнату жұмыстары жүргізілуде.',
            ],
        ],
        'СЕНТЯБРЬ 2025' => [
            'title'   => 'ҚЫРКҮЙЕК 2025',
            'details' => [
                'Қабырғалардың тас қалауы жүргізілуде.',
                'Ішкі құрылыс-монтаж жұмыстары жүргізілуде.',
            ],
        ],
        'АВГУСТ 2025'   => [
            'title'   => 'ТАМЫЗ 2025',
            'details' => [
                'Қабырғалардың тас қалауы жүргізілуде.',
                'Ішкі құрылыс-монтаж жұмыстары жүргізілуде.',
            ],
        ],
    ];


    public function run(): void
    {
        foreach (self::DATA as $key=>$data){
            $rec = ProgressStage::query()
                ->where('title_ru',$key)
                ->firstOrFail();
            $rec->title_kk = $data['title'];
            $rec->details_kk = $data['details'];
            $rec->save();
        }
    }
}
