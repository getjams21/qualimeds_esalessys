<?php
use Acme\Forms\RegistrationForm;
use Acme\Repos\User\UserRepository;

class UsersController extends \BaseController {

	protected $registrationForm;
	private $userRepo;
	function __construct(RegistrationForm $registrationForm, UserRepository $userRepo)
	{
		$this->registrationForm = $registrationForm;
		$this->userRepo = $userRepo;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Users = $this->userRepo->getAllActive();
		// dd($Users);
		return View::make('dashboard.users.users', compact('Users'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::only('id','username','password','password_confirmation','Lastname','Firstname','MI','UserType');
		if($input['id'] == ''){
			$this->registrationForm->validate($input);
			$customer = User::create($input);
			return Redirect::back()
				->withFlashMessage('
						<div class="alert alert-success" role="alert">
							User is Successfully added.
						</div>
					');
		}else{
			$user = User::find($input['id']);
			$user->fill($input)->save();
			return Redirect::back()
				->withFlashMessage('
						<div class="alert alert-success" role="alert">
							User is Successfully updated.
						</div>
					');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$customer = User::find($id);
		$customer->IsActive = 0;
		$customer->save();

		return Redirect::back()
			->withFlashMessage('
					<div class="alert alert-success" role="alert">
						User is Successfully deactivated.
					</div>
				');
	}

	public function toEditUser(){
		if(Request::ajax()){
  			$user = DB::select('select * from users where id = '.Input::get('id').'');
			return Response::json($user);
  		}
	}

	public function editAccount(){
		// $user = $this->userRepo->getByid(Auth::user()->id);
		return View::make('dashboard.users.update');
	}

	public function validateCurrentPassword(){
		if(Request::ajax()){
			$currentPword = DB::select('select password from users where id = '.Auth::user()->id.'');
			// dd($currentPword[0]->password);
			$typedPword = Input::get('val');
			if (Hash::check($typedPword, $currentPword[0]->password)){
				return Response::json([1]);
			}
			else{
				return Response::json([0]);
			}
		}
	}
}
