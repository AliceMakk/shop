<?php
namespace Model;

/**
 * The class is responsible for retreiving products
 */
class Product {

	private $products = [];

	public function __construct()
	{
		// ######## please do not alter the following code ########
		$products = [
	    	[ "name" => "Sledgehammer", "price" => 125.75 ],
	    	[ "name" => "Axe", "price" => 190.50 ],
			[ "name" => "Bandsaw", "price" => 562.131 ],
			[ "name" => "Chisel", "price" => 12.9 ],
			[ "name" => "Hacksaw",	"price" => 18.45 ],
	    ];
		// ########################################################

		$this->products = $products;
	}

	/**
	 * Getting all available products
	 */
	function getAllProducts() : array
	{
		return $this->products;
	}

	/**
	 * Searching a particular product in the available list of products
	 */
	function getById($id)
	{
		return array_key_exists($id, $this->products) ? $this->products[$id] : null;
	}
}
