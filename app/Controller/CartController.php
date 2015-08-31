<?php

namespace Controller;

use \Manager\CartManager;
use \Manager\BookManager;

class CartController extends DefaultController
{

	/**
	 * Page d'ajout au panier
	 */
	public function ajaxCatalogAddToCart()
	{
		$this->lock();
		
		$cartManager = new CartManager();
		$bookManager = new BookManager();
		$cartError = "";
		
		// vérifier si un panier existe déjà 
		$cartId = $cartManager->findCart($_SESSION['user']['id']);
		
		if (empty($cartId)) {
			// créer une relation cart / book
			$cartId = $cartManager->createCart($_SESSION['user']['id']);
		}
		
		// compter le nombre d'exemplaire présent dans le cart
		$countBooks = $cartManager->countBooksInCart($cartId);
		if ($countBooks >= 10) {
			$cartError = "Vous avez atteint la taille maximale de votre panier";
		}
			
		// vérifier si le livre est déjà dans le cart
		if ($cartManager->findBook($_GET['id'],$cartId)) {
			$cartError = "Le livre est déjà dans votre panier !";
		}

		if (empty($cartError)) {
			$cartManager->createRelation($cartId, $_GET['id']);

		// Réduire la quantité de livres disponibles dans la table books
			$bookManager->decreaseQuantityAvailable($_GET['id']);
		}

		die($cartError);
	}
	
	/**
	 * Page de retrait d'une bd du panier
	 */
	public function removeBookFromCart($bookId)
	{
		$this->lock();
		
		$cartManager = new CartManager();
		$bookManager = new BookManager();
		
		$cartManager->removeBook($bookId);
		// Réduire la quantité de livres disponibles dans la table books

		$bookManager->increaseQuantityAvailable($bookId);

		$this->redirectToRoute('show_cart');
	}

	public function cart()
	{
		$this->lock();

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
			$this->show('cart/cart', $data);
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
		
		$this->show('cart/cart', $data);

	}


}