<?php namespace Rhine\Actions\Cart;

use Rhine\Services\CartService;
use Laravel\Redirect;

class CartPostAddProductAction
{

	private $cartService;

	function __construct(CartService $cartService)
	{
		$this->cartService = $cartService;
	}

	/**
	 * @return View
	 */
	public function execute($productId)
	{
		$cart = $this->cartService->loadCart();
		$cart->addPosition($productId);
		$this->cartService->saveCart($cart);
		return Redirect::to_route('cart');
	}

}