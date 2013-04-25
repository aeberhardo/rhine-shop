<?php namespace Rhine\Repositories\Eloquent;

use Category;
use Rhine\Repositories\CategoryRepository;

class EloquentCategoryRepository implements CategoryRepository
{
	
	function findAllOrdered()
	{
		$categories = Category::order_by('order', 'asc')->get();
		return $categories;
	}

}