<?php namespace Acme\Repos;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider{

	public function register(){
		$this->app->bind('Acme\Repos\Product\ProductRepository','Acme\Repos\Product\DbProductRepository');
		$this->app->bind('Acme\Repos\Supplier\SupplierRepository','Acme\Repos\Supplier\DbSupplierRepository');
		$this->app->bind('Acme\Repos\ProductCategory\ProductCategoryRepository','Acme\Repos\ProductCategory\DbProductCategoryRepository');
		#Purchase Order
		$this->app->bind('Acme\Repos\PurchaseOrder\PurchaseOrderRepository','Acme\Repos\PurchaseOrder\DbPurchaseOrderRepository');
		$this->app->bind('Acme\Repos\PurchaseOrderDetails\PurchaseOrderDetailsRepository','Acme\Repos\PurchaseOrderDetails\DbPurchaseOrderDetailsRepository');
		#Sales Order
		$this->app->bind('Acme\Repos\SalesOrder\SalesOrderRepository','Acme\Repos\SalesOrder\DbSalesOrderRepository');
		$this->app->bind('Acme\Repos\SalesOrderDetails\SalesOrderDetailsRepository','Acme\Repos\SalesOrderDetails\DbSalesOrderDetailsRepository');
		#Users
		$this->app->bind('Acme\Repos\User\UserRepository','Acme\Repos\User\DbUserRepository');
		#Bills
		$this->app->bind('Acme\Repos\Bills\BillsRepository','Acme\Repos\Bills\DbBillsRepository');
		$this->app->bind('Acme\Repos\BillDetails\BillDetailsRepository','Acme\Repos\BillDetails\DbBillDetailsRepository');
		#BillPayments
		$this->app->bind('Acme\Repos\BillPayments\BillPaymentsRepository','Acme\Repos\BillPayments\DbBillPaymentsRepository');
		$this->app->bind('Acme\Repos\BillPaymentDetails\BillPaymentDetailsRepository','Acme\Repos\BillPaymentDetails\DbBillPaymentDetailsRepository');
		#SalesInvoices		
		$this->app->bind('Acme\Repos\SalesInvoices\SIRepository','Acme\Repos\SalesInvoices\DBSIRepository');
		#SalesInvoiceDetails
		$this->app->bind('Acme\Repos\SalesInvoiceDetails\SIDetailsRepository','Acme\Repos\SalesInvoiceDetails\DBSIDetailsRepository');
		#SalesPayment		
		$this->app->bind('Acme\Repos\SalesPayment\SalesPaymentRepository','Acme\Repos\SalesPayment\DBSalesPaymentRepository');
		$this->app->bind('Acme\Repos\VwCustomerBalances\CustomerBalancesRepository','Acme\Repos\VwCustomerBalances\DbCustomerBalancesRepository');

		#Inventory Source
		$this->app->bind(
			'Acme\Repos\VwInventorySource\VwInventorySourceRepository',
			'Acme\Repos\VwInventorySource\DbVwInventorySource'
			);

		#Stock Transfers
		$this->app->bind(
			'Acme\Repos\StockTransfer\StockTransferRepository',
			'Acme\Repos\StockTransfer\DbStockTransferRepository'
			);
		$this->app->bind(
			'Acme\Repos\StockTransferDetails\StockTransferDetailsRepository',
			'Acme\Repos\StockTransferDetails\DbStockTransferDetailsRepository'
			);

		#Inventory Adjustments
		$this->app->bind(
			'Acme\Repos\InventoryAdjustments\InventoryAdjustmentRepository',
			'Acme\Repos\InventoryAdjustments\DbInventoryAdjustmentRepository'
			);
		$this->app->bind(
			'Acme\Repos\InventoryAdjustmentDetails\InventoryAdjustmentDetailsRepository',
			'Acme\Repos\InventoryAdjustmentDetails\DbInventoryAdjustmentDetailsRepository'
			);

		#Customer Returns
		$this->app->bind(
			'Acme\Repos\CustomerReturns\CRRepository',
			'Acme\Repos\CustomerReturns\DBCRRepository'
			);
		$this->app->bind(
			'Acme\Repos\CustomerReturnDetails\CRDRepository',
			'Acme\Repos\CustomerReturnDetails\DBCRDRepository'
			);

		#Supplier Returns
		$this->app->bind(
			'Acme\Repos\SupplierReturns\SRRepository',
			'Acme\Repos\SupplierReturns\DBSRRepository'
			);
		$this->app->bind(
			'Acme\Repos\SupplierReturnDetails\SRDRepository',
			'Acme\Repos\SupplierReturnDetails\DBSRDRepository'
			);

		#Inventory Damages
		$this->app->bind(
			'Acme\Repos\Damages\DamagesRepository',
			'Acme\Repos\Damages\DbDamagesRepository'
			);
		$this->app->bind(
			'Acme\Repos\DamagesDetails\DamagesDetailsRepository',
			'Acme\Repos\DamagesDetails\DbDamagesDetailsRepository'
			);
	}
}