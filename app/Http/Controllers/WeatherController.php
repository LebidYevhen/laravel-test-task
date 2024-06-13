<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Stevebauman\Location\Facades\Location;

class WeatherController extends Controller
{
    public function index()
    {
        $location = Location::get();

        $weather = Redis::get('weather');

        if (!isset($weather)) {
            Redis::set(
                'weather',
                json_encode($this->getWeather($location->latitude, $location->longitude)),
                'EX',
                60
            );
        }

        return view('weather.index', [
            'weather' => Redis::get('weather')
        ]);
    }

    public function getWeather(string $latitude, string $longitude)
    {
        $res = Http::withQueryParameters([
            'key' => env('WEATHER_API'),
            'q' => $latitude . ',' . $longitude
        ])->get('http://api.weatherapi.com/v1/forecast.json');

        return $res->json();
    }
}
