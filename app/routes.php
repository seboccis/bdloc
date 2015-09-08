<?php
	
	$w_routes = array(
		// Page d'inscription
		['GET|POST', '/securite/inscription/', 'User#register', 'register'],
		// Page de login
		['GET|POST', '/securite/login/', 'User#login', 'login'],
		// Page de logout
		['GET', '/securite/logout/', 'User#logout', 'logout'],


		// Page d'accueil
		['GET', '/', 'Default#home', 'home'],
		// Page de catalogue
		['GET|POST', '/catalogue/', 'Book#catalog', 'catalog'],
		// Page du panier
		['GET|POST', '/panier/', 'Cart#cart', 'cart'],


		// Page du compte
		['GET', '/compte/', 'User#account', 'account'],
		// Page de modification du profil
		['GET|POST', '/compte/modifications/Utilisateur/', 'User#editProfile', 'edit_profile'],
		// Page de modification du mot de passe
		['GET|POST', '/compte/modifications/Password/', 'User#editPassword', 'edit_password'],
		

		['GET|POST', '/forgot_password/', 'User#forgotPassword', 'forgot_password'],

		['GET|POST', '/change_password/', 'User#changePassword', 'change_password'],



		// Requête AJAX pour afficher le nombre de BD dans le panier
		['GET|POST', '/ajax/nombre_bd_panier/', 'CartBook#ajaxMainCountBooksInCart', 'ajax_main_countBooksInCart'],
		// Requête AJAX pour afficher les BD
		['GET|POST', '/ajax/catalogue/books/', 'Book#ajaxCatalogGetBooks', 'ajax_catalog_getBooks'],
		// Requête AJAX pour afficher le detail de la BD
		['GET|POST', '/ajax/catalogue/detail/', 'Book#ajaxCatalogDetail', 'ajax_catalog_detail'],
		// Requête AJAX pour afficher les résultats de l'autocomplétion sur le mot-clé
		['GET|POST', '/ajax/catalogue/keyword/', 'Keyword#ajaxCatalogKeyword', 'ajax_catalog_keyword'],
		// Requête AJAX pour ajouter un article au panier

		['GET|POST', '/panier/ajouter/', 'Cart#ajaxCatalogAddToCart', 'ajax_catalog_add_to_cart'],


		// Requête AJAX pour retirer un article du panier
		['GET|POST', '/panier/retirer/[:bookId]/', 'Cart#ajaxCartRemoveBookFromCart', 'ajax_cart_remove_book_from_cart'],	



		// Soumettre la commande
		['GET|POST', '/Commande/', 'Cart#submitOrder', 'submit_order'],
		// Page de confirmation de la commande
		['GET|POST', '/Commande/Confirmation/', 'Cart#confirmOrder', 'confirm_order'],
		// Page de validation de la commande
		['GET', '/Commande/Confirmation/[:cartIdToOrder]/[:deliveryPlace]/', 'Cart#saveOrder', 'save_order'],
		// Page d'affichage de l'historique des commandes
		['GET', '/Commande/Historique/', 'Cart#orderHistory', 'order_history'],





		// Vider le panier
		['GET|POST', '/panier/vider/', 'Cart#removeAllFromCart', 'remove_cart'],	

		// Requête AJAX pour aller chercher les coordonnées pertinentes
		['GET', '/commande/plan/', 'GoogleAPI#ajaxDeliveryPlaceGetMap', 'ajax_deliveryPlace_getMap'],
		// Requête AJAX pour aller chercher le point-relais choisi
		['GET', '/commande/point_relais_choisi/', 'DeliveryPlace#ajaxDeliveryPlaceGetDeliveryPlace', 'ajax_deliveryPlace_getDeliveryPlace'],


		// Gestion des paniers périmés
		['GET', '/gestion_paniers/', 'Cart#deleteExpiredCarts', 'delete_expiredCarts'],
	);