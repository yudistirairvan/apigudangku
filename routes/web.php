<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
$router->post('/login','UserController@login');
$router->post('/register','UserController@register');

$router->get('/barangs', 'BarangsController@index');
$router->post('/inputbarangs', 'BarangsController@store');
$router->get('/barangs/{id}', 'BarangsController@show');
$router->put('/editbarangs/{id}', 'BarangsController@update');
$router->delete('/hapusbarangs/{id}', 'BarangsController@destroy');