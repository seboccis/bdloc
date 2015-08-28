<?php

namespace Controller;

use \Manager\BookManager;
use \Manager\GenreManager;
use \Manager\BookGenreManager;
use \Manager\KeywordManager;
use \Manager\BookKeywordManager;
use \Manager\CartManager;

class BookController extends DefaultController
{

	/**
	 * Page de catalogue
	 */
	public function catalog()
	{
		$this->lock();
		
		$genreManager = new GenreManager();
		$genres= $genreManager->findAll();

		$data = array('genres' => $genres);

		$this->show('book/catalog', $data);
	}

	/**
	 * Requête AJAX pour trouver les BDs correspondant au filtres de
	 * recherches et avec les paramètres de tri et de pagination
	 */
	public function ajaxCatalogGetBooks()
	{
		$this->lock();

		////// Définition des variables de recherche

		//// Variables de filtres

		// $selectedGenresId est un tableau d'id de catégories
		// parmi lesquelles chercher, par défaut tableau vide
		$selectedGenresId = [];
		if(!empty($_POST['genres'])){
			$selectedGenresId = $_POST['genres'];
		}

		// $availability correspond au critère de disponibilité,
		// par défaut:	0 pas de paramètre défini ou
		// 				1 seulement les BDs disponibles
		$availability = 0;
		if(!empty($_POST['availability'])){
			$availability = $_POST['availability'];
		}

		// $keyword définit le mot-clé à chercher,
		// par défaut chaîne vide
		$keyword = '';
		if(!empty($_POST['keyword'])){
			$keyword = $_POST['keyword'];
		}
		
		//// Variable de tri

		// $tri définit le tri à appliquer,
		// par défaut chaîne vide
		$sort = '';
		if(!empty($_POST['sort'])){
			$sort = $_POST['sort'];
		}

		//// Variables de pagination

		// $start définit le nombre de BDs à ignorer,
		// par défaut 0
		$start = 0;
		if(!empty($_POST['start'])){
			$start = $_POST['start'];
		}

		// $number est le nombre de BD à chercher
		// (toujours défini car une option est définie par défaut sur la page catalog.php)
		$number = $_POST['number'];


		$bookManager = new BookManager();
		$books = $bookManager->findCatalogBooks($selectedGenresId, $availability, $keyword, $sort, $start, $number);

		$cartManager = new CartManager();
		
		// Récupère le panier de l'utilisateur
		$cartId = $cartManager->findCart($this->getUser()['id']);

		if(empty($cartId))
		// Récupère les id des livres qui sont déjà dans le panier
		$booksInCartIds = [];
		if(!empty($cartId)){
			$booksInCartIds = $cartManager->findAllBooksIdsInCart($cartId);
		}
		
		$bookInCartIds= [];
		foreach ($booksInCartIds as $array) {
			$bookInCartIds[] = $array['book_id'];
		}
		$transformedBooks = [];
		foreach($books as $book){
			$nb = $book['quantity_available'];

			unset($book['quantity_available']);

			$string_quantity_available = $nb . ' disponibles';
			if($nb == 0){
				$string_quantity_available = 'Plus d\'exemplaires disponibles';
			}
			else if($nb == 1){
				$string_quantity_available = 'Plus qu\'un exemplaire disponible !!';
			}

			$book['string_quantity_available'] = $string_quantity_available;

			// Vérifie si les livres affichés dans le catalogue sont dans le panier 
			$isBookInCart = 1;
			if (in_array($book['id'], $bookInCartIds)) {
				$isBookInCart = 0;
			}

			$book['isBookInCart'] = $isBookInCart;

			$transformedBooks[] = $book;
		}

		////// Définition des variables à envoyer sur la page ajax_catalog_showBooks.php

		$total = $bookManager->countCatalogBooks($selectedGenresId, $availability, $keyword, $sort, $start, $number);

		// $first est le numéro par rapport à cette recherche de la première BD ramenée
		$first = $start + 1;
		if($total == 0){
			$first = 0;
		}

		$last = $start + $number;
		if($last > $total){
			$last = $total;
		}

		$precStart = $start - $number;
		$nextStart = $start + $number;

		// Compilation de toutes les variables à envoyer dans $data
		$data = array(
			'precStart'	=> $precStart,
			'first' 	=> $first,
			'last'		=> $last,
			'total'		=> $total,
			'nextStart'	=> $nextStart,
			'books' 	=> $transformedBooks,
			);

		////// Afficher ajax_catalog_showBooks.php avec $data
		$this->show('book/ajax_catalog_showBooks', $data);

	}

	/**
	 * Requête AJAX pour trouver les informations sur la BD
	 * à faire apparaître dans la fenêtre modale
	 */
	public function ajaxCatalogDetail()
	{
		$this->lock();

		$bookManager = new BookManager;
		
		$book = $bookManager->extendedFind($_GET['id']);

		$data = array('book' => $book);

		$this->show('book/ajax_catalog_detail', $data);
	}

}