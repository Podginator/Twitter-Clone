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
Route::get('/logout', "UserController@LogOut");
Route::get('/login' ,'UserController@LoginPage');
Route::post('/login', 'UserController@LoginUser');
Route::get('/register', 'UserController@RegisterPage');
Route::post('/register', 'UserController@RegisterUser');
Route::get('posts/', 'PostsController@homepage');

//Group the API stuff
//Current just do Posts. 

Route::group(array('prefix' => 'api'), function(){
    Route::resource('posts', 'PostsController',
            array('only'=> array('index', 'get', 'store', 'destroy')));
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);