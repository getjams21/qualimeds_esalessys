<?php
use Acme\Repos\StockTransfer\StockTransferRepository;
use Carbon\Carbon;
use Acme\Repos\StockTransferDetails\StockTransferDetailsRepository;
use Acme\Repos\VwInventorySource\VwInventorySourceRepository;
// use Acme\Repos\Branch\BranchRepository;

class STController extends \BaseController {
	private $stockTransferRepo;
	private $vwInventorySource;
	// private $branchRepo;
	private $stockTransferDetailsRepo;

	function __construct(StockTransferRepository $stockTransferRepo,VwInventorySourceRepository $vwInventorySource,
		StockTransferDetailsRepository $stockTransferDetailsRepo)
		{
			$this->stockTransferRepo = $stockTransferRepo;
			// $this->branchRepo = $branchRepo;
			$this->stockTransferDetailsRepo = $stockTransferDetailsRepo;
			$this->vwInventorySource = $vwInventorySource;
		}

	/**
	 * Display a listing of the resource.
	 * GET /st
	 *
	 * @return Response
	 */
	public function index()
	{
		$max = $this->stockTransferRepo->getMaxId();
		$branchSource = Branch::find(Auth::user()->BranchNo);
		$branches = Branch::where('id','!=', Auth::user()->BranchNo)->lists('BranchName','id');
		$products = $this->vwInventorySource->getInventorySourceWholeSale();
		$STs= $this->stockTransferRepo->getAllWithBranch();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		return View::make('dashboard.StockTransfers.list',compact('STs','customers','products','max','now','lastweek','branchSource','branches'));
	}

	public function saveST()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$TableData = stripslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			if(!$TableData || !$input['branchDest']){
  				$result = 0;
  			}else{
  				$ST= new StockTransfer;
  				$ST->BranchSourceNo=$input['branchSource'];
  				$ST->BranchDestinationNo= $input['branchDest'];
  				$ST->TransferDate= Carbon::now();
  				$ST->PreparedBy= $input['PreparedBy'];
  				$ST->ApprovedBy= $input['approvedBy'];
  				$ST->save();
  				$result =1;
  				foreach($TableData as $td){
  					// dd($td['Qty']);
  					$STdetail= new StockTransferDetails;
  					$STdetail->StockTransferNo=$ST->id;
  					$STdetail->ProductNo=$td['ProdNo'];
  					$STdetail->Unit=$td['Unit'];
  					$STdetail->LotNo=$td['LotNo'];
  					$STdetail->ExpiryDate=$td['ExpiryDate'];
  					$STdetail->Qty=$td['Qty'];
  					$STdetail->CostPerUnit=$td['CostPerUnit'];
  					$STdetail->save();
  				}
  			}
		return Response::json($result);
  		}
	}
	public function viewST()
	{
		if(Request::ajax()){
			// dd(Input::get('id'));
  			$input = Input::all();
  			$id= $input['id'];
  			$SO= $this->salesOrderRepo->getByIdWithCus($id);
  			$salesRep = $this->salesOrderRepo->getByIdWithSalesRep($id);
  			// dd($SO);
		return Response::json($SO);
  		}
	}
	public function viewSTDetails()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			// dd($id);
  			$SOdetails = $this->salesOrderDetailsRepo->getAllBySO($id);
		return Response::json($SOdetails);
  		}
	}
	public function saveEditedST()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$TableData = stripslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			$SO=$this->salesOrderRepo->getByIdWithCus($id);
  			$SOdetails = $this->salesOrderDetailsRepo->getAllBySO($id);
  			foreach($SOdetails as $d){
  					$d->delete();
  				}
  			if(!$TableData || (!isAdmin() && ($SO[0]->ApprovedBy!=''))){
  				$result = 0;
  			}else{
  				$SO[0]->CustomerNo=$input['customer'];
  				$SO[0]->UserNo=$input['UserNo'];
  				$SO[0]->SalesOrderDate= Carbon::now();
  				$SO[0]->Terms= $input['term'];
  				$SO[0]->PreparedBy= fullname(Auth::user());
  				$SO[0]->save();
  				foreach($TableData as $td){
  					// dd($td['Unit']);
  					$SOdetail= new SalesOrderDetails;
  					$SOdetail->SalesOrderNo=$SO[0]->id;
  					$SOdetail->ProductNo=$td['ProdNo'];
  					$SOdetail->Barcode='1111';
  					$SOdetail->LotNo=$td['LotNo'];
  					$SOdetail->ExpiryDate=$td['ExpiryDate'];
  					$SOdetail->Unit=$td['Unit'];
  					$SOdetail->Qty=$td['Qty'];
  					$SOdetail->UnitPrice=$td['UnitPrice'];
  					$SOdetail->save();
  				}
  				$result =1;
  			}
  			return Response::json($result);
  		}
	}

	public function changeSOType(){
		if(Request::ajax()){
			if(Input::get('selectedValue') == '2'){
				$products = $this->vwInventorySource->getInventorySourceRetail();
			}else if (Input::get('selectedValue') == '1'){
				$products = $this->vwInventorySource->getInventorySourceWholeSale();
			}
		return Response::json($products);
		}
	}
}