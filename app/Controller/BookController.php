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
		$selectedGenresId = [];
		$booksIdsToFind = [];
		$start = 0; 

		if(!empty($_POST['genres'])){
			$selectedGenresId = $_POST['genres'];
		}

		if(count($selectedGenresId) == 1){
			$bookGenreManager = new BookGenreManager();
			$booksIdsToFind = $bookGenreManager->findBooksIdsByGenres($selectedGenresId); 
		}
		else if(count($selectedGenresId) > 1){
			$bookGenreManager = new BookGenreManager();
			$unsortedBooksIds = $bookGenreManager->findBooksIdsByGenres($selectedGenresId);
			$booksIdsToFind = $this->sortBooksIdsByOccurence($unsortedBooksIds); 
		}

		$bookManager = new BookManager();

		if(count($booksIdsToFind) == 0){
			$books = $bookManager->findBooks($start);
		}
		else{
			$books = [];

			for($index = $start; $index < $start + 20; $index++){
				$books[] = $bookManager->extendedFind($booksIdsToFind[$index]);
			}
		}

		$data = array('books' => $books);

		$this->show('book/ajax_catalog', $data);
	}


	public function ajaxDetail()
	{
		$bookManager = new BookManager;

		$book = $bookManager->extendedFind($_GET['id']);

		$data = array('book' => $book);


		$this->show('book/ajax_detail', $data);
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

}