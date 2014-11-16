<?php
use Acme\Repos\PurchaseOrder\PurchaseOrderRepository;
use Acme\Repos\Product\ProductRepository;
use Carbon\Carbon;
use Acme\Repos\PurchaseOrderDetails\PurchaseOrderDetailsRepository;

class POController extends \BaseController {
	private $purchaseOrderRepo;
	function __construct(PurchaseOrderRepository $purchaseOrderRepo,ProductRepository $productRepo,
		PurchaseOrderDetailsRepository $purchaseOrderDetailsRepo)
		{
			$this->purchaseOrderRepo = $purchaseOrderRepo;
			$this->productRepo = $productRepo;
			$this->purchaseOrderDetailsRepo = $purchaseOrderDetailsRepo;
		}
	/**
	 * Display a listing of the resource.
	 * GET /po
	 *
	 * @return Response
	 */
	public function index()
	{	
		$max = $this->purchaseOrderRepo->getMaxId();
		$supplier = Supplier::lists('SupplierName','id');
		$products = $this->productRepo->getAll();
		$POs= $this->purchaseOrderRepo->getAllWithSup();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		return View::make('dashboard.PurchaseOrders.list',compact('POs','supplier','products','max','now','lastweek'));
	}
	public function addProductToPO()
	{	
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$Product= $this->productRepo->getByid($id);
		return Response::json($Product);
		}
	}
	public function productDtAjax()
	{	
		$result = DB::table('products')
		->select('id as id', 'ProductName as ProductName', 'BrandName', 'WholeSaleUnit');
 
	return Datatables::of($result)
			
			->add_column('add','<td><button class="btn btn-success btn-xs square" onclick="addPO({{$id}})" ><i class="fa fa-check-circle"></i> Add</button>
                      </td>')	
			->make();
	}
	public function savePO()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			if(!$TableData || !$input['supplier']){
  				$result = 0;
  			}else{
  				$PO= new PurchaseOrder;
  				$PO->SupplierNo=$input['supplier'];
  				$PO->BranchNo=Auth::user()->BranchNo;
  				$PO->PODate= Carbon::now();
  				$PO->Terms= $input['term'];
  				$PO->PreparedBy= $input['preparedBy'];
  				$PO->ApprovedBy= $input['approvedBy'];
  				$PO->save();
  				$result =1;
  				foreach($TableData as $td){
  					$POdetail= new PurchaseOrderDetails;
  					$POdetail->PurchaseOrderNo=$PO->id;
  					$POdetail->ProductNo=$td['ProdNo'];
  					$POdetail->Unit=$td['Unit'];
  					$POdetail->Qty=$td['Qty'];
  					$POdetail->CostPerQty=$td['CostPerQty'];
  					$POdetail->save();
  				}
  			}
		return Response::json($result);
  		}
	}
	public function viewPO()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$PO= $this->purchaseOrderRepo->getByIdWithSup($id);
		return Response::json($PO);
  		}
	}
	public function viewPODetails()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$POdetails = $this->purchaseOrderDetailsRepo->getAllByPO($id);
		return Response::json($POdetails);
  		}
	}
	public function saveEditedPO()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			$PO=$this->purchaseOrderRepo->getByIdWithSup($id);
  			$POdetails = $this->purchaseOrderDetailsRepo->getAllByPO($id);
  			foreach($POdetails as $d){
  					$d->delete();
  				}
  			if(!$TableData || (!isAdmin() && ($PO[0]->ApprovedBy!=''))){
  				$result = 0;
  			}else{
  				$PO[0]->SupplierNo=$input['supplier'];
  				$PO[0]->PODate= Carbon::now();
  				$PO[0]->Terms= $input['term'];
  				$PO[0]->PreparedBy= fullname(Auth::user());
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
	public function approvePO()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id = $input['id'];
  			if($input['ApprovedBy']==1){
  				$approve = fullname(Auth::user());
  			}else{
  				$approve = '';
  			}
  			$PO = PurchaseOrder::find($id);
  			$PO->ApprovedBy=$approve;
  			$PO->save();
  			return Response::json($approve);
  		}
	}
	public function cancelPO()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id = $input['id'];
  			$PO = PurchaseOrder::find($id);
  			$PO->CancelledBy=fullname(Auth::user());
  			$PO->IsCancelled=1;
  			$PO->save();
  			return Response::json(fullname(Auth::user()));
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