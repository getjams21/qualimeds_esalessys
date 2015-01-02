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
	  				if($input['cash']==1){
	  					$SPCash = new SalesPaymentDetail;
	  					$SPCash->PaymentNo = $SP->id;
	  					$SPCash->PaymentType = 0;
	  					$SPCash->amount = $input['cashAmount'];
	  					$SPCash->save();
	  				}
	  				if($input['check']==1){
	  					$SPCheck = new SalesPaymentDetail;
	  					$SPCheck->PaymentNo = $SP->id;
	  					$SPCheck->PaymentType = 1;
	  					$SPCheck->CheckNo = $input['checkNo'];
	  					$SPCheck->CheckDueDate = \Carbon\Carbon::createFromFormat('m/d/Y', $input['checkDueDate'])->toDateTimeString();
	  					$SPCheck->amount = $input['checkAmount'];
	  					$SPCheck->BankNo = $input['BankNo'];
	  					$SPCheck->save();
	  				}
	  				foreach($TableData as $td){
	  					$SPInvoice= new SalesPaymentInvoice;
	  					$SPInvoice->paymentNo=$SP->id;
	  					$SPInvoice->invoiceNo=$td['invoiceNo'];
	  					$SPInvoice->amount=$td['amount'];
	  					$SPInvoice->save();
	  				}
	  			}
		return Response::json($input);
	}
	


}