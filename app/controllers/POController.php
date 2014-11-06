<?php
use Acme\Repos\PurchaseOrder\PurchaseOrderRepository;
use Acme\Repos\Product\ProductRepository;
use Carbon\Carbon;
class POController extends \BaseController {
	private $purchaseOrderRepo;
	function __construct(PurchaseOrderRepository $purchaseOrderRepo,ProductRepository $productRepo)
		{
			$this->purchaseOrderRepo = $purchaseOrderRepo;
			$this->productRepo = $productRepo;
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
	public function savePO()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			if(!$TableData){
  				$result = 0;
  			}else{
  				$PO= new PurchaseOrder;
  				$PO->SupplierNo=$input['supplier'];
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