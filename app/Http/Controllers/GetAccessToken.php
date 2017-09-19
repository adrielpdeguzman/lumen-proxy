<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GetAccessToken extends Controller
{
    private $client;

    private $request;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @param Client $client
     */
    public function __construct(Request $request, Client $client)
    {
        $this->client = $client;
        $this->request = $request;
    }

    /**
     * Attempt to get an access token with the given credentials.
     *
     * @return Response
     */
    public function __invoke()
    {
        $response = $this->client->post(env('API_URL').'/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => env('CLIENT_ID'),
                'client_secret' => env('CLIENT_SECRET'),
                'username' => $this->request->input('username', $this->request->input('email')),
                'password' => $this->request->input('password'),
                'scope' => '',
            ],
            'http_errors' => false,
        ]);
        
        return response()->json(
            json_decode((string) $response->getBody(), true),
            $response->getStatusCode()
        );
    }
}
