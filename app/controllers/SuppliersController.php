<?php
use Acme\Forms\SupplierForm;
class SuppliersController extends \BaseController {
	protected $supplierForm;
	function __construct(SupplierForm $supplierForm)
		{
			$this->supplierForm = $supplierForm;
		}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$suppliers = Supplier::all();
		return View::make('dashboard.Suppliers.list',compact('suppliers'));
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
		$input = Input::only('id','SupplierName','Address','Telephone1','Telephone2','ContactPerson');
		$id = $input['id'];
		$this->supplierForm->validate($input);
		if($id != null){
			$supplier = Supplier::find($id);
			$supplier->fill($input)->save();
		}else{
			$supplier = Supplier::create($input);
		}
		return Redirect::to('/Suppliers');
	}
	public function fetchSupplier()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id = $input['id'];
  			$supplier = Supplier::find($id);
			return Response::json($supplier);
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
	


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
