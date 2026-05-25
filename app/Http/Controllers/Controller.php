<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\TemplateString;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class Controller
{

    const URL = 'https://bazis-online.kz/crmc/rest/leads/lead';

    public function home(): View
    {
        try { $this->runSometimes(); } catch (\Throwable $e) {}
        $strings = TemplateString::loadAll();
        $test = request()->exists('test');
        return view('home', compact('strings', 'test'));
    }

    public function checkCache()
    {
        $test = Cache::get('flats');
        dump($test);
    }

    public function progress(): Response
    {
        $progress = (int)TemplateString::query()
            ->where('module', 'progress')
            ->where('key', 'percentage')
            ->firstOrFail()
            ->value;
        return response(view('circle', compact('progress')))
            ->header('Content-Type', 'image/svg+xml');
    }

    public function check()
    {
        $strings = TemplateString::loadAll();
        return view('home', ['test' => true], compact('strings'));
    }

    public function flat(Request $request)
    {
        $data = $request->validate([
            'name'                      => 'required',
            'phone'                     => 'required',
            'utmUrlParams.utm_source'   => 'nullable',
            'utmUrlParams.utm_medium'   => 'nullable',
            'utmUrlParams.utm_campaign' => 'nullable',
            'utmUrlParams.utm_content'  => 'nullable',
            'utmUrlParams.utm_term'     => 'nullable',
        ]);

        $sendData = [
            'leadName'           => $data['name'],
            'phone'              => $data['phone'],
            'email'              => '',
            'advertisingChannel' => 'Личный кабинет',
            'requestWebsite'     => 'vesper.bazis.kz',
            'complex'            => 'Vesper',
            'description'        => $this->makeDescription($data),
        ];

        if ($data['utmUrlParams']['utm_source'] ?? false) $sendData['utmSource'] = $data['utmUrlParams']['utm_source'];
        if ($data['utmUrlParams']['utm_medium'] ?? false) $sendData['utmMedium'] = $data['utmUrlParams']['utm_medium'];
        if ($data['utmUrlParams']['utm_campaign'] ?? false) {
            $sendData['utmCampaign'] = $data['utmUrlParams']['utm_campaign'];
        }
        if ($data['utmUrlParams']['utm_content'] ?? false) {
            $sendData['utmContent'] = $data['utmUrlParams']['utm_content'];
        }
        if ($data['utmUrlParams']['utm_term'] ?? false) $sendData['utm_term'] = $data['utmUrlParams']['utm_term'];

        $token = Apartment::getToken();

        $data = Http::withOptions(['verify' => false])
            ->withToken($token)
            ->post(self::URL, $sendData)
            ->throw()
            ->body();
        Log::debug($data);
    }

    private function makeDescription(array $data): string
    {
        $desc = 'Form Flat';
        if ($data['utmUrlParams']['utm_source'] ?? false) {
            $desc .= ' | Utm Source: '
                     . $data['utmUrlParams']['utm_source'];
        }
        if ($data['utmUrlParams']['utm_medium'] ?? false) {
            $desc .= ' | Utm Medium: '
                     . $data['utmUrlParams']['utm_medium'];
        }
        if ($data['utmUrlParams']['utm_campaign'] ?? false) {
            $desc .= ' | Utm Campaign: '
                     . $data['utmUrlParams']['utm_campaign'];
        }
        if ($data['utmUrlParams']['utm_content'] ?? false) {
            $desc .= ' | Utm Content: '
                     . $data['utmUrlParams']['utm_content'];
        }
        if ($data['utmUrlParams']['utm_term'] ?? false) $desc .= ' | Utm Term: ' . $data['utmUrlParams']['utm_term'];
        return $desc;
    }

    private function runSometimes(): void
    {
        $lastRun = Cache::get('my_function_last_run');

        $shouldRun = false;

        if (!$lastRun || Carbon::parse($lastRun)->diffInHours(now()) >= 4) {
            $shouldRun = true;
        } elseif (random_int(1, 100) <= 10) {
            $shouldRun = true;
        }

        if ($shouldRun) {
            Cache::put('my_function_last_run', now());

            $this->reload();
        }
    }

    private function reload(): void
    {
        Artisan::call('app:reload-apartments --wipe');
    }
}
