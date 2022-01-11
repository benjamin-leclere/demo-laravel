<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ClientException extends Exception
{
    public function __construct(string $method, array $errors) {
        parent::__construct("$method\n\t- " . join("\n\t- ", $errors));
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        Log::error("Client exception - $this->message");
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render() : JsonResponse
    {
        return response()->json([
            'error' => true,
            'type' => 'CLIENT',
        ], 503); // Service Unavailable
    }
}