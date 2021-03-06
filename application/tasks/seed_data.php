<?php

class Seed_Data_Task
{

	public function run($arguments)
	{
		$user = User::all();
		if (count($user) > 0) {
			echo "User table not empty, aborting!\n";
			throw new RuntimeException('Exception: User table not empty!');
		}

		$this->insertUsers();

		$this->insertProducts();

		$this->insertProductImages();

		$this->insertOrders();
	}

	private function insertUsers()
	{
		echo "Inserting users/addresses";

		$admin = User::create(array(
			'role_id' => RoleEnum::ADMIN,
			'username' => 'admin',
			'email' => 'admin@example.com',
			'password' => Hash::make('123456')
			));
		$user = User::create(array(
			'role_id' => RoleEnum::USER,
			'username' => 'user',
			'email' => 'user@example.com',
			'password' => Hash::make('123456')
			));

		Address::create(array(
			'user_id' => $admin->id,
			'gender_id' => GenderEnum::FEMALE,
			'forename' => 'Marge',
			'surname' => 'Simpson',
			'street1' => '742 Evergreen Terrace',
			'zip' => '1337',
			'city' => 'Springfield',
			'country' => 'US',
		));
		Address::create(array(
			'user_id' => $user->id,
			'gender_id' => GenderEnum::MALE,
			'forename' => 'Bart',
			'surname' => 'Simpson',
			'street1' => 'c/o Homer Simpson',
			'street2' => '742 Evergreen Terrace',
			'zip' => '1337',
			'city' => 'Springfield',
			'country' => 'US',
		));
	}

	private function insertProducts()
	{
		echo "\nInserting categories/products";

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

	private function insertProductImages()
	{
		echo "\nInserting product images:";
		$categories = Category::all();
		foreach ($categories as $category) {
			$catName = strtolower($category->name);
			$catName = str_replace(' ', '', $catName);

			$products = $category->products()->get();
			foreach ($products as $product) {
				$prodName = strtolower($product->name);
				$prodName = str_replace(' ', '', $prodName);
				$prodName = str_replace('-', '', $prodName);
				
				$fileName = $catName.'_'.$prodName.'.png';
				$file = path('app').'tasks/img/'.$fileName;
				echo "\n".$file;
				$image = File::get($file);

				$productImage = new ProductImage(array('file' => $image));
				$product->productImage()->insert($productImage);
			}
		}
	}


	private function insertOrders()
	{
		echo "\nInserting orders";
		$user = User::where('username', '=', 'user')->first();

		// paid & shipped order
		$created = new DateTime('2010-01-01');
		$paid = new DateTime('2010-01-02');
		$shipped = new DateTime('2010-01-03');

		$order = new Order(array('paid_at' => $paid,
			'shipped_at' => $shipped,
		));
		$user->orders()->insert($order);
		// We have to manually set the created_at because
		// it is overrriden when inserted to db!
		$order->created_at = $created;
		$order->save();

		$xbox = Category::where('name', '=', 'Xbox 360')->first();
		$xboxProducts = $xbox->products()->get();
		$i = 1;
		foreach($xboxProducts as $product) {
			$item = new OrderItem(array('product_name' => $product->name,
				'category_name' => $xbox->name,
				'price' => $product->price,
				'quantity' => $i,
				));
			$order->items()->insert($item);
			$i++;
		}


		// paid order
		$created = new DateTime('2011-03-01');
		$paid = new DateTime('2011-03-02');

		$order = new Order(array('paid_at' => $paid));
		$user->orders()->insert($order);
		// We have to manually set the created_at because
		// it is overrriden when inserted to db!
		$order->created_at = $created;
		$order->save();

		$ps3 = Category::where('name', '=', 'Playstation 3')->first();
		$product = $ps3->products()->first();
		$item = new OrderItem(array('product_name' => $product->name,
			'category_name' => $ps3->name,
			'price' => $product->price,
			'quantity' => 2,
			));
		$order->items()->insert($item);


		// unpaid order
		$order = new Order();
		$user->orders()->insert($order);

		$pc = Category::where('name', '=', 'PC Games')->first();
		$product = $pc->products()->first();
		$item = new OrderItem(array('product_name' => $product->name,
			'category_name' => $pc->name,
			'price' => $product->price,
			'quantity' => 1,
			));
		$order->items()->insert($item);
	}

}