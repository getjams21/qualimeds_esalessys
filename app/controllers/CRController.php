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
		$customerSalesInvoices = $this->salesInvoiceRepo->getAllByCustomer($defaultCus->id);
		return View::make('dashboard.CustomerReturns.list', compact('customers','max','customerSalesInvoices')); 
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