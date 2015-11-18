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

Route::get('/welcome', function () {

    return view('welcome');
});



Route::group(['prefix' => 'auth'], function () {

    Route::get('login', 'Auth\AuthController@getLogin');
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', 'Auth\AuthController@getLogout');

    Route::get('register', 'Auth\AuthController@getRegister');
    Route::post('register', 'Auth\AuthController@postRegister');
});


Route::group(['prefix' => 'user'], function () {
    Route::get('edit', 'Profile\ProfilesController@editProfile');
    Route::post('edit', 'Profile\ProfilesController@saveProfile');

    Route::get('{id?}', 'Profile\ProfilesController@showProfile')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('edit', 'Profile\ProfilesController@editProfile');
    Route::post('edit', 'Profile\ProfilesController@saveProfile');

    Route::get('{id?}', 'Profile\ProfilesController@showProfile')->where('id', '[0-9]+');
});


Route::group(['prefix' => '/api'], function () {


    Route::get('get{type}','ApiController@getStaticValues')->where('type', 'Cities|Genres');
    Route::get('get{type}','ApiController@getDynamicValues')->where('type', 'Cinemas|Seances|Movies');
    Route::get('getImage/{id}-{width}x{height}.jpg','ApiController@getImage');


});


Route::controllers([
    'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'search'], function () {

    Route::get('users', 'Search\SearchController@getList');

});


