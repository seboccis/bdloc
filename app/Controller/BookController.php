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


		////// Application des critères de filtres
		////// Le but est de définir un tableau $booksIdsToFindAccordingToFilters contenant les ids des BDs
		////// correspondantes aux filtres ordonnées par leur pertinence.
		////// Si aucun filtre (par défaut), $booksIdsToFind sera un tableau vide.
		////// Le filtre de disponibilité sera appliqué plus tard.

		//// $filterExist est une variable booléenne
		//// par défaut égale à false
		$filterExist = false;
		$filterGenreExist = false;
		$filterKeywordExist = false;

		//// Application du filtre de catégories
		//// Recherche de $booksIdsToFindAccordingToGenres
		//// par défaut (si pas de critère de catégories) $booksIdsToFindAccordingToGenres est un tableau vide

		$booksIdsToFindAccordingToGenres = [];

		// $nbGenres est le nombre de catégories définies comme critères de filtre
		$nbGenres = count($selectedGenresId);

		// si $nbGenres = 0, $booksIdsToFindAccordingToGenres n'est pas modifié
		if($nbGenres == 0){}

		// sinon application de la méthode BookGenreManager->findBooksIdsByGenres
		// cette méthode renvoie un tableau d'ids de BD appartenant à au moins une catégorie recherchée  
		else{
			$filterGenreExist = true;

			$bookGenreManager = new BookGenreManager();
			$booksIdsToFindAccordingToGenres = $bookGenreManager->findBooksIdsByGenres($selectedGenresId); 	
		}

		// si plus d'une catégorie recherchée le tableau $booksIdsToFind peut contenir plusieurs fois la même id,
		// il convient de le trier et de l'ordonner en fonction du nombre de catégories auxquelles une BD correspond
		if($nbGenres > 1){
			$booksIdsToFindAccordingToGenres = $this->sortBooksIdsByOccurence($booksIdsToFindAccordingToGenres); 
		}

		//// Application du filtre de mot-clé
		//// Recherche de $booksIdsToFindAccordingToKeyword
		//// par défaut (si pas de mot-clé) $booksIdsToFindAccordingToKeyword est un tableau vide

		$booksIdsToFindAccordingToKeyword = [];

		if(!empty($keyword)){
			$filterKeywordExist = true;

			$keywordManager = new KeywordManager();
			$keywordId = $keywordManager->findIdByKeyword($keyword);

			if(!empty($keywordId)){

				$bookKeywordManager = new BookKeywordManager();
				$booksIdsToFindAccordingToKeyword = $bookKeywordManager->findBooksIdByKeywordId($keywordId);

			}
		}

		//// Synthèse de deux recherches filtrées précédentes

		$filterExist = $filterGenreExist || $filterKeywordExist;

		if($filterExist){
			if(!$filterGenreExist){
				$booksIdsToFindAccordingToFilters = $booksIdsToFindAccordingToKeyword;
			}
			else if(!$filterKeywordExist){
				$booksIdsToFindAccordingToFilters = $booksIdsToFindAccordingToGenres;
			}
			else{
				$booksIdsToFindAccordingToFilters = $this->mergeBooksIds($booksIdsToFindAccordingToGenres, $booksIdsToFindAccordingToKeyword);
			}

		}


		////// Application des critères de tri et de pagination et de disponibilité
		////// Le but est de définir un tableau $books contenant les informations sur les BDs
		////// correspondantes aux filtres et au tri et à la pagination.

		// Instanciation d'un objet de la classe BookManager
		$bookManager = new BookManager();

		// $last est la dernière BD ramenée en fonction des critères
		// par défaut (si c'est possible), $last = $start + $number
		$last = $start + $number;

		//// si pas de filtres, recherche générale dans la table books
		//// en appliquant le tri, la pagination et la disponibilité
		if(!$filterExist){
			$books = $bookManager->findBooks($start, $number, $availability, $sort);
			$total = $bookManager->countBooks($availability);

			if($last > $total){
				$last = $total;
			}
		}

		//// sinon, utilisation de $booksIdsToFindAccordingToFilters
		else{
			// vérification que les ids dans $booksIdsToFindAccordingToFilters
			// correspondent à des BDs respectant le critère de disponibilité
			if($availability == 0){
				$booksIdsToFindAccordingToFiltersAndAvailability = $booksIdsToFindAccordingToFilters;
			}
			// si un critère de disponibilité
			else{
				// recherche des ids autorisées dans les ids recherchées par rapport à la disponibilité
				// le tableau de retour ne sera pas ordonné
				$arrayAuthorizedBooksIdsToFindAccordingToFiltersAndAvailability = $bookManager->findBooksdIdAvailable($booksIdsToFindAccordingToFilters);

				$authorizedBooksIdsToFindAccordingToFiltersAndAvailability = [];
				
				foreach($arrayAuthorizedBooksIdsToFindAccordingToFiltersAndAvailability as $rowId){
					$authorizedBooksIdsToFindAccordingToFiltersAndAvailability[] = $rowId['id'];
				}
			
				// on ne garde que les ids autorisées des ids à rechercher tout en concervant l'ordre
				$booksIdsToFindAccordingToFiltersAndAvailability = [];

				foreach($booksIdsToFindAccordingToFilters as $id){
					if(in_array($id, $authorizedBooksIdsToFindAccordingToFiltersAndAvailability)){
						$booksIdsToFindAccordingToFiltersAndAvailability[] = $id;
					}
				}
			}

			$books = [];
			$total = count($booksIdsToFindAccordingToFiltersAndAvailability);
			
			if($total >= $start + $number){
				for($index = $start; $index < $start + $number; $index++){
					$books[] = $bookManager->extendedFind($booksIdsToFindAccordingToFiltersAndAvailability[$index]);
				}				
			}
			else{
				for($index = $start; $index < $total; $index++){
					$books[] = $bookManager->extendedFind($booksIdsToFindAccordingToFiltersAndAvailability[$index]);
				}
				$last = $total;
			}

		}


		////// Définition des variables à envoyer sur la page ajax_catalog_showBooks.php

		// $first est le numéro par rapport à cette recherche de la première BD ramenée
		$first = $start + 1;
		if($total == 0){
			$first = 0;
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