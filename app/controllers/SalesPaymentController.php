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
		$customers = Customer::lists('CustomerName','id');
		$medReps = User::select(DB::raw('concat (firstname," ",lastname) as full_name,id'))->whereIn('UserType', array(4, 11))->lists('full_name', 'id');
		$invoices =  $this->SIRepo->getAllWithUnpaid();
			foreach($invoices as $invoice){
			$amount = DB::table('salesinvoicedetails')->select(DB::raw('sum(Qty * UnitPrice) as total'))->where('SalesInvoiceNo','=',$invoice->id)->groupBy('SalesInvoiceNo')->get();
  			$invoice['amount']=$amount[0]->total ;
		}
		return View::make('dashboard.SalesPayments.list',compact('invoices','max','now','lastweek','customers','medReps'));
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
	/**
	 * Show the form for creating a new resource.
	 * GET /salespayment/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /salespayment
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /salespayment/{id}
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
	 * GET /salespayment/{id}/edit
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
	 * PUT /salespayment/{id}
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
	 * DELETE /salespayment/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}