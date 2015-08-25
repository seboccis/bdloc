<?php

namespace Controller;

use \Manager\BookManager;
use \Manager\GenreManager;
use \Manager\BookGenreManager;

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

	public function ajaxCatalogGetBooks()
	{
		$number = $_POST['number'];

		$selectedGenresId = [];
		$availability = 0;
		$start = 0;

		if(!empty($_POST['genres'])){
			$selectedGenresId = $_POST['genres'];
		}

		if(!empty($_POST['availability'])){
			$availability = $_POST['availability'];
		}

		if(!empty($_POST['start'])){
			$start = $_POST['start'];
		}

		$booksIdsToFind = [];

		if(count($selectedGenresId) == 1){
			$bookGenreManager = new BookGenreManager();
			$booksIdsToFind = $bookGenreManager->findBooksIdsByGenresAndAvailability($selectedGenresId, $availability); 
		}
		else if(count($selectedGenresId) > 1){
			$bookGenreManager = new BookGenreManager();
			$unsortedBooksIds = $bookGenreManager->findBooksIdsByGenresAndAvailability($selectedGenresId, $availability);
			$booksIdsToFind = $this->sortBooksIdsByOccurence($unsortedBooksIds); 
		}

		$bookManager = new BookManager();

		$last = $start + $number;

		if(count($booksIdsToFind) == 0){
			$books = $bookManager->findBooks($start, $number);
			$total = $bookManager->count();
		}
		else{
			$books = [];
			$total = count($booksIdsToFind);
			
			if($total >= $start + $number){
				for($index = $start; $index < $start + $number; $index++){
					$books[] = $bookManager->extendedFind($booksIdsToFind[$index]);
				}				
			}
			else{
				for($index = $start; $index < $total; $index++){
					$books[] = $bookManager->extendedFind($booksIdsToFind[$index]);
				}
				$last = $total;
			}

		}

		$first = $start + 1;

		$data = array(
			'first' => $first,
			'last'	=> $last,
			'total'	=> $total,
			'books' => $books,
			);


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

	public function ajaxCatalogkeyword()
	{
		$bookManager = new BookManager;

		
		$keyword = $_GET['keyword'];
		
		$titles = $bookManager->showTitle($keyword);
		// debug($titles);
		// die();

		$data = array('titles' => $titles);


		$this->show('book/ajax_catalog_keyword', $data);
	}

}