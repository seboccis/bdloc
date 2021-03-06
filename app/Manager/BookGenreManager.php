<?php

namespace Manager;

use \W\Manager\ConnectionManager;

/**
 * Le manager de la table books_genres
 */
class BookGenreManager extends DefaultManager
{

	public function __construct()
	{
		$this->table = 'books_genres';
		$this->dbh = ConnectionManager::getDbh();
	}

}