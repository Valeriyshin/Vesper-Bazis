<?php

namespace App\Models;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * @property int         id
 * @property string|null blockName
 * @property string|null number
 * @property float       area
 * @property float       meterPrice
 * @property float       totalPrice
 * @property string|null apartmentCode
 * @property string|null status
 * @property int         floor
 * @property int         rooms
 * @property string|null crm_id
 * @property bool        isApartmentReserved
 * @property bool        hasJointVentureAgreement
 * @property bool        hasMortgage
 * @property array       images
 * @property array|null  payload
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 */
class Apartment extends Model
{
    const string SECRET    = '0L3QtSDRgdGD0LnRgtC1INGB0LLQvtC5INC90L7RgQ==';
    const array  URLS      = [
        'token'         => 'https://admin.sales.bazis.kz/server/new-auth.php',
        'getApartments' => 'https://bazis-online.kz/crmc/rest/prices/getApartments',
    ];
    const array  LOAD_DATA = [
        "complexCodes" => ["VSP","VSP1","VSP2"],
        "linesOnPage"  => 120,
    ];

    protected $casts = [
        'area'                     => 'float',
        'meterPrice'               => 'float',
        'totalPrice'               => 'float',
        'floor'                    => 'integer',
        'rooms'                    => 'integer',
        'isApartmentReserved'      => 'boolean',
        'hasJointVentureAgreement' => 'boolean',
        'hasMortgage'              => 'boolean',
        'images'                   => 'array',
        'payload'                  => 'array',
    ];

    protected $visible = [
        'blockName',
        'number',
        'area',
        'meterPrice',
        'totalPrice',
        'apartmentCode',
        'floor',
        'rooms',
        'crm_id',
        'images',
        'isApartmentReserved',
    ];

    protected $guarded = [
        'id',
        'crm_id',
        'payload',
        'created_at',
        'updated_at',
    ];

    public static function toFront(): string
    {
//        $models = self::query()
//            ->where('status', 'Свободна')
//            ->get();
//            $last = Cache::get('flats');
//            $now = Carbon::now();
//            $diff = $last
//                ? Carbon::parse($last)->diffInMinutes($now)
//                : 31;
//            if ($diff > 30) {
//                Artisan::call('app:reload-apartments --wipe');
//                Cache::set('flats', $now->toDateTimeString());
//            }

        return self::query()
//            ->where('isApartmentReserved', false)
            ->get()
            ->toJson();
    }

    public static function lastTime(): string
    {
        $last = Cache::get('flats');
        if(!$last)return '---';
        return Carbon::parse($last)->toDateTimeString();
    }

    public static function reloadAll(?Command $caller): bool
    {
        $token = self::getToken();
        Log::debug('token obtained');
        Log::debug($token);
        $caller?->info('token obtained');
        $response = Http::withOptions(['verify' => false])
            ->withToken($token)
            ->post(self::URLS['getApartments'], self::LOAD_DATA);
        if (!$response->successful()) {
            Log::error('getApartments failed on HTTP level');
            Log::error($response->status());
            Log::error($response->body());
            $caller?->error('getApartments failed on HTTP level');
            $caller?->error($response->status());
            $caller?->info($response->body());
            return false;
        }
        $caller?->info('response received');
        Log::debug('response received');
        Log::debug($response->body());
        $response = $response->json();
        if ($response['status'] !== 'SUCCESS') {
            Log::error('getApartments failed by status');
            $caller?->error('getApartments failed by status');
            $caller?->error($response['status']);
            $caller?->error($response['errorMessage']);
            Log::error($response['status'] ?? '');
            Log::error($response['errorMessage'] ?? '');
            Log::error(json_encode($response));
        }
        $caller?->info('response ok');
        $results = [
            'total'   => 0,
            'created' => 0,
            'updated' => 0,
        ];
        foreach ($response['data'] as $apartment) {
            $model = self::fromData($apartment);
            $results['total']++;
            if ($model->wasRecentlyCreated) {
                $results['created']++;
            } else $results['updated']++;
        }
        if ($caller) {
            $caller->info('loaded successfully');
            foreach ($results as $name => $value) {
                $caller->info("$name: $value");
            }
            $caller->newLine(2);
        }
        return true;
    }

    private static function fromData(array $data): Apartment
    {
        $crmId = $data['id'];
        $model = self::query()
            ->where('crm_id', $crmId)
            ->first();
        if (!$model) {
            $model = new Apartment();
            $model->crm_id = $crmId;
        }
        $model->fill($data);
        $model->payload = $data;
        $model->save();
        return $model;
    }

    public static function getToken(): string
    {
        $token = Http::asForm()
                     ->post(self::URLS['token'], ['secret_key' => self::SECRET])
                     ->json()['token'];
        $token = json_decode($token, true);
        return $token['access_token'];
    }
}
