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
$app->post('/auth', ['middleware' => 'cors', 'uses' => 'AuthController@auth']);
$app->group(['middleware' => ['cors', 'jwtauth', 'jwtrefresh']], function ($app) {

    $app->get('/users', 'App\Http\Controllers\PessoaController@users');
    $app->get('/users/logged', 'App\Http\Controllers\PessoaController@getUserLogged');
    
});

