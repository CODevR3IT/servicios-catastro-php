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

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->group(['prefix' => 'sipredi'], function () use ($router) {
        $router->get('perito-validacion/{id}', 'SiprediController@show');
    });
    $router->group(['prefix' => 'beneficios'], function () use ($router) {
        $router->post('aplicados', 'BeneficiosController@getAplicados');
    });
});

$router->group(['prefix' => 'PRO/Fiscal/Lotes'], function () use ($router) {
    $router->get('MasivoService', 'LotesPredialController@server');
    $router->post('MasivoService', 'LotesPredialController@server');
});