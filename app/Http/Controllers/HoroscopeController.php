<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

class HoroscopeController extends Controller
{
    public function show(Request $request)
    {
        $sign = $request->get('sign', 'aquarius');
        $lang = $request->get('lang', 'es');
        $time = $request->get('time', 'today');

        $translated = $this->getTranslatedPrediction($sign, $lang, $time);

        return view('horoscope', [
            'sign' => ucfirst($sign),
            'prediction' => $translated,
            'lang' => $lang,
            'time' => $time,
        ]);
    }

    public function landing()
    {
        return view('landing');
    }

    public function api(Request $request)
    {
        $sign = $request->get('sign', 'aquarius');
        $lang = $request->get('lang', 'es');
        $time = $request->get('time', 'today');

        $translated = $this->getTranslatedPrediction($sign, $lang, $time);

        return response()->json([
            'prediction' => $translated,
            'sign' => ucfirst($sign),
            'lang' => $lang,
            'time' => $time,
        ]);
    }

   
    private function getTranslatedPrediction(string $sign, string $lang, string $time): string
    {
        $today = now()->toDateString();
    
        $horoscope = Horoscope::where('sign', $sign)
            ->where('lang', $lang)
            ->where('time', $time)
            ->whereDate('date', $today)
            ->first();
    
        return $horoscope?->prediction ?? 'No prediction available yet.';
    }
}
