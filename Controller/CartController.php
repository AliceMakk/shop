<?php
namespace Controller;

use Model\Product;
use View\View;
use Helper\DataFormaterTrait;

/**
 * The class is responsible for:
 * 1. displaying items in the cart
 * 2. removing items from the cart
 * 3. adding items to the cart
 * 4. talling items in the cart
 */
class CartController {
	use DataFormaterTrait;

	public function __construct()
	{
		$this->product = new Product();
		$this->view = new View();
		$this->cartProducts = $_SESSION['cart'] ?? [];
	}

	/**
	 * Showing cart and items in it
	 */
	public function showCart()
	{
		$cartData = $this->getCartData();
		$this->view->getCartView($cartData);
	}

	/**
	 * Retreiving items and their total from session, checking data with Product "table" 
	 */
	private function getCartData()
	{
		$products = [];

		foreach ($this->cartProducts as $cartProduct) {
			try {
				$product = $this->product->getById($cartProduct['id']);
				$product['price'] = $this->formatAmount($product['price']);
				$product['deleteLink'] = "?action=clear_cart&id={$cartProduct['id']}";
				$product['quantity'] = $cartProduct['quantity'];
			} catch (Exception $e) {
				// Logging error for future analysis
				// In case if a product is not found, we skip that error, in case if the product doesn't exist anymore
				continue;
			}
			
			$products[] = $product;
		}

		$combinedCart = [
			'cartList' => $products,
			'cartTotal' => $this->formatAmount($_SESSION['cartTotal'] ?? 0),
		];

		return $combinedCart;
	}

	/**
	 * Deleting an item from cart or decrease its quantity
	 * Readding items ids and their quantity to the session
	 */
	public function deleteFromCart($id)
	{
		// Showing the item in the current cart
		foreach ($this->cartProducts as $key => $cartProduct) {
			if($cartProduct['id'] !== $id) {
				continue;
			}
			if($cartProduct['quantity'] > 1) {
				$this->cartProducts[$key]['quantity'] -= 1;
			} else {
				unset($this->cartProducts[$key]);
			}
			break;
		}

		unset($_SESSION['cart'], $_SESSION['cartTotal']);

		// A product might not be longer available
		// So just in case we need to recheck current cart and recalculate total
		foreach ($this->cartProducts as $cartProduct) {
			$product = $this->product->getById($cartProduct['id']);

			if(is_null($product)) {
				continue;
			}
			
			$_SESSION['cart'][] = $cartProduct;
			$this->calculateTotal($product['price'], $cartProduct['quantity']);
		}

		header('Location: ?action=cart');
	}

	/**
	 * Adding items to the cart
	 */
	public function addToCart($id)
	{
		$product = $this->product->getById($id);

		if(is_null($product)) {
			$this->view->getErrorView("Product was not found, sorry.");
		}

		$userCart = $this->cartProducts;

		$found = false;

		// If the item is already in the cart than increase its quantity
		foreach ($userCart as &$cartProduct) {
			if($cartProduct['id'] == $id) {
				$cartProduct['quantity'] += 1;
				$found = true;
				break;
			}
		}

		// If item was not found in the current session
		if($found === false) {
			$userCart[] = [
				'id' => $id,
				'quantity' => 1
			];
		}

		$_SESSION['cart'] = $userCart;

		$this->calculateTotal($product['price']);

		header('Location: ?action=main');
	}

	/**
	 * Tally the total amount of the item prices
	 * Multiplying if needed
	 */
	private function calculateTotal($price, $quantity = 1)
	{
		$price *= $quantity;
		$total = $_SESSION['cartTotal'] ? $_SESSION['cartTotal'] + $price : $price;
		$_SESSION['cartTotal'] = $total;
	}
}