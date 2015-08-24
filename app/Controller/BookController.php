<?php

namespace Controller;

use \Manager\BookManager;

class BookController extends DefaultController
{

	/**
	 * Page de catalogue
	 */
	public function catalog()
	{
		
		$this->show('book/catalog');
	}

	public function ajaxCatalog()
	{
		$bookManager = new BookManager();
		$books= $bookManager->showBooks();

		$data = array('books' => $books);

		$this->show('book/ajax_catalog', $data);
	}

}