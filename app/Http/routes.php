<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {

    if (Auth::check())
        return view('welcome');
    else
        return view('auth.login');
});


Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::controllers([
    'password' => 'Auth\PasswordController',
]);

Route::get('/welcome', function () {

    return view('welcome');
});

Route::get('user/{id?}', 'Profile\ProfilesController@showProfile')->where('id', '[0-9]+');


Route::get('user/edit', 'Profile\ProfilesController@editProfile');
Route::post('user/edit', 'Profile\ProfilesController@saveProfile');
