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

	public function ajaxCatalog()
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
		$books = $bookManager->showBooksbyIds($booksIdsToFind, $start);

		$data = array('books' => $books);

		$this->show('book/ajax_catalog', $data);
	}

	private function sortBooksIdsByOccurence($unsortedBooksIds)
	{
		
	}

}