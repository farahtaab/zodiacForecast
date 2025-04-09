<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Horoscope;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Carbon\Carbon;

class UpdateHoroscope extends Command
{
    protected $signature = 'horoscope:update';
    protected $description = 'Actualiza los horóscopos para todos los signos, idiomas y períodos';

    public function handle()
    {
        $signs = ["aquarius","pisces","aries","taurus","gemini","cancer","leo","virgo","libra","scorpio","sagittarius","capricorn"];
        $langs = ["es", "ca", "pt", "it", "fr", "de", "nl", "pl", "ru"];
        $times = ["today", "yesterday", "week", "month"];
        $today = Carbon::today();

        foreach ($signs as $sign) {
            foreach ($times as $time) {
                $response = Http::timeout(10)->get("https://www.astrology-zodiac-signs.com/api/call.php", [
                    'sign' => $sign,
                    'time' => $time,
                ]);

                $original = trim($response->body());

                if (empty($original)) continue;

                foreach ($langs as $lang) {
                    $translated = GoogleTranslate::trans($original, $lang, 'en');

                    Horoscope::updateOrCreate(
                        [
                            'sign' => $sign,
                            'lang' => $lang,
                            'time' => $time,
                            'date' => $today
                        ],
                        [
                            'prediction' => $translated
                        ]
                    );
                }

                $this->info("✔ $sign [$time] actualizado");
            }
        }

        $this->info('✅ Predicciones actualizadas correctamente.');
    }
}
