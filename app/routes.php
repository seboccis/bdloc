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
		['GET|POST', '/ajax/catalogue/', 'Book#ajaxCatalog', 'ajax_catalog'],

	);