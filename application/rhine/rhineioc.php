<?php namespace Rhine;

use Laravel\IoC;

class RhineIoC
{
	/**
	 * Register and wire objects.
	 */
	public static function init()
	{
		// Viewmanagers
		IoC::singleton('assetManager', function() {
			return new Viewmanagers\AssetManager();
		});

		// Repositories
		IoC::singleton('categoryRepository', function() {
			return new Repositories\Eloquent\EloquentCategoryRepository();
		});
		IoC::singleton('productRepository', function() {
			return new Repositories\Eloquent\EloquentProductRepository();
		});

		// Services


		// Actions
		IoC::register('shopGetIndexAction', function() {
			return new Actions\Shop\ShopGetIndexAction(IoC::resolve('categoryRepository'),
					IoC::resolve('productRepository'));
		});
		IoC::register('shopGetCategoryAction', function() {
			return new Actions\Shop\ShopGetCategoryAction(IoC::resolve('categoryRepository'),
					IoC::resolve('productRepository'));
		});
	}
}