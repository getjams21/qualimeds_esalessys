<?php
use Acme\Forms\SupplierForm;
use Acme\Repos\Supplier\SupplierRepository;
class SuppliersController extends \BaseController {
	protected $supplierForm;
	private $supplierRepo;
	function __construct(SupplierForm $supplierForm, SupplierRepository $supplierRepo)
		{
			$this->supplierForm = $supplierForm;
			$this->supplierRepo = $supplierRepo;
		}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$suppliers = $this->supplierRepo->getAll();
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
			$supplier = $this->supplierRepo->getById($id);
			$supplier->fill($input)->save();
		}else{
			$supplier = $this->supplierRepo->addNew($input);
		}
		return Redirect::to('/Suppliers');
	}
	public function fetchSupplier()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id = $input['id'];
  			$supplier = $this->supplierRepo->getById($id);
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
