<?php

namespace App\Services\Calendarific;

use App\Exceptions\ClientException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CalendarificClient
{
    /** @var PendingRequest */
    protected PendingRequest $httpClient;

    public function __construct()
    {
        $this->httpClient = Http::baseUrl(config('calendarific.url'))
            ->withOptions(['query' => ['api_key' => config('calendarific.key')]])
            ->acceptJson()
        ;
    }

    /**
     * Get supported countries
     * 
     * @return Collection
     * 
     * @throws ClientException
     */
    public function getSupportedCountries() : Collection
    {
        try {
            $response = $this->httpClient->get('countries')->throw();
        } catch (RequestException $e) {
            throw new ClientException(__METHOD__, $this->parseErrors($e->response));
        }

        $supportedCountries = Arr::get($response->json(), 'response.countries');
        
        return collect($supportedCountries);
    }

    /**
     * Get supported languages
     * 
     * @return Collection
     * 
     * @throws ClientException
     */
    public function getSupportedLanguages() : Collection
    {
        try {
            $response = $this->httpClient->get('languages')->throw();
        } catch (RequestException $e) {
            throw new ClientException(__METHOD__, $this->parseErrors($e->response));
        }

        $supportedLanguages = Arr::get($response->json(), 'response.languages');
        
        return collect($supportedLanguages);
    }

    /**
     * Get holidays
     * 
     * @param string $country
     * @param int $year
     * 
     * @return Collection
     * 
     * @throws ClientException
     */
    public function getHolidays(string $country, int $year, string $type = null) : Collection
    {
        try {
            $response = $this->httpClient->get('holidays', [
                'country' => $country,
                'year' => $year,
                'type' => $type,
            ])->throw();
        } catch (RequestException $e) {
            throw new ClientException(__METHOD__, $this->parseErrors($e->response));
        }

        $holidays = Arr::get($response->json(), 'response.holidays');

        return collect($holidays);
    }

    /**
     * Parse errors from response
     * 
     * @param Response $response
     * 
     * @return array
     */
    protected function parseErrors(Response $response) : array
    {
        return [Arr::get($response->json(), 'meta.error_detail')];
    }
}
