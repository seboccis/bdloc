<?php
	
	$w_routes = array(
		// Page d'accueil
		['GET', '/', 'Default#home', 'home'],
		// Page de catalogue
		['GET|POST', '/catalogue/', 'Book#catalog', 'catalog'],

		// Page d'inscription
		['GET|POST', '/securite/inscription/', 'User#register', 'register'],
		// Page de login
		['GET|POST', '/securite/login/', 'User#login', 'login'],
		// Page de logout
		['GET', '/securite/logout/', 'User#logout', 'logout'],


		// Requête AJAX pour afficher les BD
		['GET|POST', '/ajax/catalogue/books/', 'Book#ajaxCatalogGetBooks', 'ajax_catalog_getBooks'],
		// Requête AJAX pour afficher le detail de la BD
		['GET|POST', '/ajax/catalogue/detail/', 'Book#ajaxCatalogDetail', 'ajax_catalog_detail'],
		// Requête AJAX pour afficher les résultats de l'autocomplétion sur le mot-clé
		['GET|POST', '/ajax/catalogue/keyword/', 'Keyword#ajaxCatalogKeyword', 'ajax_catalog_keyword'],

		// Page du compte
		['GET', '/compte/', 'User#account', 'account'],
		// Page de modification du profil
		['GET|POST', '/compte/modifications/Utilisateur/', 'User#editProfile', 'edit_profile'],
		// Page de modification du mot de passe
		['GET|POST', '/compte/modifications/Password/', 'User#editPassword', 'edit_password'],

		// Page d'ajout au panier
		['GET', '/panier/Ajouter/[:bookId]/', 'Cart#addToCart', 'add_to_cart'],

		// Page d'affichage du panier
		['GET', '/panier/', 'Cart#showCart', 'show_cart'],

		// Retirer un article du panier
		['GET', '/panier/Retirer/[:bookId]/', 'Cart#removeBookFromCart', 'remove_book_from_cart'],


	);