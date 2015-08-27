<?php

namespace Manager;

use \W\Manager\ConnectionManager;

/**
 * Le manager de la table cart
 */
class CartManager extends DefaultManager
{
	public function findCart($id)
	{
		$sql = "SELECT id
				FROM cart
				WHERE user_id = $id AND status = 0 ";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchColumn();
	}

	public function createCart($id)
	{
		$sql = "INSERT INTO cart(id, user_id, status, begin_date, end_date)
				VALUES (NULL,$id,0,NULL,NULL)";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $this->dbh->lastInsertId();

	}

	public function createRelation($cartId, $bookId)
	{
		$sql = "INSERT INTO cart_to_books(cart_id, book_id) 
				VALUES ('$cartId', '$bookId')";
		$sth = $this->dbh->prepare($sql);
		return $sth->execute();
	}

	public function findAllBooksIdsInCart($cartId)
	{
		$sql ="SELECT book_id
				FROM cart_to_books
				WHERE cart_id = $cartId";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}

	public function removeBook($bookId)
	{
		$sql = "DELETE FROM cart_to_books
				WHERE book_id = $bookId";
		$sth = $this->dbh->prepare($sql);
		return $sth->execute();
	}
}