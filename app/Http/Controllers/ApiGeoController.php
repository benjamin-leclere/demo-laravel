<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\ApiGeo\ApiGeoClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiGeoController extends Controller
{
    private $apiGeoClient;

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
        City::upsert([
            ['postcode' => '60280', 'name' => 'Venette'],
            ['postcode' => '60280', 'name' => 'Margny'],
        ], ['name']);

        $cities = $this->apiGeoClient->getCitiesFromPostcode($request->postcode);

        return response()->json($cities);
    }
}
