<?php
use Acme\Repos\Damages\DamagesRepository;
use Carbon\Carbon;
use Acme\Repos\DamagesDetails\DamagesDetailsRepository;
use Acme\Repos\Product\ProductRepository;
use Acme\Repos\VwInventorySource\VwInventorySourceRepository;

class DamagesController extends \BaseController {
	private $DamagesRepo;
	private $vwInventorySource;

	function __construct(DamagesRepository $DamagesRepo,ProductRepository $productRepo,
		DamagesDetailsRepository $DamageDetailsRepo,VwInventorySourceRepository $vwInventorySource)
		{
			$this->DamagesRepo = $DamagesRepo;
			$this->productRepo = $productRepo;
			$this->DamageDetailsRepo = $DamageDetailsRepo;
			$this->vwInventorySource = $vwInventorySource;
		}
	/**
	 * Display a listing of the resource.
	 * GET /ia
	 *
	 * @return Response
	 */
	public function index()
	{
		$max = $this->DamagesRepo->getMaxId();
		$branches = Branch::lists('BranchName','id');
		$products = $this->vwInventorySource->getInventorySourceWholeSale(Auth::user()->BranchNo);
		$damages= $this->DamagesRepo->getAllWithBranch();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		return View::make('dashboard.Damages.list',
			compact('damages','branches','products','max','now','lastweek'));
	}

	public function saveD(){
		if(Request::ajax()){
  			$input = Input::all();
  			// dd($input);
  			$TableData = stripslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			// dd($input['CustomerNo']);
  			if(!$TableData || !$input['BranchNo']){
  				$result = 0;
  			}else{
  				$ID= new Damage;
  				$ID->BranchNo=$input['BranchNo'];
  				$ID->InvDamageDate= Carbon::now();
  				$ID->Remarks=$input['Remarks'];
  				$ID->PreparedBy= $input['PreparedBy'];
  				$ID->ApprovedBy= $input['approvedBy'];
  				$ID->save();
  				$result =1;
  				foreach($TableData as $td){
  					// dd($td['Qty']);
  					$IDdetail= new DamagesDetails;
  					$IDdetail->InvDamagesNo=$ID->id;
  					$IDdetail->ProductNo=$td['ProdNo'];
  					$IDdetail->Unit=$td['Unit'];
  					$IDdetail->LotNo=$td['LotNo'];
  					$IDdetail->ExpiryDate=$td['ExpiryDate'];
  					$IDdetail->Qty=$td['Qty'];
  					$IDdetail->CostPerQty=$td['CostPerQty'];
  					$IDdetail->save();
  				}
  			}
		return Response::json($result);
  		}
	}

	public function viewD()
	{
		if(Request::ajax()){
			// dd(Input::get('id'));
  			$input = Input::all();
  			$id= $input['id'];
  			$products = $this->productRepo->getAll();
  			$SO= $this->DamagesRepo->getByIdWithBranch($id);
		return Response::json($SO);
  		}
	}

	public function viewDDetails()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			// dd($id);
  			$SOdetails = $this->DamageDetailsRepo->getAllByIA($id);
		return Response::json($SOdetails);
  		}
	}

	public function saveEditedD()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$TableData = stripslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			$Damages=$this->DamagesRepo->getByIdWithBranch($id);
  			$Damagesdetails = $this->DamageDetailsRepo->getAllByIA($id);
  			foreach($Damagesdetails as $d){
  					$d->delete();
  				}
  			if(!$TableData || (!isAdmin() && ($Damages[0]->ApprovedBy!=''))){
  				$result = 0;
  			}else{
  				$Damages[0]->BranchNo=$input['BranchNo'];
  				$Damages[0]->Remarks=$input['Remarks'];
  				$Damages[0]->InvDamageDate= Carbon::now();
  				$Damages[0]->PreparedBy= fullname(Auth::user());
  				$Damages[0]->save();
  				foreach($TableData as $td){
  					// dd($td['Unit']);
  					$Damagesdetail= new DamagesDetails;
  					$Damagesdetail->InvDamagesNo=$id;
  					$Damagesdetail->ProductNo=$td['ProdNo'];
  					$Damagesdetail->Unit=$td['Unit'];
  					$Damagesdetail->LotNo=$td['LotNo'];
  					$Damagesdetail->ExpiryDate=$td['ExpiryDate'];
  					$Damagesdetail->Qty=$td['Qty'];
  					$Damagesdetail->CostPerQty=$td['CostPerQty'];
  					$Damagesdetail->save();
  				}
  				$result =1;
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