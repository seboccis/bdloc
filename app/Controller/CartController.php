<?php

namespace Controller;

use \W\Controller\Controller;
use \Manager\CartManager;
use \Manager\BookManager;

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
		// compter le nombre d'exemplaire présent dans le cart
			$countBooks = $cartManager->countBooksInCart($cartId);
			if ($countBooks > 10) {
				$cartError = "Vous avez atteint la taille maximale de votre panier";
			}
			


		$cartManager->createRelation($cartId, $bookId);
		$this->redirectToRoute('catalog');

	}

	public function showCart()
	{
		$cartManager = new CartManager();
		$bookManager = new BookManager();

		$books = [];
		$cartEmpty = "";
		$countBooks = "";

		// Récupération du cart_id de l'utilisateur avec la méthode findCart()
		$cartId = $cartManager->findCart($_SESSION['user']['id']);

		// Si le panier est vide, afficher un message
		if (empty($cartId)) {
			$cartEmpty = "Votre panier est vide";
			$data = [
				'books' => $books,
				'cartEmpty' => $cartEmpty,
			];
			$this->show('cart/show_cart', $data);
		}

		// Sinon, récupérer les identifiants des books

		$booksIds = $cartManager->findAllBooksIdsInCart($cartId);
		if (!empty($booksIds)) {
			$books = $bookManager->showBooks($booksIds);

			// Compter le nombre d'exemplaires dans le cart
			$countBooks = $cartManager->countBooksInCart($cartId);

		}
		
		$cartEmpty = "Votre panier est vide";

		// debug($books);
		// die();
		$data = [
			'books' => $books,
			'cartEmpty' => $cartEmpty,	
			'countBooks' => $countBooks,
		];
		
		$this->show('cart/show_cart', $data);

	}

	public function removeBookFromCart($bookId)
	{
		$cartManager = new CartManager();
		
		$cartManager->removeBook($bookId);

		$this->redirectToRoute('show_cart');
	}

}