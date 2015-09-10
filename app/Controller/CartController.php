<?php

namespace Controller;

use \Manager\UserManager;
use \Manager\CartManager;
use \Manager\BookManager;
use \Manager\CartBookManager;
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
			// créer un cart
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

		// Modifier la date de modification du cart
		$cartManager->editModifiedDateOfCart($cartId);

		die($cartError);
	}
	
	/**
	 * Page de retrait d'une bd du panier
	 */
	public function ajaxCartRemoveBookFromCart($bookId, $cartId)
	{
		$this->lock();
		
		$cartManager = new CartManager();
		$bookManager = new BookManager();
		
		$cartManager->removeBook($bookId, $cartId);
		// Réduire la quantité de livres disponibles dans la table books

		$bookManager->increaseQuantityAvailable($bookId);

		// Modifier la date de modification du cart
		$cartManager->editModifiedDateOfCart($cartId);

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
			'cartId' => $cartId,	
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
		$showMap = 0;


		
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
				'orderSuccess' 	=> $orderSuccess,
				'orderError' 	=> $orderError,
				'cartEmpty' 	=> $cartEmpty,
				'showMap'		=> $showMap,
			];
			$this->show('cart/submit_order', $data);
		}

		// On vérifie que les coordonnées de l'utilisateur existent
		$user = $this->getUser();

		$lat = $user['lat'];
		$lng = $user['lng'];

		if(!empty($lat) && !empty($lng)){
			$showMap = 1;
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
			'showMap'		=> $showMap,
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
		$bookManager = new BookManager();
		$deliveryPlaceManager = new DeliveryPlaceManager();

		if ($cartManager->convertCartToOrder($cartIdToOrder, $deliveryPlaceId)) {
			// envoyer un email de confirmation


			// Récupération des informations du cart, des books et de l'user
			// user
			$user = $this->getUser();
			
			// books

			$booksIds = $cartManager->findAllBooksIdsInCart($cartIdToOrder);
			$books = $bookManager->showBooks($booksIds);

			// Récupérer le nom et l'adresse du point relai 
			$deliveryplace = $deliveryPlaceManager->showDeliveryplace($deliveryPlaceId);



			$recap = '<p>Bonjour '.$user['username'].'</p>';

			$recap .= '<p>Nous avons pris connaissance de la commande suivante : <br>
							<table>
									<thead>
										<tr>
											<th>
												Titre :
											</th>
										</tr>
									</thead>
									<tbody>';
			foreach ($books as $book) {
				$recap .= '<tr>
								<td>
									'. $book['title'] .'
								</td>
							</tr>';
			}

			$recap .='		</tbody>
							</table>';

			$recap .= '<p>Vous recevrez prochainement un email vous confirmant l\'envoi de la commande au point relais suivant : '.$deliveryplace['name'] .': ' . $deliveryplace['address'] . '</p>';
			
			$recap .= '<p>Merci d\'utiliser notre service, <br> Bdialement <br> L\'équipe de BDloc</p>';
			

			
			$errorEmail = "";

			$mail = new \PHPMailer;
			$mail->isSMTP();
			$mail->setLanguage('fr');
			$mail->CharSet = 'UTF-8';
			$mail->SMTPDebug = 2;	//0 pour désactiver les infos de débug
			$mail->Debugoutput = 'html';
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth = true;
			$mail->Username = "tony.wf3.nanterre@gmail.com";
			$mail->Password = "nanterre1";
			$mail->setFrom('jeandupont@example.com', 'Service de Messagerie BDloc');
			$mail->addAddress($user['email']);
			$mail->isHTML(true); 	
			$mail->Subject = 'Envoyé par PHP !';					
			
			$mail->Body = $recap;

					if (!$mail->send()) {
							echo "Mailer Error: " . $mail->ErrorInfo;
						} else {
							echo "Message sent!";
						}


				$this->redirectToRoute('catalog');
						
			}


	}

	public function orderHistory()
	{
		$this->lock();

		$cartManager = new CartManager();
		$bookManager = new BookManager();
		$cartToBooks = [];
		$cartToBooksInRent= [];
		$orderEmpty = "";
		$orderInRentEmpty= "";

		// Récupérer tous les Ids des carts de l'user dont le statut est "1"
		$status = 1;
		$cartsInRent = $cartManager->findOrder($_SESSION['user']['id'], $status);

		if (!empty($cartsInRent)) {
			$cartsIdsInRent = [];
			foreach ($cartsInRent as $cartInRent) {
				$cartsIdsInRent[] = $cartInRent['id'];
			}

			// Récupérer les infos des Carts

			$carts = $cartManager->showCarts($cartsIdsInRent);

			// Associer les carts et les livres correspondants
			foreach ($carts as $cart) {
				$cartInRentBeginDate = $cart['begin_date'];
				// $cartEndDate = $cart['end_date'];
				$cartId = $cart['id'];

				$bookIds = $cartManager->findAllBooksIdsInCart($cartId);
				$booksInRent = $bookManager->showBooks($bookIds);

				$cartToBooksInRent[] = [
					'orderInRentEmpty' => $orderInRentEmpty,
					'cartInRentBeginDate' => $cartInRentBeginDate,
					'booksInRent' => $booksInRent,
				];
			}
		}
		else {
			$orderInRentEmpty = "Vous n'avez pas de commande en cours.";
		}

	
		// Récupérer tous les Ids des carts de l'user dont le statut est "2"

		$status = 2;
		$cartsAlreadyReturned = $cartManager->findOrder($_SESSION['user']['id'], $status);


		if (!empty($cartsAlreadyReturned)) {
			
			$cartsIdsAlreadyReturned = [];
			foreach ($cartsAlreadyReturned as $cartAlreadyReturned) {
				$cartsIdsAlreadyReturned[] = $cartAlreadyReturned['id'];
			}
			// Récupérer les infos des Carts

			$carts = $cartManager->showCarts($cartsIdsAlreadyReturned);
			// debug($carts);
			

			// Associer les carts et les livres correspondants
			foreach ($carts as $cart) {
				$cartBeginDate = $cart['begin_date'];
				$cartEndDate = $cart['end_date'];
				$cartId = $cart['id'];

				$bookIds = $cartManager->findAllBooksIdsInCart($cartId);
				$books = $bookManager->showBooks($bookIds);

				$cartToBooks[] = [
					'orderEmpty' => $orderEmpty,
					'cartBeginDate' => $cartBeginDate,
					'cartEndDate' => $cartEndDate,
					'books' => $books,
				];
			}
			

		}

		else{
			$orderEmpty = "Vous n'avez pas encore effectué de commandes";
		}
		
		$data = [
			'cartToBooks' => $cartToBooks,
			'cartToBooksInRent' => $cartToBooksInRent,
			'orderEmpty' => $orderEmpty,
			'orderInRentEmpty' => $orderInRentEmpty,
		];

		$this->show('user/order_history', $data);

	}

	/**
	 * Programme de gestion des paniers périmés
	**/
	public function deleteExpiredCarts()
	{

		$cartManager = new CartManager();
		$deepIdsExpiredCarts = $cartManager->getIdsExpiredCarts();

		if(!empty($deepIdsExpiredCarts)){

			$idsExpiredCarts = [];

			foreach($deepIdsExpiredCarts as $arrayId){
				$idsExpiredCarts[] = $arrayId['id'];
			}

			$bookManager = new BookManager();

			foreach($idsExpiredCarts as $idExpiredCart){
				$bookManager->increaseQuantityAvailableByIdCart($idExpiredCart);
			}


			$cartBookManager = new CartBookManager();
			$cartBookManager->deleteSeveral('cart_id', $idsExpiredCarts);

			$cartManager->deleteSeveral('id', $idsExpiredCarts);
			
		}

	}

	public function showAllOrders()
	{
		$cartManager = new CartManager();
		

		$allOrdersAndUsers = $cartManager->showAllCarts();
		
		$data = [
			'allOrdersAndUsers' => $allOrdersAndUsers,
		];

		$this->show('admin/show_all_orders', $data);


	}

	public function showOrder($cartId, $status, $username)
	{
		$cartManager = new CartManager();
		$bookManager = new BookManager();
		$deliveryPlaceManager = new DeliveryPlaceManager();
		$deliveryplace = "";


		if ($status == 1) {
			// Récupérer l'id du point relai
			$deliveryPlaceId = $cartManager->getDeliveryplaceId($cartId);
			
			// Récupérer le nom et l'adresse du point relai 
			$deliveryplace = $deliveryPlaceManager->showDeliveryplace($deliveryPlaceId);
		}

		$booksIds = $cartManager->findAllBooksIdsInCart($cartId);

		$books = $bookManager->showBooks($booksIds);

		

		$data = [
			'books' => $books,
			'deliveryplace' => $deliveryplace,
			'username' => $username,
			'cartId' => $cartId,

		];



		$this->show('admin/show_order', $data);
	}

	public function sendOrderConfirmEmail($cartId)
	{
		$cartManager = new CartManager();
		$bookManager = new BookManager();
		$deliveryPlaceManager = new DeliveryPlaceManager();
		$userManager = new UserManager();
		// Récupérer les infos de la commande et de l'utilisateur avec le cartId

		// Récupérer l'id de l'utilisateur

		$userId = $cartManager->getUserIdByCart($cartId);

		$user = $userManager->find($userId);

		// Récupération des livres
		$booksIds = $cartManager->findAllBooksIdsInCart($cartId);
		$books = $bookManager->showBooks($booksIds);

		
		// Récupérer l'id du point relai
		$deliveryPlaceId = $cartManager->getDeliveryplaceId($cartId);
			
		// Récupérer le nom et l'adresse du point relai 
		$deliveryplace = $deliveryPlaceManager->showDeliveryplace($deliveryPlaceId);

		$recap = '<p>Bonjour '.$user['username'].'</p>';

		$recap .= '<p>La commande suivante vient de vous être expédiée.</p><br><p>Voici le détail de votre commande :</p><br>
						<table>
								<thead>
									<tr>
										<th>
											Titre :
										</th>
									</tr>
								</thead>
								<tbody>';
		foreach ($books as $book) {
			$recap .= '<tr>
							<td>
								'. $book['title'] .'
							</td>
						</tr>';
		}

		$recap .='		</tbody>
						</table>';

		$recap .= '<p>Votre commande sera livrée au point de retrait suivant : '.$deliveryplace['name'] .': ' . $deliveryplace['address'] . '</p>';
		
		$recap .= '<p>Elle sera disponible dans 48h.</p>';

		$recap .= '<p>Merci d\'utiliser notre service, <br> Bdialement <br> L\'équipe de BDloc</p>';
		

		
		$errorEmail = "";

		$mail = new \PHPMailer;
		$mail->isSMTP();
		$mail->setLanguage('fr');
		$mail->CharSet = 'UTF-8';
		$mail->SMTPDebug = 2;	//0 pour désactiver les infos de débug
		$mail->Debugoutput = 'html';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = "tony.wf3.nanterre@gmail.com";
		$mail->Password = "nanterre1";
		$mail->setFrom('jeandupont@example.com', 'Service de Messagerie BDloc');
		$mail->addAddress($user['email']);
		$mail->isHTML(true); 	
		$mail->Subject = 'Envoyé par PHP !';					
		
		$mail->Body = $recap;

				if (!$mail->send()) {
						echo "Mailer Error: " . $mail->ErrorInfo;
					} else {
						echo "Message sent!";

						// Changement du statut du cart sélectionné
						$cartManager->confirmOrder($cartId);
						$this->redirectToRoute('home_admin');


					}
		
	}	

	public function returnOrder()
	{
		$cartManager = new CartManager();
		$bookManager = new BookManager();
		$userManager = new UserManager();

		$cartId = "";
		$books = "";

		if (!empty($_POST)) {
			$cartId = trim(strip_tags($_POST['cartId']));

			// Retrouver la commande correspondante
			$booksIds = $cartManager->findAllBooksIdsInCart($cartId);
			$books = $bookManager->showBooks($booksIds);

			// Récupérer l'id de l'utilisateur

			$userId = $cartManager->getUserIdByCart($cartId);
			$user = $userManager->find($userId);



			$data = [
			'books'=> $books,
			'user' => $user,
			];


		$this->show('admin/confirm_order_return', $data);
		
		}
		
		else {
			$this->show('admin/confirm_order_return');
		}

	}

	public function validateReturnOrder()
	{
		if (!empty($_POST)) {
			// die('test');
			debug($_POST);
			$this->show('admin/order_return');
		}
	}
		


		

}




