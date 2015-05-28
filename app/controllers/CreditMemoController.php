<?php

use Carbon\Carbon;
use Acme\Repos\CreditMemo\CreditMemoRepository;

class CreditMemoController extends \BaseController {
	protected $creditmemoRepo;
	function __construct(CreditMemoRepository $creditmemoRepo)
		{
			$this->creditmemoRepo = $creditmemoRepo;
		}
	/**
	 * Display a listing of the resource.
	 * GET /creditmemo
	 *
	 * @return Response
	 */
	public function index()
	{
		$customers = Customer::lists('CustomerName','id');
		$medReps = $medReps = User::select(DB::raw('concat (firstname," ",lastname) as full_name,id'))->whereIn('UserType', array(4, 11))->lists('full_name', 'id');
		$creditmemos = CreditMemo::selectRaw('creditmemo.*,u.firstname,u.lastname,c.CustomerName')
					->join('users as u','u.id','=','creditmemo.userno')
					->join('customers as c','c.id','=','creditmemo.customerno')
					->orderBy('c.CustomerName')
					->get();
		return View::make('dashboard.CreditMemo.index', compact('customers','creditmemos','medReps'));
	}

	//to edit CM
	public function toEditCM(){
		if (Request::ajax()) {
			$input = Input::all();
			$id = $input['id'];
			$creditmemo = $this->creditmemoRepo->getById($id);
		return Response::json($creditmemo);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /creditmemo/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /creditmemo
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		if($input['id'] == ''){
			$creditmemo = new CreditMemo;
			$creditmemo->customerno = $input['customers'];
			$creditmemo->userno = $input['UserNo'];
			// dd($creditmemo->userno);
			$creditmemo->creditmemodate = Carbon::now();
			$creditmemo->remarks = $input['remarks'];
			$creditmemo->amount = $input['amount'];
			$creditmemo->branchno = Auth::user()->BranchNo;
			$creditmemo->save();
			return Redirect::back()
				->withFlashMessage('
						<div class="alert alert-success" role="alert">
							Credit Memo is Successfully added.
						</div>
					');
		}else{
			$creditmemo = CreditMemo::find($input['id']);
			$creditmemo->customerno = $input['customers'];
			$creditmemo->userno = $input['UserNo'];
			$creditmemo->remarks = $input['remarks'];
			$creditmemo->amount = $input['amount'];
			$creditmemo->save();
			return Redirect::back()
				->withFlashMessage('
						<div class="alert alert-success" role="alert">
							Credit Memo is Successfully updated.
						</div>
					');
		}
	}

	/**
	 * Display the specified resource.
	 * GET /creditmemo/{id}
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
	 * GET /creditmemo/{id}/edit
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
	 * PUT /creditmemo/{id}
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
	 * DELETE /creditmemo/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}