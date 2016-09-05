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

$app->get('/', function () use ($app) {
    return response()->json([
        'status' => 'SUCCESS',
        'message' => 'All Izz Well!'
    ]);
});

$app->get('/test', function () {
    // $config = config('key');
    return response()->json(config());
});

// APIs
$app->group(['namespace' => 'App\Http\Controllers','middleware' => ['auth'], 'prefix' => 'api'], function () use ($app) {
    $app->get('/transactions', 'TransactionsController@getAll');
    $app->get('/transactions/{id}', 'TransactionsController@getById');
    $app->post('/transactions', 'TransactionsController@create');
});

$app->group(['middleware' => ['auth']], function () use ($app) {
    $app->get('/checkout', function() {
        $user = Auth::user();
        return view('checkout', ['data' => $user]);
    });
});
