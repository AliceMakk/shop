<?php
namespace Controller;

use Model\Product;
use View\View;
use Helper\DataFormaterTrait;

/**
 * The class is responsible for:
 * 1. displaying available products
 */
class MainController {
	use DataFormaterTrait;

	public function __construct()
	{
		$this->view = new View();
	}

	/**
	 * Showing available products
	 */
	public function listProducts()
	{
		$allProducts = [];

		try {
			$product = new Product();
			$allProducts = $product->getAllProducts();
		} catch (\Exception $e) {
			$this->showErrorPage("There is a problem with getting list of available products, try again later please.");
		}

		$formatedProducts = $this->formatProducts($allProducts);
		$cartTotal = $this->formatAmount($_SESSION['cartTotal'] ?? 0);
		
		$this->view->getMainView($formatedProducts, $cartTotal);

	}

	/**
	 * Formatting the products by changing the price to prettier one and adding the link for adding to the cart
	 */
	private function formatProducts($allProducts)
	{
		$formatedProducts = [];

		if(!empty($allProducts)) {
			foreach ($allProducts as $index => $product) {
				$formatedProducts[] = [
					'name' => $product['name'],
					'price' => $this->formatAmount($product['price']),
					'addLink' => "?action=cart&id={$index}",
				];
			}
		}

		return $formatedProducts;
	}

	public function showErrorPage($error)
	{
		$this->view->getErrorView($error);
	}
}