<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('admin', ['before' => 'auth', function()
{
    // Temporary
    return '<h1>Admin Area</h1>';
}]);

Route::get('login', function()
{
    return View::make('sessions.new');
});

Route::resource('sessions', 'SessionsController');
