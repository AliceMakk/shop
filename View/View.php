<?php
namespace View;

/**
 * The class is responsible for templates
 */
class View {

	/**
	 * Showing product list view
	 */
	function getMainView(array $products = [], $cartTotal = 0)
	{
		include __DIR__ . '/Main.php';
	}

	/**
	 * Showing cart view
	 */
	function getCartView(array $cartData = [])
	{
		include __DIR__ . '/Cart.php';
	}

	/**
	 * Showing error view
	 */
	function getErrorView(string $error = "")
	{
		include __DIR__ . '/404.php';
	}
}