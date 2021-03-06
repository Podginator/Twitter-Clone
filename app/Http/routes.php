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
Route::bind('storyid', function($value, $route){
	return App\Model\Story::where('id', $value)->first();
});
Route::bind('postid', function($value, $route){
	return App\Model\Posts::where('id', $value)->first();
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
Route::get('/story', function(){
	Return View::make('story.index');
});
//Similar to before, except we get the tag.
Route::get('/tag/{tags}', function($tag){
	return View::make('posts.Tags')->with('tag', $tag);
});
Route::get('/{user}', 'UserController@userPage');
Route::get('/api/user/following', 'UserController@isFollowing');

/*
Route::get('/api/post/{postID}', 'PostsController@GetPost');
Route::get('/posts/{id}', function($postID){
	return View::make('posts.post')->with('postID', $postID);
}); */

Route::get('/api/tag/delete/{id}', "UserController@removeUserTag");
Route::get('/api/story/posts/{id}', "StoryController@getStoryPosts");
Route::get('/api/posts/all', "PostsController@getAllPosts");

Route::get('/story/create', [
    'middleware' => 'auth',
    'uses' => 'StoryController@CreateStory'
]);
Route::get('/story/{storyid}', 'StoryController@viewStory');
Route::post('/api/story/edit/{id}', 'StoryController@edit');

//This is where the API stuff happens
Route::group(array('prefix' => 'api'), function(){
    Route::resource('posts', 'PostsController',
           //We use index, get, store and destroy only. 
		    //Laravel produces these routes.
			array('only'=> array('index', 'get', 'store', 'destroy')));
	Route::resource('images', 'FileController',
		array('only'=>array('store'))
	);
	Route::resource('story', 'StoryController',
		array('only'=>array('index', 'get', 'store', 'destroy'))
	);
	Route::resource('user/follow', 'UserController',
		array('only'=>array('store'))	
	);
	Route::resource('allUsers', 'UserController',
		array('only'=>array('allUsers'))
	);
});
//-----------Dette har jeg addet -----------//
Route::get('/api/story/user/{user}', 'StoryController@getUserStories');
Route::get('/api/story/{tag}', 'StoryController@getTag');
//-----------------------------------------//
Route::get('api/allUsers', 'UserController@getAllUsers');
Route::get('/api/posts/{tag}', 'PostsController@getTag');
Route::get('/api/user/follow/{user}', 'UserController@subscribePerson');
Route::get('/api/user/delete/{user}', 'UserController@unsubscribePersone');
Route::get('/posts/{postid}', 'PostsController@viewPost');
Route::get('/api/posts/user/{username}', 'PostsController@getUserPosts');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('/profile', 'UserController@updateProfile');