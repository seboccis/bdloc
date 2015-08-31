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



		// Requête AJAX pour afficher le nombre de BD dans le panier
		['GET|POST', '/ajax/nombre_bd_panier/', 'CartBook#ajaxMainCountBooksInCart', 'ajax_main_countBooksInCart'],
		// Requête AJAX pour afficher les BD
		['GET|POST', '/ajax/catalogue/books/', 'Book#ajaxCatalogGetBooks', 'ajax_catalog_getBooks'],
		// Requête AJAX pour afficher le detail de la BD
		['GET|POST', '/ajax/catalogue/detail/', 'Book#ajaxCatalogDetail', 'ajax_catalog_detail'],
		// Requête AJAX pour afficher les résultats de l'autocomplétion sur le mot-clé
		['GET|POST', '/ajax/catalogue/keyword/', 'Keyword#ajaxCatalogKeyword', 'ajax_catalog_keyword'],
		// Requête AJAX pour ajouter un article au panier
		['GET', '/panier/ajouter/', 'Cart#ajaxCatalogAddToCart', 'ajax_catalog_add_to_cart'],

		// Requête AJAX pour retirer un article du panier
		['GET|POST', '/panier/retirer/[:bookId]/', 'Cart#ajaxCartRemoveBookFromCart', 'ajax_cart_remove_book_from_cart'],	

		// Vider le panier
		['GET|POST', '/panier/vider/', 'Cart#removeAllFromCart', 'remove_cart'],	

	);