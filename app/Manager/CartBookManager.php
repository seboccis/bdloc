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

	public function countBooksInCart($cartId)
	{
		$sql = "SELECT COUNT(*)
				FROM " . $this->table . " 
				WHERE cart_id =	" . $cartId;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchColumn();
	}

}