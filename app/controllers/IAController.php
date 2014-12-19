<?php
use Acme\Repos\InventoryAdjustments\InventoryAdjustmentRepository;
use Carbon\Carbon;
use Acme\Repos\InventoryAdjustmentDetails\InventoryAdjustmentDetailsRepository;
// use Acme\Repos\InventoryAdjustmentDetails\InventoryAdjustmentDetailsRepository;
use Acme\Repos\Product\ProductRepository;

class IAController extends \BaseController {
	private $inventoryAdjustmentRepo;

	function __construct(InventoryAdjustmentRepository $inventoryAdjustmentRepo,ProductRepository $productRepo,
		InventoryAdjustmentDetailsRepository $inventoryAdjustmentDetailsRepo)
		{
			$this->inventoryAdjustmentRepo = $inventoryAdjustmentRepo;
			$this->productRepo = $productRepo;
			$this->inventoryAdjustmentDetailsRepo = $inventoryAdjustmentDetailsRepo;
		}
	/**
	 * Display a listing of the resource.
	 * GET /ia
	 *
	 * @return Response
	 */
	public function index()
	{
		$max = $this->inventoryAdjustmentRepo->getMaxId();
		$branches = Branch::lists('BranchName','id');
		$products = $this->productRepo->getAll();
		$IAs= $this->inventoryAdjustmentRepo->getAllWithBranch();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		return View::make('dashboard.InventoryAdjustments.list',
			compact('IAs','branches','products','max','now','lastweek'));
	}

	public function saveIA(){
		if(Request::ajax()){
  			$input = Input::all();
  			// dd($input);
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			// dd($TableData);
  			// dd($input['CustomerNo']);
  			if(!$TableData || !$input['BranchNo']){
  				$result = 0;
  			}else{
  				$IA= new InventoryAdjustment;
  				$IA->BranchNo=$input['BranchNo'];
  				$IA->AdjustmentDate= Carbon::now();
  				$IA->Remarks=$input['Remarks'];
  				$IA->PreparedBy= $input['PreparedBy'];
  				$IA->ApprovedBy= $input['approvedBy'];
  				$IA->save();
  				$result =1;
  				foreach($TableData as $td){
  					// dd($td['Qty']);
  					$IAdetail= new InventoryAdjustmentDetails;
  					$IAdetail->InvAdjustmentNo=$IA->id;
  					$IAdetail->ProductNo=$td['ProdNo'];
  					$IAdetail->Unit=$td['Unit'];
  					$IAdetail->LotNo=$td['LotNo'];
  					$IAdetail->ExpiryDate=$td['ExpiryDate'];
  					$IAdetail->Qty=$td['Qty'];
  					$IAdetail->CostPerQty=$td['CostPerQty'];
  					$IAdetail->save();
  				}
  			}
		return Response::json($result);
  		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /ia/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /ia
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /ia/{id}
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
	 * GET /ia/{id}/edit
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
	 * PUT /ia/{id}
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
	 * DELETE /ia/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}