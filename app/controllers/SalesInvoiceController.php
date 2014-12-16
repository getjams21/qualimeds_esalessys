<?php
use Acme\Repos\SalesOrder\SalesOrderRepository;
use Acme\Repos\Product\ProductRepository;
use Acme\Repos\SalesInvoices\SIRepository;
use Acme\Repos\SalesOrderDetails\SalesOrderDetailsRepository;
use Acme\Repos\VwInventorySource\VwInventorySourceRepository;
use Acme\Repos\SalesInvoiceDetails\SIDetailsRepository;
use Carbon\Carbon;
class SalesInvoiceController extends \BaseController {
	private $SIRepo;
	private $salesOrderRepo;
	private $vwInventorySource;
	function __construct(SalesOrderRepository $salesOrderRepo,ProductRepository $productRepo,
		SalesOrderDetailsRepository $salesOrderDetailsRepo,VwInventorySourceRepository $vwInventorySource,
		SIRepository $SIRepo,SIDetailsRepository $SIDetailsRepo)
		{
			$this->salesOrderRepo = $salesOrderRepo;
			$this->productRepo = $productRepo;
			$this->salesOrderDetailsRepo = $salesOrderDetailsRepo;
			$this->vwInventorySource = $vwInventorySource;
			$this->SIRepo = $SIRepo;
			$this->SIDetailsRepo = $SIDetailsRepo;
		}
	/**
	 * Display a listing of the resource.
	 * GET /salesinvoice
	 *
	 * @return Response 
	 */
	public function index()
	{
		$max = $this->SIRepo->getMaxId();
		$customers = Customer::lists('CustomerName','id');
		$medReps = User::select(DB::raw('concat (firstname," ",lastname) as full_name,id'))->whereIn('UserType', array(4, 11))->lists('full_name', 'id');
		$SOs= $this->salesOrderRepo->getAllApprovedSO();
		$SIs= $this->SIRepo->getAllWithCusAndRep();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		return View::make('dashboard.SalesInvoices.list',compact('SOs','max','now','lastweek','customers','medReps','SIs'));

	}
	public function viewSO()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$PO= $this->salesOrderRepo->getByid($id);
		return Response::json($PO);
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
	public function saveSOBill()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			if(!$TableData || !$input['RefDocNo'] || !$input['SalesInvoiceDate']){
  				$result = 0;
  			}else{
  				if($input['ApprovedBy'] == 1){
  					$approve = fullname(Auth::user());
  				}else{
  					$approve = '';
  				}
  				$SO = SalesOrder::find($input['id']);
  				$SI = new SalesInvoice;
  				$SI->SalesOrderNo = $input['id'];
  				$SI->CustomerNo = $SO->CustomerNo;
  				$SI->UserNo = $SO->UserNo;
  				$SI->BranchNo = Auth::user()->BranchNo;
  				$SI->SalesInvoiceRefDocNo = $input['RefDocNo'];
  				$SI->InvoiceDate = \Carbon\Carbon::createFromFormat('m/d/Y', $input['SalesInvoiceDate'])->toDateTimeString();
  				$SI->Terms = $input['term'];
  				$SI->PreparedBy = fullname(Auth::user());
  				$SI->ApprovedBy = $approve;
  				$SI->save();
  				$result =1;
  				foreach($TableData as $td){
  					$SIdetails= new SalesInvoiceDetail;
  					$SIdetails->SalesInvoiceNo=$SI->id;
  					$SIdetails->ProductNo=$td['ProductNo'];
  					$SIdetails->Unit=$td['Unit'];
  					$SIdetails->LotNo=$td['LotNo'];
	  				$SIdetails->ExpiryDate=$td['ExpiryDate'];
  					$SIdetails->Qty=$td['Qty'];
  					$SIdetails->FreebiesQty=$td['FreebiesQty'];
  					$SIdetails->FreebiesUnit=$td['FreebiesUnit'];
  					$SIdetails->UnitPrice=$td['CostPerQty'];
  					$SIdetails->save();
  				}
  			}
		return Response::json($result);
  		}
	}
	public function viewSI(){
		if(Request::ajax()){
			$input = Input::all();
			$id= $input['id'];
			$SI= $this->SIRepo->getByid($id);
		return Response::json($SI);
		}
	}
	public function viewSIDetails(){
		if(Request::ajax()){
			$input = Input::all();
			$id= $input['id'];
			$bill= $this->SIDetailsRepo->getAllBySO($id);
		return Response::json($bill);
		}
	}
	public function saveEditedSI(){
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);

  			if(!$TableData || !$input['RefDocNo'] || !$input['SalesInvoiceDate']){
  				$result = 0;
  			}else{ 
  				$SIDetails = $this->SIDetailsRepo->getAllBySO($id);
	  			foreach($SIDetails as $d){
	  					$d->delete();
	  				}
  				$bills=SalesInvoice::find($id);
  				$bills->SalesInvoiceRefDocNo = $input['RefDocNo'];
  				$bills->InvoiceDate = \Carbon\Carbon::createFromFormat('m/d/Y', $input['SalesInvoiceDate'])->toDateTimeString();
  				$bills->Terms = $input['term'];
  				$bills->PreparedBy = fullname(Auth::user());
  				$bills->save();
  				foreach($TableData as $td){
  					$SIdetails= new SalesInvoiceDetail;
  					$SIdetails->SalesInvoiceNo=$id;
  					$SIdetails->ProductNo=$td['ProductNo'];
  					$SIdetails->Unit=$td['Unit'];
  					$SIdetails->LotNo=$td['LotNo'];
	  				$SIdetails->ExpiryDate=$td['ExpiryDate'];
  					$SIdetails->Qty=$td['Qty'];
  					$SIdetails->FreebiesQty=$td['FreebiesQty'];
  					$SIdetails->FreebiesUnit=$td['FreebiesUnit'];
  					$SIdetails->UnitPrice=$td['CostPerQty'];
  					$SIdetails->save();
  				}
  				$result =1;
  			}
		return Response::json($result);
  		}
	}
	public function approveSI()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id = $input['id'];
  			if($input['ApprovedBy']==1){
  				$approve = fullname(Auth::user());
  			}else{
  				$approve = '';
  			}
  			$PO = SalesInvoice::find($id);
  			$PO->ApprovedBy=$approve;
  			$PO->save();
  			return Response::json($approve);
  		}
	}
	public function cancelSI()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id = $input['id'];
  			$bill = SalesInvoice::find($id);
  			$bill->CancelledBy=fullname(Auth::user());
  			$bill->IsCancelled=1;
  			$bill->save();
  			return Response::json(fullname(Auth::user()));
  		}
	}
	/**
	 * Show the form for creating a new resource.
	 * GET /salesinvoice/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /salesinvoice
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /salesinvoice/{id}
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
	 * GET /salesinvoice/{id}/edit
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
	 * PUT /salesinvoice/{id}
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
	 * DELETE /salesinvoice/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}