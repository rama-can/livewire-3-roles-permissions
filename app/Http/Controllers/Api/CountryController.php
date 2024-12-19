<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $country = 'https://raw.githubusercontent.com/rama-can/country-json-format/refs/heads/main/country.json';

        $response = Http::get($country);

        if ($response->successful()) {
            $countries = collect($response->json())->map(function ($country) {
                $country['image'] = 'https://cdn.jsdelivr.net/npm/country-flag-emoji-json@2.0.0/dist/images/' . strtoupper($country['code']) . '.svg';

                unset($country['flag']);

                return $country;
            });

            return response()->json($countries);
        }

        return response()->json(['error' => 'Could not fetch data'], 500);
    }
}
