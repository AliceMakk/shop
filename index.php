<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_STRICT);

/** 
 * Starting session
 * Registering available classes
 */
require_once 'loader.php';

$route = $_GET['action'] ?? 'main';

switch($route)
{ 
	// User cart
	case "cart" :
		$cartController = new Controller\CartController();

		$id = $_GET['id'] ?? null;

		if(!is_null($id)) {
			$cartController->addToCart($id);
		} else {
			$cartController->showCart();
		}

		break;

	// Deleting items from user cart
	case "clear_cart" :
		$cartController = new Controller\CartController();

		$id = $_GET['id'] ?? null;

		if(!is_null($id)) {
			$cartController->deleteFromCart($id);
		} 

		break;

	// Showing main page
	case "main" :
		$mainController = new Controller\MainController();
		$mainController->listProducts();

		break;

	default : 
		$mainController = new Controller\MainController();
		$mainController->showErrorPage('The page you are looking for is not found');
	break;
}