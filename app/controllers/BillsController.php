<?php
use Acme\Repos\PurchaseOrder\PurchaseOrderRepository;
use Acme\Repos\Product\ProductRepository;
use Carbon\Carbon;
use Acme\Repos\PurchaseOrderDetails\PurchaseOrderDetailsRepository;
use Acme\Repos\Bills\BillsRepository;
use Acme\Repos\BillDetails\BillDetailsRepository;
class BillsController extends \BaseController {
private $purchaseOrderRepo;
private $productRepo;
private $purchaseOrderDetailsRepo;
private $billsRepo;
private $billDetailsRepo;
	function __construct(PurchaseOrderRepository $purchaseOrderRepo,ProductRepository $productRepo,
		PurchaseOrderDetailsRepository $purchaseOrderDetailsRepo, BillsRepository $billsRepo,
		BillDetailsRepository $billDetailsRepo)
		{
			$this->purchaseOrderRepo = $purchaseOrderRepo;
			$this->productRepo = $productRepo;
			$this->purchaseOrderDetailsRepo = $purchaseOrderDetailsRepo;
			$this->billsRepo = $billsRepo;
			$this->billDetailsRepo= $billDetailsRepo;
		}
	/**
	 * Display a listing of the resource.
	 * GET /bills
	 *
	 * @return Response
	 */
	public function index()
	{
		$max = $this->billsRepo->getMaxId();
		$supplier = Supplier::lists('SupplierName','id');
		$products = $this->productRepo->getAll();
		$POs= $this->purchaseOrderRepo->getAllApprovedPO();
		$bills= $this->billsRepo->getAllWithSup();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		return View::make('dashboard.Bills.list',compact('POs','supplier','products','max','now','lastweek','bills'));
	}
	public function savePOBill()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			if(!$TableData || !$input['SalesInvoiceNo'] || !$input['SalesInvoiceDate']){
  				$result = 0;
  			}else{
  				if($input['ApprovedBy'] == 1){
  					$approve = fullname(Auth::user());
  				}else{
  					$approve = '';
  				}
  				
  				$PO = PurchaseOrder::find($input['id']);
  				$bill = new Bill;
  				$bill->PurchaseOrderNo = $input['id'];
  				$bill->SupplierNo = $PO->SupplierNo;
  				$bill->BranchNo = Auth::user()->BranchNo;
  				$bill->BillDate = Carbon::now();
  				$bill->SalesInvoiceNo = $input['SalesInvoiceNo'];
  				$bill->SalesInvoiceDate = \Carbon\Carbon::createFromFormat('m/d/Y', $input['SalesInvoiceDate'])->toDateTimeString();
  				$bill->Terms = $input['term'];
  				$bill->PreparedBy = fullname(Auth::user());
  				$bill->ApprovedBy = $approve;
  				$bill->save();
  				$result =1;
  				foreach($TableData as $td){
  					$Billdetails= new BillDetail;
  					$Billdetails->BillNo=$bill->id;
  					$Billdetails->ProductNo=$td['ProductNo'];
  					$Billdetails->Unit=$td['Unit'];
  					$Billdetails->LotNo=$td['LotNo'];
	  				$Billdetails->ExpiryDate=$td['ExpiryDate'];
  					$Billdetails->Qty=$td['Qty'];
  					$Billdetails->FreebiesQty=$td['FreebiesQty'];
  					$Billdetails->FreebiesUnit=$td['FreebiesUnit'];
  					$Billdetails->CostPerQty=$td['CostPerQty'];
  					$Billdetails->save();
  				}
  			}
		return Response::json($result);
  		}
	}
	public function saveEditedPOBill(){
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);

  			if(!$TableData || !$input['SalesInvoiceNo'] || !$input['SalesInvoiceDate']){
  				$result = 0;
  			}else{ 
  				$billDetails = $this->billDetailsRepo->getAllByBill($id);
	  			foreach($billDetails as $d){
	  					$d->delete();
	  				}
  				$bills=Bill::find($id);
  				$bills->SalesInvoiceNo = $input['SalesInvoiceNo'];
  				$bills->SalesInvoiceDate = \Carbon\Carbon::createFromFormat('m/d/Y', $input['SalesInvoiceDate'])->toDateTimeString();
  				$bills->Terms = $input['term'];
  				$bills->PreparedBy = fullname(Auth::user());
  				$bills->save();
  				foreach($TableData as $td){
  					$Billdetails= new BillDetail;
  					$Billdetails->BillNo=$bills->id;
  					$Billdetails->ProductNo=$td['ProductNo'];
  					$Billdetails->Unit=$td['Unit'];
  					$Billdetails->LotNo=$td['LotNo'];
	  				$Billdetails->ExpiryDate=$td['ExpiryDate'];
  					$Billdetails->Qty=$td['Qty'];
  					$Billdetails->FreebiesQty=$td['FreebiesQty'];
  					$Billdetails->FreebiesUnit=$td['FreebiesUnit'];
  					$Billdetails->CostPerQty=$td['CostPerQty'];
  					$Billdetails->save();
  				}
  				$result =1;
  			}
		return Response::json($result);
  		}
	}
	public function viewBill(){
		if(Request::ajax()){
			$input = Input::all();
			$id= $input['id'];
			$bill= $this->billsRepo->getByIdWithSup($id);
		return Response::json($bill);
		}
	}
	public function viewBillDetails(){
		if(Request::ajax()){
			$input = Input::all();
			$id= $input['id'];
			$bill= $this->billDetailsRepo->getAllByBill($id);
		return Response::json($bill);
		}
	}
	public function cancelBill()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id = $input['id'];
  			$bill = Bill::find($id);
  			$bill->CancelledBy=fullname(Auth::user());
  			$bill->IsCancelled=1;
  			$bill->save();
  			return Response::json(fullname(Auth::user()));
  		}
	}
	public function approveBill()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id = $input['id'];
  			if($input['ApprovedBy']==1){
  				$approve = fullname(Auth::user());
  			}else{
  				$approve = '';
  			}
  			$PO = Bill::find($id);
  			$PO->ApprovedBy=$approve;
  			$PO->save();
  			return Response::json($approve);
  		}
	}


}