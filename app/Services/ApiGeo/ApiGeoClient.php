<?php

namespace App\Services\ApiGeo;

use Illuminate\Support\Facades\Http;

class ApiGeoClient
{
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = Http::baseUrl(config('api-geo.url'));
    }

    /**
     * Get cities from postal code
     *
     * @param string $postcode
     *
     * @return array
     */
    public function getCitiesFromPostcode(string $postcode) : array
    {
        return $this->httpClient->get('/communes', [
            'codePostal' => $postcode,
            'fields' => 'nom',
        ])->json();
    }
}
