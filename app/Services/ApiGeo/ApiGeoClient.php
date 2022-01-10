<?php

namespace App\Services\ApiGeo;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class ApiGeoClient
{
    /** @var PendingRequest */
    protected PendingRequest $httpClient;

    public function __construct()
    {
        $this->httpClient = Http::baseUrl(config('api-geo.url'));
    }

    /**
     * Get cities from postal code
     *
     * @param string $postcode
     *
     * @return Collection
     */
    public function getCitiesFromPostcode(string $postcode) : Collection
    {
        $cities = $this->httpClient->get('/communes', [
            'codePostal' => $postcode,
            'fields' => 'nom',
        ])->json();

        return collect($cities)->map(function (array $city) : array {
            return Arr::except($city, ['code']);
        });
    }
}
