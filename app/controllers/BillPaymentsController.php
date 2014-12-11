<?php
use Carbon\Carbon;
use Acme\Repos\Bills\BillsRepository;
use Acme\Repos\BillDetails\BillDetailsRepository;
use Acme\Repos\BillPayments\BillPaymentsRepository;
use Acme\Repos\BillPaymentDetails\BillPaymentDetailsRepository;
class BillPaymentsController extends \BaseController {
private $billsRepo;
private $billDetailsRepo;
private $billPaymentsRepo;
private $billPaymentDetailsRepo;
	function __construct(BillsRepository $billsRepo,
		BillDetailsRepository $billDetailsRepo,BillPaymentsRepository $billPaymentsRepo,
		BillPaymentDetailsRepository $billPaymentDetailsRepo)
		{
			$this->billsRepo = $billsRepo;
			$this->billDetailsRepo= $billDetailsRepo;
			$this->billPaymentsRepo= $billPaymentsRepo;
			$this->billPaymentDetailsRepo= $billPaymentDetailsRepo;
		}
	/**
	 * Display a listing of the resource.
	 * GET /billpayments
	 *
	 * @return Response
	 */
	public function index()
	{
		$max = $this->billPaymentsRepo->getMaxId();
		$bills=$this->billsRepo->getAllWithSupUnpaid();
		foreach($bills as $bill){
			$amount = DB::table('purchaseorderdetails')->select(DB::raw('sum(Qty * CostPerQty) as total'))->where('PurchaseOrderNo','=',$bill->PurchaseOrderNo)->groupBy('PurchaseOrderNo')->get();
  			$bill['amount']=$amount[0]->total ;
		}
		$supplier = Supplier::lists('SupplierName','id');
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		$banks = Bank::lists('BankName','id');
		$maxCashVoucher=$this->billPaymentsRepo->getMaxCashVoucher();
		$maxCheckVoucher=$this->billPaymentsRepo->getMaxCheckVoucher();
		$billpayments=$this->billPaymentsRepo->getAll();
		return View::make('dashboard.BillPayments.list',compact('bills','max','now','lastweek','supplier','banks','maxCashVoucher','maxCheckVoucher','billpayments'));
	}
	public function addBillToPayment()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$bill= $this->billsRepo->getByIdWithSup($id);
  			$amount = DB::table('purchaseorderdetails')->select(DB::raw('sum(Qty * CostPerQty) as total'))->where('PurchaseOrderNo','=',$bill[0]->PurchaseOrderNo)->groupBy('PurchaseOrderNo')->get();
  			$bill['amount']=$amount[0]->total ;
		return Response::json($bill);
		}
	}
	public function billPayment()
	{
		if(Request::ajax()){
			$maxCash=$this->billPaymentsRepo->getMaxCashVoucher();
			$maxCheck=$this->billPaymentsRepo->getMaxCheckVoucher();
  			$input = Input::all();
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			if($input['approved'] == 1){
  				$approve = fullname(Auth::user());
  			}else{
  				$approve = '';
  			}
  			if($input['id']){
  				$id= $input['id'];
  				$billPayment = $this->billPaymentsRepo->getById($id);
  				$billPayment->PaymentDate=Carbon::now();
  				$billPayment->PaymentType=$input['type'];
  				if($input['type'] ==0){
	  				$billPayment->CashVoucherNo=$maxCash+1;
	  				$billPayment->CheckVoucherNo = null;
	  			}else if($input['type'] ==1){
	  				$billPayment->CheckVoucherNo = $maxCheck+1;
	  				$billPayment->CashVoucherNo=null;
	  				$billPayment->CheckDueDate = \Carbon\Carbon::createFromFormat('m/d/Y', $input['checkDueDate'])->toDateTimeString();
	  				$billPayment->CheckNo = $input['checkNo'];
	  				$billPayment->BankNo = $input['BankNo'];
	  			}
	  			$billPayment->amount=$input['amount'];
	  			$billPayment->PreparedBy=fullname(Auth::user());
	  			$billPayment->ApprovedBy=$approve;
	  			$billPayment->save();
	  			$BPdetails = $this->billPaymentDetailsRepo->getByBP($id);
	  			foreach($BPdetails as $d){
	  					$d->delete();
	  			}
		  		foreach($TableData as $td){
  					$billPaymentDetail= new BillPaymentDetail;
  					$billPaymentDetail->BillPaymentNo=$id;
  					$billPaymentDetail->BillNo=$td['BillNo'];
  					$billPaymentDetail->Amount=$td['amount'];
  					$billPaymentDetail->save();
		  		}
  			}else if(!$input['id']){
	  			$billPayment = new BillPayment;
	  			$billPayment->PaymentDate=Carbon::now();
	  			$billPayment->PaymentType=$input['type'];
	  			if($input['type'] ==0){
	  				$billPayment->CashVoucherNo=$maxCash+1;
	  			}else if($input['type'] ==1){
	  				$billPayment->CheckVoucherNo = $maxCheck+1;
	  				$billPayment->CheckDueDate = \Carbon\Carbon::createFromFormat('m/d/Y', $input['checkDueDate'])->toDateTimeString();
	  				$billPayment->CheckNo = $input['checkNo'];
	  				$billPayment->BankNo = $input['BankNo'];
	  			}
	  			$billPayment->amount=$input['amount'];
	  			$billPayment->PreparedBy=fullname(Auth::user());
	  			$billPayment->ApprovedBy=$approve;
	  			$billPayment->save();
	  				foreach($TableData as $td){
	  					$billPaymentDetail= new BillPaymentDetail;
	  					$billPaymentDetail->BillPaymentNo=$billPayment->id;
	  					$billPaymentDetail->BillNo=$td['BillNo'];
	  					$billPaymentDetail->Amount=$td['amount'];
	  					$billPaymentDetail->save();
	  				}
	  			}
		return Response::json($billPayment);
		}
	}
	public function getbillPayments()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$bill= $this->billPaymentsRepo->getByid($id);
  			$billDetails=$this->billPaymentDetailsRepo->getAllWithSup($id);
			return Response::json($bill);
		}
	}
	public function getbillPaymentDetails()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$billDetails=$this->billPaymentDetailsRepo->getAllWithSup($id);
			return Response::json($billDetails);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /billpayments/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /billpayments
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /billpayments/{id}
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
	 * GET /billpayments/{id}/edit
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
	 * PUT /billpayments/{id}
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
	 * DELETE /billpayments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}