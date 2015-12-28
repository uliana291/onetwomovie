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


Route::group(['middleware' => 'before'], function () {
    Route::get('google', 'Auth\GoogleAuthController@addToCalendar');


    Route::get('/', function () {

        if (Auth::check())
            return redirect()->route('search_user');
        else
            return view('auth.login');
    });

    Route::get('/welcome', function () {

        return view('welcome');
    });

    Route::group(['prefix' => 'auth'], function () {

        // Password reset link request routes...
        Route::get('password/email', 'Auth\PasswordController@getEmail');
        Route::post('password/email', 'Auth\PasswordController@postEmail');

        // Password reset routes...
        Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
        Route::post('password/reset', 'Auth\PasswordController@postReset');
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

        Route::post('{id}', 'Profile\ProfilesController@sendMessage')->where('id', '[0-9]+');
        Route::get('messages', 'Profile\ProfilesController@showMessages');
        Route::get('messages/{dialog}', 'Profile\ProfilesController@showDialog')->where('dialog', '[0-9]+');
        Route::post('messages/{dialog}', 'Profile\ProfilesController@sendMessage')->where('dialog', '[0-9]+');
        Route::get('messages/{dialog}/seance/{id}', 'Profile\ProfilesController@showSeanceInfo')->where('dialog',
            '[0-9]+')->where('id', '[0-9]+');
        Route::post('messages/{dialog}/seance/{id}', 'Auth\GoogleAuthController@addToCalendar')->where('dialog',
            '[0-9]+')->where('id', '[0-9]+');
        Route::get('calendar/{dialog}/{id}', ['as' => 'calendar_back', 'uses' => 'Auth\GoogleAuthController@addToCalendar'])->where('dialog',
            '[0-9]+')->where('id', '[0-9]+');
    });

    Route::group(['prefix' => '/api'], function () {

        Route::get('getSt{type}', 'ApiController@getStaticValues')->where('type', 'Cities|Genres');
        Route::get('get{type}', 'ApiController@getDynamicValues')->where('type', 'Cinemas|Seances|Movies');
        Route::get('getImage/{id}-{width}x{height}', 'ApiController@getImage')->where('id', '[0-9]+');
        Route::get('getPoster/{filePoster}', 'ApiController@getPoster');
        Route::post('getMessage', 'ApiController@getMessage');
    });

    Route::controllers([
        'password' => 'Auth\PasswordController',
    ]);

    Route::group(['prefix' => 'search'], function () {

        Route::get('users', ['as' => 'search_user', 'uses' => 'Search\SearchController@getList']);
        Route::get('movies', 'Search\SearchController@getMovies');
        Route::get('movie/{id}/cinemas/{city}', 'Search\SearchController@getCinemas')->where('id', '[0-9]+')->where('city', '[0-9]+');
        Route::get('movie/{id}', 'Search\SearchController@getMovieInfo')->where('id', '[0-9]+');
        Route::get('cinema/{id}', 'Search\SearchController@getCinemaInfo')->where('id', '[0-9]+');
        Route::get('users/seances/{id}', 'Search\SearchController@getList');
        Route::post('users/seances/{id}', 'Search\SearchController@saveMessage');

    });

    Route::get('google_calendar_callback', 'Auth\GoogleAuthController@getGoogleAuth');
});

