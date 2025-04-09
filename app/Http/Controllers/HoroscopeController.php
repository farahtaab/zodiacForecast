<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Horoscope; 
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Log; 

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

    public function all(Request $request)
    {
        $lang = $request->get('lang', 'es');
        $time = $request->get('time', 'today');
        $today = now()->toDateString();

        // Logging para verificar la solicitud
        \Log::info('Fetching horoscopes for', ['lang' => $lang, 'time' => $time, 'date' => $today]);

        $results = Horoscope::select('sign', 'prediction') -> where('lang', $lang)
            ->where('time', $time)
            ->whereDate('date', $today)
            ->get();

        // Logging para verificar los resultados obtenidos
        \Log::info('Fetched horoscopes:', ['results' => $results]);

        return response()->json($results);
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
