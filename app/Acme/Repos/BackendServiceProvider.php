<?php namespace Acme\Repos;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider{

	public function register(){
		$this->app->bind('Acme\Repos\Product\ProductRepository','Acme\Repos\Product\DbProductRepository');
		$this->app->bind('Acme\Repos\Supplier\SupplierRepository','Acme\Repos\Supplier\DbSupplierRepository');
		$this->app->bind('Acme\Repos\ProductCategory\ProductCategoryRepository','Acme\Repos\ProductCategory\DbProductCategoryRepository');
		$this->app->bind('Acme\Repos\User\UserRepository','Acme\Repos\User\DbUserRepository');

	}
}