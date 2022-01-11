<?php

namespace App\Http\Controllers;

use App\Services\ApiGeo\ApiGeoClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeoController extends Controller
{
    /** @var ApiGeoClient */
    protected ApiGeoClient $apiGeoClient;

    public function __construct(ApiGeoClient $apiGeoClient)
    {
        $this->apiGeoClient = $apiGeoClient;
    }

    /**
     * Get cities from postal code
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getCitiesFromPostcode(Request $request) : JsonResponse
    {
        $cities = $this->apiGeoClient->getCitiesFromPostcode($request->postcode);

        return response()->json($cities->pluck('nom'));
    }
}
