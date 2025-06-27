<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumesExternalService
{


    /**
     * Send a request to any service
     * @return string
     */
    public function performRequest($method, $requestUrl, $formparams = [], $headers = [])
    {

        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        // if ($this->secret) {
        //     $headers['authorization'] = $this->secret;
        // }

        $response = $client->request($method, $requestUrl, [
            'headers' => $headers,
            'json' => $formparams,
            'timeout' => 50, // Timeout de 10 secondes pour éviter les longues attentes
            'connect_timeout' => 50,
        ]);

        return $response;
    }
}
