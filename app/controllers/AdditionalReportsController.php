<?php

use Carbon\Carbon;
use Acme\Repos\Product\ProductRepository;
use Acme\Repos\VwInventorySource\VwInventorySourceRepository;
use Acme\Repos\VwMonthlySalesSource\VwMonthlySalesSourceRepo;

class AdditionalReportsController extends \BaseController {

	private $productRepo; 
	private $vwInventorySource;
	private $vwMonthlySalesSourceRepos;

	function __construct(ProductRepository $productRepo,
		VwInventorySourceRepository $vwInventorySource,
		VwMonthlySalesSourceRepo $vwMonthlySalesSourceRepos)
		{
			$this->productRepo = $productRepo;
			$this->vwInventorySource = $vwInventorySource;
			$this->vwMonthlySalesSourceRepos = $vwMonthlySalesSourceRepos;
		}

	/**
	 * Display a listing of the resource.
	 * GET /additionalreports
	 *
	 * @return Response
	 */
	public function index()
	{
		$products= $this->productRepo->getAllWithCat();
		$summary= $this->vwInventorySource->productInventorySummary();
		$now =date("m/d/Y");
		$onemonth=date("m/d/Y", strtotime("- 30 day"));
		$medReps = User::select(DB::raw('concat (firstname," ",lastname) as full_name,id'))->whereIn('UserType', array(4, 11))->lists('full_name', 'id');
		return View::make('dashboard.Reports.additional-reports',compact('products','summary','medReps','onemonth','now'));
	}

	public function getMonthlySalesReport(){
		if(Request::ajax()){
			$from = Input::get('from');
			$to = Input::get('to');
			$medRep = User::find(Input::get('medRep'));
			$salesRep = $medRep->Lastname.', '.$medRep->Firstname.'  '.$medRep->MI;
			// dd($salesRep);
			$monthlySalesReport = $this->vwMonthlySalesSourceRepos->getMonthlySalesReport($from,$to,$salesRep);
			return Response::json($monthlySalesReport);
		}
	}

	public function getMonthlyCollectionReport(){
		if(Request::ajax()){
			$from = Input::get('from');
			$to = Input::get('to');

			$from = date("Y-m-d", strtotime($from.'-1 day'));
			$to = date("Y-m-d", strtotime($to.'+1 days'));

			$medRep = User::find(Input::get('medRep'));
			$salesRep = $medRep->Lastname.', '.$medRep->Firstname.' '.$medRep->MI;
			// dd($from);
			$monthlyCollectionReport = VwMonthlyCollectionSource::where('SalesRep','=',$salesRep)->whereBetween('PaymentDate', array($from, $to))->get();
			return Response::json($monthlyCollectionReport);
		}
	}
	/**
	 * Show the form for creating a new resource.
	 * GET /additionalreports/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /additionalreports
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /additionalreports/{id}
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
	 * GET /additionalreports/{id}/edit
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
	 * PUT /additionalreports/{id}
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
	 * DELETE /additionalreports/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}