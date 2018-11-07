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

// Just Create APP Key By This Temporarily route
// $router->get('/key', function () {
//     return str_random(32);
// });

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('upload', 'ImagesController@UploadImage');
$router->get('url/{id}', 'ImagesController@getImageUrl');
$router->get('image/{id}', 'ImagesController@getImagePhoto');
$router->get('image/{url}/{width}x{height}', 'ImagesController@getImageWithCustomSize');