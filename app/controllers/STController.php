<?php
use Acme\Repos\StockTransfer\StockTransferRepository;
use Carbon\Carbon;
use Acme\Repos\StockTransferDetails\StockTransferDetailsRepository;
use Acme\Repos\VwInventorySource\VwInventorySourceRepository;
// use Acme\Repos\Branch\BranchRepository;

class STController extends \BaseController {
	private $stockTransferRepo;
	private $vwInventorySource;
	// private $branchRepo;
	private $stockTransferDetailsRepo;

	function __construct(StockTransferRepository $stockTransferRepo,VwInventorySourceRepository $vwInventorySource,
		StockTransferDetailsRepository $stockTransferDetailsRepo)
		{
			$this->stockTransferRepo = $stockTransferRepo;
			// $this->branchRepo = $branchRepo;
			$this->stockTransferDetailsRepo = $stockTransferDetailsRepo;
			$this->vwInventorySource = $vwInventorySource;
		}

	/**
	 * Display a listing of the resource.
	 * GET /st
	 *
	 * @return Response
	 */
	public function index()
	{
		$max = $this->stockTransferRepo->getMaxId();
		$branchSource = Branch::find(Auth::user()->BranchNo);
		$branches = Branch::where('id','!=', Auth::user()->BranchNo)->lists('BranchName','id');
		$products = $this->vwInventorySource->getInventorySourceWholeSale();
		// $STs= $this->stockTransferRepo->getAllWithCus();
		$now =date("m/d/Y");
		$lastweek=date("m/d/Y", strtotime("- 7 day"));
		return View::make('dashboard.StockTransfers.list',compact('customers','products','max','now','lastweek','branchSource','branches'));
	}

	

}