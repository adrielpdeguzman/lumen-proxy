<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProxyRequest extends Controller
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
     * Proxy the request to the configured API URL.
     *
     * @param string $endpoint
     * @return Response
     */
    public function __invoke($endpoint)
    {
        $response = $this->client->request(
            $this->request->method(),
            env('API_URL')."/$endpoint",
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-Requested-With' => 'XMLHttpRequest',
                ],
                'query' => $this->request->query(),
                'json' => $this->request->all(),
                'http_errors' => false,
            ]
        );

        return response()->json(
            json_decode((string) $response->getBody(), true),
            $response->getStatusCode()
        );
    }
}
