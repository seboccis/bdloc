<?php

namespace Controller;

use \Manager\CartManager;
use \Manager\CartBookManager;
use \Manager\BookManager;

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
		$userId = $user['id'];

		$cartManager = new CartManager();
		$cartId = $cartManager->findCart($userId);

		if(empty($cartId)){die('0');}

		$remainingTime = $cartManager->findCartDelay($cartId);

		if($remainingTime < 0){
			// Augmenter la quantité disponible des livres ...

			// ... en récupérant les livres du panier ...
			$booksIds = $cartManager->findAllBooksIdsInCart($cartId);
			
			// ... pour ajouter un à la quantité disponible
			$bookManager = new BookManager();
			foreach ($booksIds as $bookId) {
				$bookManager->increaseQuantityAvailable($bookId['book_id']);
			}

			// Une fois les lignes du cart_to_books détruites, détruire le cart en cours
			if ($cartManager->removeBooks($cartId)) {
				if ($cartManager->removeCart($cartId)) {
				}
			}

			die('0');
		}

		$cartBookManager = new CartBookManager();
		$number = $cartBookManager->countBooksInCart($cartId);

		die($number);
	}

}