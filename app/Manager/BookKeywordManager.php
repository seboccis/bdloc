<?php

namespace Manager;

use \W\Manager\ConnectionManager;

/**
 * Le manager de la table books_keywords
 */
class BookKeywordManager extends DefaultManager
{

	public function __construct()
	{
		$this->table = 'books_keywords';
		$this->dbh = ConnectionManager::getDbh();
	}

}