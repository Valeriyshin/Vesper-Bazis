<?php

namespace Database\Seeders;

use App\Models\TemplateString;
use Illuminate\Database\Seeder;

class PlansLangSeeder extends Seeder
{

    const DATA = [
        'plans' => [
            'plan.residence'            => 'Резиденция',
            'plan.area'                 => 'Площадь',
            'plan.rooms'                => 'Комнаты',
            'plan.floor'                => 'Этаж',
            'plan.block'                => 'Блок',
            'plan.modal.area'           => 'Площадь',
            'plan.modal.floor'          => 'Floor',
            'plan.modal.block'          => 'Блок',
            'plan.modal.total'          => 'TOTAL PRICE',
            'plan.modal.download'       => 'скачать',
            'plan.modal.mail'           => 'отправить на почту',
            'plan.modal.share'          => 'Поделиться',
            'plan.modal.share.wa'       => 'отправить в WhatsApp',
            'plan.modal.share.tg'       => 'отправить в Telegram',
            'plan.modal.personal.h1'    => 'получите персональное предложение',
            'plan.modal.personal.h2'    => 'Оставьте заявку для индивидуальной консультации',
            'plan.modal.personal.name'  => 'Имя',
            'plan.modal.personal.phone' => '+7 (',
            'plan.modal.personal.agree' => 'Нажимая на кнопку «заказать звонок» вы принимаете <a href="https://sales.bazis.kz/privacy-policy" target="_blank">условия</a> обработки персональных данных',
            'plan.modal.call.button'    => 'Заказать звонок',
            'plan.modal.call.agree'     => 'Нажимая на кнопку «заказать звонок» вы принимаете <a href="https://sales.bazis.kz/privacy-policy" target="_blank">условия</a> обработки персональных данных',
        ],
    ];

    const NL2BR = [

    ];

    public function run(): void
    {
        foreach (self::DATA as $module => $data) {
            foreach ($data as $key => $value_ru) {
                $fullKey = implode('.', [$module, $key]);
                TemplateString::setup(
                    $module,
                    $key,
                    $value_ru,
                    'ru',
                    hint: in_array($fullKey, self::NL2BR)
                        ? 'переносы сохраняются'
                        : null
                );
            }
        }
    }
}
