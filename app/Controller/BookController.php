<?php

namespace Controller;

use \Manager\BookManager;
use \Manager\GenreManager;

class BookController extends DefaultController
{

	/**
	 * Page de catalogue
	 */
	public function catalog()
	{
		if(!empty($_POST)){
			debug($_POST);
		}

		$genreManager = new GenreManager();
		$genres= $genreManager->findAll();

		$data = array('genres' => $genres);

		$this->show('book/catalog', $data);
	}

	public function ajaxCatalog()
	{
		$selectedGenres = []; 

		if(!empty($_POST['genres'])){
			$selectedGenres = $_POST['genres'];
		}

		$bookManager = new BookManager();
		$books= $bookManager->showBooks($selectedGenres);

		$data = array('books' => $books);

		$this->show('book/ajax_catalog', $data);
	}

}