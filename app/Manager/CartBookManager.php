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

	public function countBooksInCart($userId)
	{
		$sql = "SELECT COUNT(*)
				FROM " . $this->table . " 
				WHERE cart_id =	(
									SELECT id
									FROM carts
									WHERE user_id = " . $userId . " 
									AND status = 0
								)";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchColumn();
	}

}