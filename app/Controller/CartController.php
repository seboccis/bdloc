<?php

namespace Controller;

use \Manager\CartManager;
use \Manager\BookManager;
use \Manager\DeliveryPlaceManager;

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
	public function ajaxCartRemoveBookFromCart($bookId)
	{
		$this->lock();
		
		$cartManager = new CartManager();
		$bookManager = new BookManager();
		
		$cartManager->removeBook($bookId);
		// Réduire la quantité de livres disponibles dans la table books

		$bookManager->increaseQuantityAvailable($bookId);

		$this->redirectToRoute('cart');
	}

	public function cart()
	{
		$this->lock();

		$cartManager = new CartManager();
		$bookManager = new BookManager();

		$books = [];
		$cartEmpty = "";
		$orderError = "";

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
		}
		
		$cartEmpty = "Votre panier est vide";

	
		$data = [
			'books' => $books,
			'cartEmpty' => $cartEmpty,
			'orderError' => $orderError,	
		];
		
		$this->show('cart/cart', $data);

	}

	public function removeAllFromCart()
	{
		$this->lock();
		$cartEmpty = "";

		// récupérer l'id du cart en cours
		$cartManager = new CartManager();
		$bookManager = new BookManager();
		$cartId = $cartManager->findCart($_SESSION['user']['id']);

		if(!empty($cartId)){
			// Augmenter la quantité disponible des livres ...

			// ... en récupérant les livres du panier ...
			$booksIds = $cartManager->findAllBooksIdsInCart($cartId);
			
			// ... pour ajouter un à la quantité disponible
			foreach ($booksIds as $bookId) {
				$bookManager->increaseQuantityAvailable($bookId['book_id']);
			}

			// Une fois les lignes du cart_to_books détruites, détruire le cart en cours
			if ($cartManager->removeBooks($cartId)) {
				if ($cartManager->removeCart($cartId)) {
					$cartEmpty = "Votre panier est vide";
				}
			}

		}

		$data = [
			'cartEmpty' => $cartEmpty,	
		];

		$this->show('cart/cart', $data);
	}

	public function submitOrder()
	{
		$this->lock();
		$cartEmpty = "";
		$orderError = "";
		$orderSuccess = "";


		
		$cartManager = new CartManager();
		$bookManager = new BookManager();
		$deliveryPlaceManager = new deliveryPlaceManager();
			
		// Vérifier le nombre de livres déjà empruntés
		// Récupérer l'id des carts où le statut est égal à 1 (livres en cours)

		$status = 1;
		$cartsAlreadyOrdered = $cartManager->findOrder($_SESSION['user']['id'], $status);
		$cartIdToOrder = $cartManager->findCart($_SESSION['user']['id']);

		$cartsIdsAlreadyOrdered = [];
		foreach ($cartsAlreadyOrdered as $cartAlreadyOrdered) {
			$cartsIdsAlreadyOrdered[] = $cartAlreadyOrdered['id'];
		}
		
		
		
		// Compter le nombre de livres dans le cart_to_books avec les ids récupérés
		$countBooksAlreadyOrdered = 0;
		if (!empty($cartsIdsAlreadyOrdered)) {
			$countBooksAlreadyOrdered = $cartManager->countBooksInCarts($cartsIdsAlreadyOrdered);
		}

		// Compter le nombre de livre à emprunter
		$countBooksToOrder = $cartManager->countBooksInCart($cartIdToOrder);
		
		$countOrderedAndToOrder = $countBooksAlreadyOrdered + $countBooksToOrder;

		// Si le nombre de livres à louer ajouté au nombre de livres déjà loués est supérieur à 10, on affiche un message d'erreur
		if ($countOrderedAndToOrder > 10) {
			$orderError = "Vous avez dépassé le nombre de bd autorisées en location (10), merci de réduire la taille de votre panier !";
			
			$data = [
				'orderSuccess' => $orderSuccess,
				'orderError' => $orderError,
				'cartEmpty' => $cartEmpty,
			];
			$this->show('cart/submit_order', $data);
		}

		// On vérifie que les coordonnées de l'utilisateur existent
		$user = $this->getUser();

		$lat = $user['lat'];
		$lng = $user['lng'];

		if(!empty($lat) && !empty($lng)){
			$data = array(
							'orderError' => $orderError,
							'orderSuccess' => $orderSuccess,
							'cartIdToOrder' => $cartIdToOrder,
						);
			$this->show('googleAPI/deliveryPlace', $data);
///////////// ce devrait être une utimlisation de redirectToRoute, mais je n'arrive pas à récupérer le paramètre
///////////// DEMANDER à GUILLAUME !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!			
		}	
		
		// On affiche la liste de tous les points de livraisons existants

		$deliveryPlaces = $deliveryPlaceManager->findAll();

		// Récupérer les codes postaux
		
		$codesAndCities = [];
		foreach ($deliveryPlaces as $deliveryPlace) {
			$codesAndCities[] = substr($deliveryPlace['address'], -11);
		}

		for ($i=0; $i <  count($deliveryPlaces); $i++) { 
			$deliveryPlaces[$i]['code'] =  substr($codesAndCities[$i], 0,5);
		}

		// debug($deliveryPlaces);
		
		$orderSuccess = "Commande prête à être envoyée !";
		
		$data = [
			'orderError' => $orderError,
			'cartEmpty' => $cartEmpty,
			'orderSuccess' => $orderSuccess,
			'deliveryPlaces' => $deliveryPlaces,
			'cartIdToOrder' => $cartIdToOrder,
		];

				
		$this->show('cart/submit_order', $data);
			
	}

	public function confirmOrder()
	{
		$this->lock();
		$cartManager = new CartManager();
		$bookManager = new BookManager();
		$deliveryPlaceManager = new DeliveryPlaceManager();

		// Récupérer le point de livraison sélectionné 
		if(!empty($_POST)) {
			
			$deliveryPlaceId = trim(strip_tags($_POST['deliveryplace']));
			$cartIdToOrder = trim(strip_tags($_POST['cartIdToOrder']));

			// Récupération du nom et de l'adresse du point de livraison
				$deliveryPlace = $deliveryPlaceManager->find($deliveryPlaceId);

			// Récupération de tous les livres du cart
				$booksIds = $cartManager->findAllBooksIdsInCart($cartIdToOrder);

			// 	if (!empty($booksIds)) {
				$books = $bookManager->showBooks($booksIds);
			// 	}

			$data = [
				'deliveryPlace' => $deliveryPlace,
				'books' => $books,
				'cartIdToOrder' => $cartIdToOrder,
			];

		}
		
		$this->show('cart/confirm_order', $data);
	}

	public function saveOrder($cartIdToOrder, $deliveryPlaceId)
	{
		// Modifier le statut du cart et insérer le point de livraison sélectionné 
		$cartManager = new CartManager();

		if ($cartManager->convertCartToOrder($cartIdToOrder, $deliveryPlaceId)) {
			$this->redirectToRoute('catalog');
					
		}


	}


}




