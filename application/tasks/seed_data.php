<?php

class Seed_Data_Task
{

	public function run($arguments)
	{
		User::create(array(
			'username' => 'admin',
			'email' => 'admin@localhost',
			'password' => Hash::make('1234')
			));

		$pcGames = Category::create(array(
			'name' => 'PC Games',
			'order' => 1
			));
		$products = array(
			array(
				'name' => 'Tomb Raider',
				'price' => 5900,
				'stocksize' => 10),
			array(
				'name' => 'Far Cry 3',
				'price' => 5900,
				'stocksize' => 10),
			array(
				'name' => 'Landwirtschafts-Simulator 2013',
				'price' => 2990,
				'stocksize' => 12)
			);
		$pcGames->products()->save($products);


		$ps3 = Category::create(array(
			'name' => 'Playstation 3',
			'order' => 2
			));
		$products = array(
			array(
				'name' => 'Tomb Raider',
				'price' => 6900,
				'stocksize' => 5),
			array(
				'name' => 'Far Cry 3',
				'price' => 7500,
				'stocksize' => 10),
			array(
				'name' => 'NHL 13',
				'price' => 3990,
				'stocksize' => 3),
			array(
				'name' => 'Gran Turismo 6',
				'price' => 7900,
				'stocksize' => 0)
			);
		$ps3->products()->save($products);


		$xbox = Category::create(array(
			'name' => 'Xbox 360',
			'order' => 3
			));
		$products = array(
			array(
				'name' => 'Tomb Raider',
				'price' => 6900,
				'stocksize' => 8),
			array(
				'name' => 'Far Cry 3',
				'price' => 7500,
				'stocksize' => 10),
			array(
				'name' => 'NHL 13',
				'price' => 3990,
				'stocksize' => 4),
			array(
				'name' => 'Halo 4',
				'price' => 4990,
				'stocksize' => 6)
			);
		$xbox->products()->save($products);
	}

	public function clean($arguments)
	{
		$admin = User::where('username', '=', 'admin')->first();
		$admin->delete();

		$products = Product::all();
		foreach ($products as $product) {
			$product->delete();
		}
		$categories = Category::all();
		foreach ($categories as $category) {
			$category->delete();
		}
	}

}