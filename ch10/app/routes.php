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

// Route::get('posts', function()
// {
//     $posts = Post::all();

//     return View::make('posts.index', ['posts' => $posts]);
// });

App::bind(
    'Repositories\PostRepositoryInterface',
    'Repositories\EloquentPostRepository'
);

Route::resource('posts', 'PostsController');