<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
 * Proxy for OAuth2 token.
 */
$router->post('/oauth/token', 'GetAccessToken');

/**
 * Direct proxy to API_URL.
 */
$router->get('{endpoint:[\/\w\.-]*}', 'ProxyRequest');
$router->post('{endpoint:[\/\w\.-]*}', 'ProxyRequest');
$router->patch('{endpoint:[\/\w\.-]*}', 'ProxyRequest');
$router->put('{endpoint:[\/\w\.-]*}', 'ProxyRequest');
$router->delete('{endpoint:[\/\w\.-]*}', 'ProxyRequest');
$router->options('{endpoint:[\/\w\.-]*}', 'ProxyRequest');
