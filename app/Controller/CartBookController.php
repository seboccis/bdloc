<?php

namespace Controller;

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

		$user= $this->getUser();

		$cartBookManager = new CartBookManager();
		$number = $cartBookManager->countBooksInCart($user['id']);

		// pour l'instant
		echo $number;
	}

}