<?php

namespace App\Http\Controllers;

use App\Services\Calendarific\CalendarificClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HolidaysController extends Controller
{
    /** @var string  */
    const DEFAULT_COUNTRY_ISO_3166 = 'FR';

    /** @var string */
    const DEFAULT_HOLIDAYS_TYPE = 'national';

    /** @var CalendarificClient */
    protected  $calendarificClient;

    public function __construct(CalendarificClient $calendarificClient)
    {
        $this->calendarificClient = $calendarificClient;
    }

    /**
     * Get supported countries
     *
     * @return JsonResponse
     */
    public function getSupportedCountries() : JsonResponse
    {
        $supportedCountries = $this->calendarificClient->getSupportedCountries();

        return response()->json($supportedCountries);
    }

    /**
     * Get supported languages
     *
     * @return JsonResponse
     */
    public function getSupportedLanguages() : JsonResponse
    {
        $supportedLanguages = $this->calendarificClient->getSupportedLanguages();

        return response()->json($supportedLanguages);
    }

    /**
     * Get holidays
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function getHolidays(Request $request) : JsonResponse
    {
        // Default request values
        $request->mergeIfMissing([
            'country' => self::DEFAULT_COUNTRY_ISO_3166,
            'year' => now()->year,
            'type' => self::DEFAULT_HOLIDAYS_TYPE,
        ]);

        $holidays = $this->calendarificClient->getHolidays($request->country, $request->year, $request->type);

        return response()->json($holidays);
    }
}
