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

//Binds 
Route::bind('user', function($value, $route){
	return App\Model\User::where('username', $value)->first();
});


//Gets
Route::get('/', 'HomeController@index');
//We just make the View inside the routes, no logic needs to be done as that is handled in angulars
Route::get('/posts', function(){
	return View::make("posts.index");
});
Route::get('/profile',[
    'middleware' => 'auth',
    'uses' => 'UserController@profilePage'
]);
//Similar to before, except we get the tag.
Route::get('/tag/{tags}', function($tag){
	return View::make('posts.Tags')->with('tag', $tag);
});
Route::get('/{user}', 'UserController@userPage');
Route::get('/api/post/{postID}', 'PostsController@GetPost');
Route::get('/posts/{id}', function($postID){
	return View::make('posts.post')->with('postID', $postID);
});
Route::get('/api/tag/delete/{id}', "UserController@removeUserTag");





//This is where the API stuff happens
Route::group(array('prefix' => 'api'), function(){
    Route::resource('posts', 'PostsController',
           //We use index, get, store and destroy only. 
		    //Laravel produces these routes.
			array('only'=> array('index', 'get', 'store', 'destroy')));
	Route::resource('images', 'FileController',
		array('only'=>array('store'))
	);
	Route::resource('user/follow', 'UserController',
		array('only'=>array('store'))	
	);
});
Route::get('/api/posts/{tag}', 'PostsController@GetTag');

/*---------------------------------------------------------------------------*/

// Route to specific post:
/*Route::get('/api/post/{id}', 'PostsController@GetPost');
Route::get('/api/user/follow/{user}', 'UserController@SubscribePerson');

Route::get('/posts/{id}', function($id, $username)
{
	return View::make('posts.thisPost')
	->with('id', $id)
	->with('username', $username);
}); */

/*---------------------------------------------------------------------------*/

Route::get('/api/posts/user/{username}', 'PostsController@GetUserPosts');Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('/profile', 'UserController@updateProfile');