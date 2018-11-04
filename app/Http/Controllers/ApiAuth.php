<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ApiAuth extends Controller
{
    /**
     * Function for retrieving generated Token
     */

    public function apiAuth()
    {
        $guzzle = new Client();

        $response = $guzzle->post('http://www.term.undabot/oauth/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET'),
                'scope' => '*',
            ],
        ]);

        return json_decode((string) $response->getBody(), true)['access_token'];
    }
}
