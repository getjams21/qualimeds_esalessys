<?php

class PagesController extends BaseController {

	public function home(){

		$name = "Jay";
		return View::make('hello')->with('name', $name);

	}

	public function about(){

		return View::make('about');

	}
	public function soft404(){
		return View::make('404')->with('message', 'Task not Found');
	}
	public function register(){
		return View::make('pages.register');
	}

	public function store(){
		$user = new User;
		$user->username = Input::get('Username');
		$user->email = Input::get('Email');
		$user->password = Hash::make(Input::get('password'));
		
		if($user->save()){
			return Redirect::to('users/login');
		}
		else {
			return 'not saved!';
		}

	}
}