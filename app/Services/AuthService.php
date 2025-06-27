<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;
use Illuminate\Support\Facades\Http;

class AuthService
{
    use ConsumesExternalService;

    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = env('API_GATEWAY');
    }

    /**
     * Vérifie la validité du token
     */
    public function validateToken($token)
    {

        // dd($token);
        $response = $this->performRequest('GET', '/api/patients', [], [
            'Authorization' => "Bearer $token"
        ]);


        if (!is_object($response) || $response->getStatusCode() !== 200) {
            return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}