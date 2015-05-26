<?php
use Carbon\Carbon;
use Acme\Repos\Product\ProductRepository;
use Acme\Repos\VwInventorySource\VwInventorySourceRepository;

class ReportsController extends \BaseController {

	private $productRepo; 
	private $vwInventorySource;
	function __construct(ProductRepository $productRepo,VwInventorySourceRepository $vwInventorySource)
		{
			$this->productRepo = $productRepo;
			$this->vwInventorySource = $vwInventorySource;
		}

	/**
	 * Display a listing of the resource.
	 * GET /reports
	 *
	 * @return Response
	 */
	public function index()
	{
		$products= $this->productRepo->getAllWithCat();
		$summary= $this->vwInventorySource->productInventorySummary();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		$medReps = User::select(DB::raw('concat (firstname," ",lastname) as full_name,id'))->whereIn('UserType', array(4, 11))->lists('full_name', 'id');
		$customers = Customer::where('IsActive','=',1)->lists('CustomerName','id');
		return View::make('dashboard.Reports.reports',compact('products','summary','medReps','lastweek','now','customers'));
	}

	/**
	 * Display the specified resource.
	 * GET /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function fetchInventorySummary()
	{
		if(Request::ajax()){
			$summary= $this->vwInventorySource->productInventorySummary();
			return Response::json($summary);
		}
	}
	
	public function fetchInventoryByLotNo()
	{
		if(Request::ajax()){
			$summary= $this->vwInventorySource->productInventoryByLotNo();
			return Response::json($summary);
		}
	}
	public function fetchInventoryByStockCard()
	{
		if(Request::ajax()){
			 $summary= VwInventoryByStockCard::all();
			 return Response::json($summary);
		}
	}
	public function fetchInventoryByStockCardId()
	{
		if(Request::ajax()){
			$input = Input::all();
			 $summary= VwInventoryByStockCard::where('ProductNo','=',$input['id'])->get();
			 return Response::json($summary);
		}
	}
	public function reportProductDtAjax()
	{	
		$result = DB::table('products')
		->select('id as id', 'ProductName as ProductName', 'BrandName', 'WholeSaleUnit');
 
	return Datatables::of($result)
			
			->add_column('add','<td><button class="btn btn-primary btn-xs square " onclick="prodReport({{$id}})"> View</button>
                      </td>')	
			->make();
	}
	public function fetchInventoryGainLoss()
	{
		if(Request::ajax()){
			$input = Input::all();
			$from = date("Y-m-d",strtotime($input['from']));
			$to =   date("Y-m-d",strtotime($input['to'])); 

			 $summary= GainLoss::whereBetween('TransDate',array($from, $to))
			 	->where('id','=',$input['medrep'])
			 					->get();
			 return Response::json($summary);
		}
	}
	public function fetchCustomerLedger()
	{
		if(Request::ajax()){
			$input = Input::all();
			$cus = $input['cus'];
			 $summary= CustomerLedger::selectRaw('vwcustomerledger.*,b.BranchName,c.CustomerName')
			 			->join('branches as b','b.id','=','vwcustomerledger.BranchNo')
			 			->join('customers as c','c.id','=','vwcustomerledger.CustomerNo')
			 			->where('vwcustomerledger.CustomerNo','=',$cus)
			 			->get();
			 return Response::json($summary);
		}
	}
	public function fetchCustomerInReport()
	{
		if(Request::ajax()){
			$input = Input::all();
			$cus = $input['id'];
			$customer =Customer::find($cus);
			 return Response::json($customer);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /reports/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /reports
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /reports/{id}
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
	 * GET /reports/{id}/edit
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
	 * PUT /reports/{id}
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
	 * DELETE /reports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}