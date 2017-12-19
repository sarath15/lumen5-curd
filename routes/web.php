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
    return $app->version();
});

$app->get('product', [
    'as' => 'product.index', 'uses' => 'ProductController@index'
]);

$app->post('product', [
    'as' => 'product.add', 'uses' => 'ProductController@add'
]);

$app->delete('product/{id}', [
    'as' => 'product.delete', 'uses' => 'ProductController@delete'
]);

$app->get('product/{id}', [
    'as' => 'product.get', 'uses' => 'ProductController@get'
]);

$app->put('product/{id}', [
    'as' => 'product.update', 'uses' => 'ProductController@update'
]);