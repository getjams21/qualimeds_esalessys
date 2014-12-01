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

	}
}