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

		// Requête AJAX pour afficher les BD
		['GET|POST', '/ajax/catalogue/books/', 'Book#ajaxCatalogGetBooks', 'ajax_catalog_getBooks'],

		//Requête AJAX pour afficher le detail de la BD
		['GET|POST', '/ajax/catalogue/detail/', 'Book#ajaxCatalogDetail', 'ajax_catalog_detail'],

	);