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

Route::get('/', 'HomeController@index');
//TODO Change these to Auth 
Route::get('/logout', "UserController@LogOut");
Route::get('/login' ,'UserController@LoginPage');
Route::post('/login', 'UserController@LoginUser');
Route::get('/register', 'UserController@RegisterPage');
Route::post('/register', 'UserController@RegisterUser');

Route::get('/posts', 'PostsController@homepage');

//We just make the View inside the routes, no logic needs to be done as that is handled in angular
Route::get('/posts', function(){
	return View::make("posts.index");
});

//Similar to before, except we get the tag.
Route::get('/tag/{tags}', function($tag){
	return View::make('posts.Tags')->with('tag', $tag);
});

//Unused, delete? 
Route::get('/api/user/current', 'UserController@GetCurrentUser');

//This is where the API stuff happens
Route::group(array('prefix' => 'api'), function(){
    Route::resource('posts', 'PostsController',
           //We use index, get, store and destroy only. 
		    //Laravel produces these routes.
			array('only'=> array('index', 'get', 'store', 'destroy')));
	Route::resource('images', 'ImageController',
		array('only'=>array('store'))
	);
	Route::resource('user/follow', 'UserController',
		array('only'=>array('store'))	
	);
});

Route::get('/api/posts/{tag}', 'PostsController@GetTag');

/*---------------------------------------------------------------------------*/

// Route to specific post:
Route::get('/api/posts/{postID}', 'PostsController@GetPost');

Route::get('/posts/{id}', function($postID){
	return View::make('posts.post')->with('postID', $postID);
});

/*---------------------------------------------------------------------------*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);