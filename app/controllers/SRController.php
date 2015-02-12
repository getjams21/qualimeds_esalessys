<?php
use Acme\Repos\SupplierReturns\SRRepository;
use Carbon\Carbon;
use Acme\Repos\SupplierReturnDetails\SRDRepository;
use Acme\Repos\Bills\BillsRepository;
use Acme\Repos\BillDetails\BillDetailsRepository;
use Acme\Repos\Supplier\SuppliderRepository;

class SRController extends \BaseController {
	private $supplierReturnRepo;
	private $supplierReturnDetailsRepo;
	private $billsRepo;
	private $billDetailsRepo;

	function __construct(SRRepository $supplierReturnRepo,SRDRepository $supplierReturnDetailsRepo,
		BillsRepository $billsRepo,BillDetailsRepository $billDetailsRepo)
	{
		$this->supplierReturnRepo = $supplierReturnRepo;
		$this->supplierReturnDetailsRepo = $supplierReturnDetailsRepo;
		$this->billsRepo = $billsRepo;
		$this->billDetailsRepo = $billDetailsRepo;
	}

	/**
	 * Display a listing of the resource.
	 * GET /SR
	 *
	 * @return Response
	 */
	public function index()
	{
		$max = $this->supplierReturnRepo->getMaxId();
		$suppliers = Supplier::lists('SupplierName','id');
		$defaultSup = Supplier::firstOrFail();
		$SRs= $this->supplierReturnRepo->getAllWithBranch();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		$supplierBills = $this->billsRepo->getAllBySupplier($defaultSup->id);
		return View::make('dashboard.SupplierReturns.list', compact('suppliers','max','supplierBills','now','lastweek','SRs')); 
	}

	public function fetchSupplierBills(){
		if(Request::ajax()){
			$supplierBills = $this->billsRepo->getAllBySupplier(Input::get('id'));
			return Response::json($supplierBills);
		}
	}

	public function fetchBillItems(){
		if(Request::ajax()){
			$Billdetails = $this->billDetailsRepo->getAllByBill(Input::get('id'));
			return Response::json($Billdetails);
		}
	}

	public function fetchSI(){
		if(Request::ajax()){
			$SI = $this->salesInvoiceRepo->getByid(Input::get('SIno'));
			return Response::json($SI);
		}
	}

	public function saveSR(){
		if(Request::ajax()){
  			$input = Input::all();
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			if(!$TableData || !$input['SupplierNo']){
  				$result = 0;
  			}else{
  				$SR= new SupplierReturn;
  				$SR->BillNo=$input['BillNo'];
  				$SR->BranchNo = Auth::user()->BranchNo;
  				$SR->ReturnDate= Carbon::now();
  				$SR->Remarks=$input['Remarks'];
  				$SR->PreparedBy= $input['PreparedBy'];
  				$SR->ApprovedBy= $input['approvedBy'];
  				$SR->save();
  				$result =1;
  				foreach($TableData as $td){
  					// dd($td['Qty']);
  					$SRdetail= new SupplierReturnDetails;
  					$SRdetail->SupplierReturnNo=$SR->id;
  					$SRdetail->ProductNo=$td['ProdNo'];
  					$SRdetail->Unit=$td['Unit'];
  					$SRdetail->LotNo=$td['LotNo'];
  					$SRdetail->ExpiryDate=$td['ExpiryDate'];
  					$SRdetail->Qty=$td['Qty'];
  					$SRdetail->CostPerQty=$td['CostPerQty'];
  					$SRdetail->FreebiesQty=$td['FreebiesQty'];
  					$SRdetail->FreebiesUnit=$td['FreebiesUnit'];
  					$SRdetail->save();
  				}
  			}
		return Response::json($result);
  		}
	}

	public function viewCR(){
		if(Request::ajax()){
			// dd(Input::get('id'));
  			$input = Input::all();
  			$id= $input['id'];
  			$CR= $this->customerReturnRepo->getByid($id);
		return Response::json($CR);
  		}
	}

	public function viewCRDetails()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$CRdetails = $this->customerReturnDetailsRepo->getAllByCR($id);
		return Response::json($CRdetails);
  		}
	}

	public function saveEditedCR()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$TableData = stripslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			$CR=$this->customerReturnRepo->getByIdWithBranch($id);
  			$CRdetails = $this->customerReturnDetailsRepo->getAllByCR($id);
  			foreach($CRdetails as $d){
  					$d->delete();
  				}
  			if(!$TableData || (!isAdmin() && ($CR[0]->ApprovedBy!=''))){
  				$result = 0;
  			}else{
  				$CR[0]->SalesInvoiceNo=$input['SalesinvoiceNo'];
  				$CR[0]->BranchNo = Auth::user()->BranchNo;
  				$CR[0]->Remarks=$input['Remarks'];
  				$CR[0]->CustomerReturnDate= Carbon::now();
  				$CR[0]->PreparedBy= fullname(Auth::user());
  				$CR[0]->save();
  				foreach($TableData as $td){
  					// dd($td['Unit']);
  					$CRdetail= new CustomerReturnDetail;
  					$CRdetail->CustomerReturnNo=$CR[0]->id;
  					$CRdetail->ProductNo=$td['ProdNo'];
  					$CRdetail->Unit=$td['Unit'];
  					$CRdetail->LotNo=$td['LotNo'];
  					$CRdetail->ExpiryDate=$td['ExpiryDate'];
  					$CRdetail->Qty=$td['Qty'];
  					$CRdetail->UnitPrice=$td['UnitPrice'];
  					$CRdetail->FreebiesQty=$td['FreebiesQty'];
  					$CRdetail->FreebiesUnit=$td['FreebiesUnit'];
  					$CRdetail->save();
  				}
  				$result =1;
  			}
  			return Response::json($result);
  		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /cr/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /cr
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}
	/**
	 * Display the specified resource.
	 * GET /cr/{id}
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
	 * GET /cr/{id}/edit
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
	 * PUT /cr/{id}
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
	 * DELETE /cr/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}