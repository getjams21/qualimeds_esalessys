<?php
use Acme\Repos\SalesOrder\SalesOrderRepository;
use Acme\Repos\Product\ProductRepository;
use Carbon\Carbon;
use Acme\Repos\SalesOrderDetails\SalesOrderDetailsRepository;
use Acme\Repos\VwInventorySource\VwInventorySourceRepository;

class SOController extends \BaseController {
	private $salesOrderRepo;
	private $vwInventorySource;
	function __construct(SalesOrderRepository $salesOrderRepo,ProductRepository $productRepo,
		SalesOrderDetailsRepository $salesOrderDetailsRepo,VwInventorySourceRepository $vwInventorySource)
		{
			$this->salesOrderRepo = $salesOrderRepo;
			$this->productRepo = $productRepo;
			$this->salesOrderDetailsRepo = $salesOrderDetailsRepo;
			$this->vwInventorySource = $vwInventorySource;
		}
	/**
	 * Display a listing of the resource.
	 * GET /po
	 *
	 * @return Response
	 */
	public function index()
	{	
		$max = $this->salesOrderRepo->getMaxId();
		$customers = Customer::lists('CustomerName','id');
		$medReps = User::where('UserType','=','4')->lists('Lastname','id');
		$products = $this->vwInventorySource->getInventorySourceWholeSale();
		$SOs= $this->salesOrderRepo->getAllWithCus();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		return View::make('dashboard.SalesOrders.list',compact('SOs','customers','products','max','now','lastweek','medReps'));
	}
	public function saveSO()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			// dd($input);
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			// dd($TableData);
  			if(!$TableData || !$input['customer']){
  				$result = 0;
  			}else{
  				$SO= new SalesOrder;
  				$SO->CustomerNo=$input['customer'];
  				$SO->SalesOrderDate= Carbon::now();
  				$SO->Terms= $input['term'];
  				$SO->UserNo= $input['UserNo'];
  				$SO->BranchNo= Auth::user()->BranchNo;
  				$SO->save();
  				$result =1;
  				foreach($TableData as $td){
  					$SOdetail= new SalesOrderDetails;
  					$SOdetail->SalesOrderNo=$SO->id;
  					$SOdetail->ProductNo=$td['ProdNo'];
  					$SOdetail->Barcode=$td['Barcode'];
  					$SOdetail->LotNo=$td['LotNo'];
  					$SOdetail->ExpiryDate=$td['ExpiryDate'];
  					$SOdetail->Unit=$td['Unit'];
  					$SOdetail->Qty=$td['Qty'];
  					$SOdetail->UnitPrice=$td['UnitPrice'];
  					$SOdetail->save();
  				}
  			}
		return Response::json($result);
  		}
	}
	public function viewSO()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$SO= $this->salesOrderRepo->getByIdWithCus($id);
		return Response::json($SO);
  		}
	}
	public function viewSODetails()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$SOdetails = $this->salesOrderDetailsRepo->getAllBySO($id);
		return Response::json($SOdetails);
  		}
	}
	public function saveEditedSO()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			$SO=$this->salesOrderRepo->getByIdWithCus($id);
  			$SOdetails = $this->salesOrderDetailsRepo->getAllBySO($id);
  			foreach($SOdetails as $d){
  					$d->delete();
  				}
  			if(!$TableData || (!isAdmin() && ($SO[0]->ApprovedBy!=''))){
  				$result = 0;
  			}else{
  				$PO[0]->SupplierNo=$input['supplier'];
  				$PO[0]->PODate= Carbon::now();
  				$PO[0]->Terms= $input['term'];
  				$PO[0]->PreparedBy= fullame(Auth::user());
  				$PO[0]->save();
  				foreach($TableData as $td){
  					$POdetail= new PurchaseOrderDetails;
  					$POdetail->PurchaseOrderNo=$id;
  					$POdetail->ProductNo=$td['ProdNo'];
  					$POdetail->Unit=$td['Unit'];
  					$POdetail->Qty=$td['Qty'];
  					$POdetail->CostPerQty=$td['CostPerQty'];
  					$POdetail->save();
  				}
  				$result =1;
  			}
  			return Response::json($result);
  		}
	}

	public function changeSOType(){
		if(Request::ajax()){
		$product = [];
			if(Input::get('selectedValue') == '2'){
				$products = $this->vwInventorySource->getInventorySourceRetail();
			}else if (Input::get('selectedValue') == '1'){
				$products = $this->vwInventorySource->getInventorySourceWholeSale();
			}
		return Response::json($product);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /po/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /po
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /po/{id}
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
	 * GET /po/{id}/edit
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
	 * PUT /po/{id}
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
	 * DELETE /po/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}