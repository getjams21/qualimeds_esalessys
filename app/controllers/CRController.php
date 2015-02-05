<?php
use Acme\Repos\CustomerReturns\CRRepository;
use Carbon\Carbon;
use Acme\Repos\CustomerReturnDetails\CRDRepository;
use Acme\Repos\SalesInvoices\SIRepository;
use Acme\Repos\SalesInvoiceDetails\SIDetailsRepository;
use Acme\Repos\Customers\CustomerRepository;

class CRController extends \BaseController {
	private $customerReturnRepo;
	private $customerReturnDetailsRepo;
	private $salesInvoiceRepo;
	private $salesInvoiceDetailsRepo;

	function __construct(CRRepository $customerReturnRepo,CRDRepository $customerReturnDetailsRepo,
		SIRepository $salesInvoiceRepo,SIDetailsRepository $salesInvoiceDetailsRepo)
	{
		$this->customerReturnRepo = $customerReturnRepo;
		$this->customerReturnDetailsRepo = $customerReturnDetailsRepo;
		$this->salesInvoiceRepo = $salesInvoiceRepo;
		$this->salesInvoiceDetailsRepo = $salesInvoiceDetailsRepo;
	}

	/**
	 * Display a listing of the resource.
	 * GET /cr
	 *
	 * @return Response
	 */
	public function index()
	{
		$max = $this->customerReturnRepo->getMaxId();
		$customers = Customer::lists('CustomerName','id');
		$defaultCus = Customer::firstOrFail();
		$CRs= $this->customerReturnRepo->getAllWithBranch();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		$customerSalesInvoices = $this->salesInvoiceRepo->getAllByCustomer($defaultCus->id);
		return View::make('dashboard.CustomerReturns.list', compact('customers','max','customerSalesInvoices','now','lastweek','CRs')); 
	}

	public function fetchCustomerSI(){
		if(Request::ajax()){
			$customerSI = $this->salesInvoiceRepo->getAllByCustomer(Input::get('id'));
			return Response::json($customerSI);
		}
	}

	public function fetchSIItems(){
		if(Request::ajax()){
			$SIdetails = $this->salesInvoiceDetailsRepo->getAllBySO(Input::get('id'));
			return Response::json($SIdetails);
		}
	}

	public function fetchSI(){
		if(Request::ajax()){
			$SI = $this->salesInvoiceRepo->getByid(Input::get('SIno'));
			return Response::json($SI);
		}
	}

	public function saveCR(){
		if(Request::ajax()){
  			$input = Input::all();
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			if(!$TableData || !$input['CustomerNo']){
  				$result = 0;
  			}else{
  				$CR= new CustomerReturn;
  				$CR->SalesInvoiceNo=$input['SalesinvoiceNo'];
  				$CR->BranchNo = Auth::user()->BranchNo;
  				$CR->CustomerReturnDate= Carbon::now();
  				$CR->Remarks=$input['Remarks'];
  				$CR->PreparedBy= $input['PreparedBy'];
  				$CR->ApprovedBy= $input['approvedBy'];
  				$CR->save();
  				$result =1;
  				foreach($TableData as $td){
  					// dd($td['Qty']);
  					$CRdetail= new CustomerReturnDetail;
  					$CRdetail->CustomerReturnNo=$CR->id;
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