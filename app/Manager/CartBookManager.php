<?php

namespace Manager;

use \W\Manager\ConnectionManager;

/**
 * Le manager de la table cart_to_books
 */
class CartBookManager extends DefaultManager
{

	public function __construct()
	{
		$this->table = 'cart_to_books';
		$this->dbh = ConnectionManager::getDbh();
	}

}