<?php
use Carbon\Carbon;
use Acme\Repos\SalesOrder\SalesOrderRepository;
use Acme\Repos\Product\ProductRepository;
use Acme\Repos\SalesInvoices\SIRepository;
use Acme\Repos\SalesOrderDetails\SalesOrderDetailsRepository;
use Acme\Repos\VwInventorySource\VwInventorySourceRepository;
use Acme\Repos\SalesInvoiceDetails\SIDetailsRepository;
use Acme\Repos\SalesPayment\SalesPaymentRepository;
class SalesPaymentController extends \BaseController {
	private $SIRepo;
	private $salesOrderRepo;
	private $vwInventorySource;
	private $salesPayment;
	function __construct(SalesOrderRepository $salesOrderRepo,ProductRepository $productRepo,
		SalesOrderDetailsRepository $salesOrderDetailsRepo,VwInventorySourceRepository $vwInventorySource,
		SIRepository $SIRepo,SIDetailsRepository $SIDetailsRepo,SalesPaymentRepository $salesPayment)
		{
			$this->salesOrderRepo = $salesOrderRepo;
			$this->productRepo = $productRepo;
			$this->salesOrderDetailsRepo = $salesOrderDetailsRepo;
			$this->vwInventorySource = $vwInventorySource;
			$this->SIRepo = $SIRepo;
			$this->SIDetailsRepo = $SIDetailsRepo;
			$this->salesPayment = $salesPayment;
		}
	/**
	 * Display a listing of the resource.
	 * GET /salespayment
	 *
	 * @return Response
	 */
	public function index()
	{
		$max = $this->salesPayment->getMaxId();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		$banks = Bank::lists('BankName','id');
		$customers = Customer::lists('CustomerName','id');
		$medReps = User::select(DB::raw('concat (firstname," ",lastname) as full_name,id'))->whereIn('UserType', array(4, 11))->lists('full_name', 'id');
		$invoices =  $this->SIRepo->getAllWithUnpaid();
			foreach($invoices as $invoice){
			$amount = DB::table('salesinvoicedetails')->select(DB::raw('sum(Qty * UnitPrice) as total'))->where('SalesInvoiceNo','=',$invoice->id)->groupBy('SalesInvoiceNo')->get();
  			$invoice['amount']=$amount[0]->total ;
		}
		$salesPayments = $this->salesPayment->getAll();
		foreach($salesPayments as $SP){
			$amount = DB::table('paymentinvoices')->select(DB::raw('sum(amount) as total'))->where('paymentNo','=',$SP->id)->groupBy('paymentNo')->get();
  			$SP['amount']=$amount[0]->total ;
  			$cash = SalesPaymentDetail::where('PaymentNo','=',$SP->id)->where('PaymentType','=',0)->get();
  			if(count($cash) > 0){$SP['cash']=1; }else{$SP['cash']=0;}
  			$check = SalesPaymentDetail::where('PaymentNo','=',$SP->id)->where('PaymentType','=',1)->get();
			if(count($check) > 0){ $SP['check']=1; }else{$SP['check']=0;}
		}
		// return $salesPayments;
		return View::make('dashboard.SalesPayments.list',compact('invoices','max','now','lastweek','customers','medReps','banks','salesPayments'));
	}
	public function addInvoiceToSalesPayment()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$bill= $this->SIRepo->getByidWithMedRep($id);
  			$amount = DB::table('salesinvoicedetails')->select(DB::raw('sum(Qty * UnitPrice) as total'))->where('SalesInvoiceNo','=',$bill[0]->id)->groupBy('SalesInvoiceNo')->get();
  			$bill[0]['amount']=$amount[0]->total ;
		return Response::json($bill[0]);
		}
	}
	public function getSP()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$SP= $this->salesPayment->getByid($id);
		return Response::json($SP);
		}
	}
	public function getSPDetails()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$SPD= SalesPaymentDetail::where('PaymentNo','=',$id)->get();
		return Response::json($SPD);
		}
	}
	public function getSPInvoices()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$id= $input['id'];
  			$SPI= SalesPaymentInvoice::selectRaw('paymentinvoices.*,a.SalesInvoiceRefDocNo,a.CustomerNo,c.CustomerName,
  				u.Lastname,u.Firstname,u.MI')
  			->join('salesinvoices AS a', 'a.id', '=', 'paymentinvoices.invoiceNo')
  			->join('users AS u', 'u.id', '=', 'a.UserNo')
  			->join('customers as c', 'c.id', '=', 'a.CustomerNo')
  			->where('PaymentNo','=',$id)
  			->get();
		return Response::json($SPI);
		}
	}
	public function salesPay()
	{
		if(Request::ajax()){
  			$input = Input::all();
  			$TableData = stripcslashes($input['TD']);
  			$TableData = json_decode($TableData,TRUE);
  			$PaymentType = stripcslashes($input['PT']);
  			$PaymentType = json_decode($PaymentType,TRUE);
  			if($input['approved'] == 1){
  				$approve = fullname(Auth::user());
  			}else{
  				$approve = '';
  			}
  			if($input['id']){
  				$id= $input['id'];
  				$SP = $this->salesPayment->getByid($id);
  				$SP->BranchNo= Auth::user()->BranchNo;
	  			$SP->PaymentDate=Carbon::now();
	  			$SP->PreparedBy=fullname(Auth::user());
	  			$SP->ApprovedBy=$approve;
	  			$SP->save();

  				$SPI = SalesPaymentInvoice::where('paymentNo','=',$id)->get();
	  			foreach($SPI as $s){
	  					$s->delete();
	  			}
	  			$SPD = SalesPaymentDetail::where('PaymentNo','=',$id)->get();
	  			foreach($SPD as $d){
	  					$d->delete();
	  			}
	  			
  			}else if(!$input['id']){
  				
	  			$SP = new SalesPayment;
	  			$SP->BranchNo= Auth::user()->BranchNo;
	  			$SP->PaymentDate=Carbon::now();
	  			$SP->PreparedBy=fullname(Auth::user());
	  			$SP->ApprovedBy=$approve;
	  			$SP->save();
	  		}
	  				foreach($PaymentType as $pt){
	  					$SPInvoice= new SalesPaymentDetail;
	  					$SPInvoice->paymentNo=$SP->id;
	  					if($pt['PaymentType'] == 'Cash'){
		  					$SPInvoice->PaymentType=0;
		  					$SPInvoice->amount=$pt['amount'];
		  					$SPInvoice->save();
		  				}else if($pt['PaymentType'] == 'Check'){
		  					$SPInvoice->PaymentType=1;
		  					$SPInvoice->BankNo=$pt['BankNo'];
		  					$SPInvoice->CheckNo=$pt['CheckNo'];
		  					$SPInvoice->CheckDueDate=\Carbon\Carbon::createFromFormat('Y-m-d', $pt['CheckDueDate'])->toDateTimeString();
		  					$SPInvoice->amount=$pt['amount'];
		  					$SPInvoice->save();
		  				}
		  				// else if($pt['PaymentType'] == 'Advance'){
		  				// 	$usedAdvance = AdvancePayment::where('customerNo','=',$input['customer_id'])
		  				// 					->where('isCharged','=',0)->first();
		  				// 	$usedAdvance->isCharged = 1;
		  				// 	$usedAdvance->chargedPaymentNo = $SP->id;
		  				// 	$usedAdvance->save();
		  				// }
	  				}
	  				foreach($TableData as $td){
	  					$SPInvoice= new SalesPaymentInvoice;
	  					$SPInvoice->paymentNo=$SP->id;
	  					$SPInvoice->invoiceNo=$td['invoiceNo'];
	  					$SPInvoice->amount=$td['amount'];
	  					$SPInvoice->save();
	  				}
	  				// if($input['advance'] != 0){
	  				// 	$advance = new AdvancePayment;
	  				// 	$advance->paymentNo = $SP->id;
	  				// 	$advance->customerNo = $input['customer_id'];
	  				// 	$advance->amount =  $input['advance'];
	  				// 	$advance->save();
	  				// }
	  			}
		return Response::json($input);
	}
	public function fetchBanks()
	{
		if(Request::ajax()){
  			$banks= Bank::all();
		return Response::json($banks);
		}
	}
	public function checkPayments()
	{
		if(Request::ajax()){
			$input = Input::all();
  			// $advance= AdvancePayment::where('customerNo','=',$input['customer_id'])
  			// 							->where('isCharged','=',0)->get();
  			$payments=DB::table('paymentdetails')
  						->join('payments', 'payments.id', '=', 'paymentdetails.PaymentNo')
  						->join('paymentinvoices', 'paymentinvoices.paymentNo', '=', 'payments.id')
  						->join('salesinvoices', 'salesinvoices.id', '=', 'paymentinvoices.invoiceNo')
  						->where('salesinvoices.CustomerNo','=',$input['customer_id'])
  						->sum('paymentdetails.amount');
  			$invoices = DB::table('paymentinvoices')
  						->join('salesinvoices', 'salesinvoices.id', '=', 'paymentinvoices.invoiceNo')
  						->where('salesinvoices.CustomerNo','=',$input['customer_id'])
  						->sum('paymentinvoices.amount');
			return Response::json($payments-$invoices);
		}
	}
	public function getPaymentAdvance()
	{
		if(Request::ajax()){
			$input = Input::all();
  			// $advance= AdvancePayment::where('chargedPaymentNo','=',$input['id'])
  			// 							->where('isCharged','=',1)->get();
  			$payments=DB::table('paymentdetails')
  						->join('payments', 'payments.id', '=', 'paymentdetails.PaymentNo')
  						->join('paymentinvoices', 'paymentinvoices.paymentNo', '=', 'payments.id')
  						->join('salesinvoices', 'salesinvoices.id', '=', 'paymentinvoices.invoiceNo')
  						->where('salesinvoices.CustomerNo','=',$input['customer_id'])
  						->sum('paymentdetails.amount');
  			$invoices = DB::table('paymentinvoices')
  						->join('salesinvoices', 'salesinvoices.id', '=', 'paymentinvoices.invoiceNo')
  						->where('salesinvoices.CustomerNo','=',$input['customer_id'])
  						->sum('paymentinvoices.amount');
  			
			return Response::json($advance);
		}
	}
	public function getPaymentTypes()
	{ 
		if(Request::ajax()){
			$input = Input::all();
  			$payment= SalesPaymentDetail::where('PaymentNo','=',$input['id'])->get();
			return Response::json($payment);
		}
	}
	


}