<?php
use Acme\Forms\LoginForm;
class SessionsController extends \BaseController {
	protected $loginForm;

	function __construct(LoginForm $loginForm)
	{
		$this->loginForm = $loginForm;
		$this->beforeFilter('guest',['only' => ['create']]);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(!User::find(1)){
			$user= new User;
			$user->username='admin';
			$user->password='admin';
			$user->UserType=1;
			$user->save();
		}
		return View::make('sessions.create');
		
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->loginForm->validate($input = Input::only('username','password'));
		$input = Input::only('username','password');
		if(Auth::attempt($input))
		{
			return Redirect::intended('/');
		}
		return Redirect::to('login')->withInput()->withFlashMessage('<div class="alert alert-danger square" role="alert"><b>Invalid credentials provided!</b></div>');
	}


	public function destroy($id = null)
	{
		Auth::logout();
		return Redirect::to('login');
	}


}
