<?php

namespace Controller;

use \Manager\CartManager;
use \Manager\CartBookManager;

class CartBookController extends DefaultController
{

	/**
	 * Requête AJAX pour trouver le nombre de BD
	 * dans le panier actuel de l'utilisateur 
	 */
	public function ajaxMainCountBooksInCart()
	{
		$this->lock();

		$user = $this->getUser();

		$cartManager = new CartManager();
		$cartId = $cartManager->findCart($user['id']);

		if(empty($cartId)){die('0');}

		$cartBookManager = new CartBookManager();
		$number = $cartBookManager->countBooksInCart($cartId);

		die($number);
	}

}