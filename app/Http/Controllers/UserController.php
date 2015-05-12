<?php namespace App\Http\Controllers;
 
use Auth, View, Response, Input;
use App\Model\FollowingEvent;
use App\Model\User;
class UserController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        //STUB
		//return view("home.home");
	}
	
	public function store()
	{
		//First we need to check if the user is logged in, if so, he can post.
		$success =  Response::json(array('success' => true));
		$fail =  Response::json(array('success' => false));
		//We also need to check whether a user has posted less than 140 characters. 
		
		if(Auth::user() && count(Input::get('text')) > 0 &&  preg_match('/^[a-zA-Z ]*$/', Input::get('text')))
		{
			$newFollowingEvent = FollowingEvent::create(array(
						"userid"=>Auth::user()->id,
						"hashtag"=>Input::get('text'),
					));
					
 
 			//here we check if the newpost entered the db, if it did then the newPost will have an id, otherwise it will not.
			return $newFollowingEvent->id ? $success : $fail;
		}
		
		//Otherwise, we'll return a fail response. 
		return $fail;
	}
    
    public function LoginPage()
    {
        //Currently just stubs.
        if(Auth::user())
        {
            return view('login.loggedin');
        }
        else
        {
            return view('login.loginform');
        }
    }
	
	public function profilePage(User $user)
	{
		$data['user'] = $user;
		return View::make('users.page', $data);
	}
	
	public function GetCurrentUser()
	{
		 return Response::json(Auth::user());
	}

}
