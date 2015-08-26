<?php

namespace Controller;

use \W\Controller\Controller;
use \Manager\CartManager;

class CartController extends Controller
{

	/**
	 * Page d'ajout au panier
	 */
	public function addToCart($bookId)
	{
		$cartManager = new CartManager();

		// vérifier si un panier existe déjà 
		$cartId = $cartManager->findCart($_SESSION['user']['id']);
		
		if (empty($cartId)) {
			
			// créer une relation cart / book
			$cartId = $cartManager->createCart($_SESSION['user']['id']);
		}
		$cartManager->createRelation($cartId, $bookId);
		$this->redirectToRoute('catalog');

	}

}