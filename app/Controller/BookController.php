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
		$bookManager = new BookManager();
		$books = $bookManager->showMiniDetail(35);

		$data = array('books' => $books);

		$this->show('book/catalog', $data);
	}

}