<?php
use Acme\Repos\PurchaseOrder\PurchaseOrderRepository;
use Acme\Repos\Product\ProductRepository;
class POController extends \BaseController {
	private $purchaseOrderRepo;
	function __construct(PurchaseOrderRepository $purchaseOrderRepo,ProductRepository $productRepo)
		{
			$this->purchaseOrderRepo = $purchaseOrderRepo;
			$this->productRepo = $productRepo;
		}
	/**
	 * Display a listing of the resource.
	 * GET /po
	 *
	 * @return Response
	 */
	public function index()
	{	
		$supplier = Supplier::lists('SupplierName','id');
		$products = $this->productRepo->getAll();
		$POs= $this->purchaseOrderRepo->getAll();
		return View::make('dashboard.PurchaseOrders.list',compact('POs','supplier','products'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /po/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /po
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /po/{id}
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
	 * GET /po/{id}/edit
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
	 * PUT /po/{id}
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
	 * DELETE /po/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}