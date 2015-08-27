<?php

namespace Controller;

use \Manager\BookManager;
use \Manager\GenreManager;
use \Manager\BookGenreManager;
use \Manager\KeywordManager;
use \Manager\BookKeywordManager;

class BookController extends DefaultController
{

	/**
	 * Page de catalogue
	 */
	public function catalog()
	{
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
			'books' 	=> $books,
			);

		////// Afficher ajax_catalog_showBooks.php avec $data
		$this->show('book/ajax_catalog_showBooks', $data);

	}

	public function ajaxCatalogDetail()
	{
		$bookManager = new BookManager;

		
		$book = $bookManager->extendedFind($_GET['id']);

		$data = array('book' => $book);


		$this->show('book/ajax_catalog_detail', $data);
	}

	private function sortBooksIdsByOccurence($unsortedBooksIds)
	{
		$ids = [];
		$occurence = [];

		foreach($unsortedBooksIds as $id){

			if(in_array($id, $ids)){
				$occurence[array_search($id, $ids)]++;
			}
			else{
				$ids[] = $id;
				$occurence[array_search($id, $ids)] = 1;
			}

		}

		array_multisort($occurence, SORT_DESC,$ids);

		return $ids;
	}

	private function mergeBooksIds($booksIdsToFindAccordingToGenres, $booksIdsToFindAccordingToKeyword)
	{
		$booksIdsToFindAccordingToFilters = [];

		foreach($booksIdsToFindAccordingToGenres as $bookId){
			if(in_array($bookId, $booksIdsToFindAccordingToKeyword)){
				$booksIdsToFindAccordingToFilters[] = $bookId;
			}
		}

		return $booksIdsToFindAccordingToFilters;
	}

}