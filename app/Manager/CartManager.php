<?php

namespace Manager;

/**
 * Le manager de la table cart
 */
class CartManager extends DefaultManager
{

	// public function findCartDelay($cartId)
	// {
	// 	$sql = "SELECT UNIX_TIMESTAMP(modified_date) - UNIX_TIMESTAMP(date_sub(NOW(),INTERVAL 10 MINUTE))
	// 			FROM $this->table
	// 			WHERE id = $cartId";
	// 	$sth = $this->dbh->prepare($sql);
	// 	$sth->execute();
	// 	return $sth->fetchColumn();
	// } 

	public function findCart($id)
	{
		$sql = "SELECT id
				FROM " . $this->table . "
				WHERE user_id = $id AND status = 0 ";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchColumn();
	}

	public function showCarts($cartIds)
	{
		$ids = "";
		foreach ($cartIds as $cartId) {
			$ids .= $cartId . ", "; 
		}

		$stringId = substr($ids, 0, -2);
		
		$sql = "SELECT *
				FROM " . $this->table . "
				WHERE id IN ($stringId)";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
	}

	// insérer éventuellement un argument supplémentaire à findCart pour pouvoir trouver les paniers en cours et les commandes
	public function findOrder($id, $status)
	{
		$sql = "SELECT id
				FROM " . $this->table . "
				WHERE user_id = $id AND status = :status ";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(":status", $status);
		$sth->execute();

		return $sth->fetchAll();
	}

	public function findBook($bookId,$cartId)
	{
		$sql = "SELECT *
				FROM cart_to_books
				WHERE book_id = $bookId AND cart_id = $cartId";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetch();
	}

	public function createCart($id)
	{
		$sql = "INSERT INTO " . $this->table . " (id, user_id, status, begin_date, modified_date, end_date)
				VALUES (NULL, $id, 0, NULL, NOW(), NULL)";
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
				WHERE cart_id = " . $cartId;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}

	public function findAllBooksIdsInCarts($cartIds)
	{
		$ids = "";
		foreach ($cartIds as $cartId) {
			$ids .= $cartId . ", "; 
		}

		$stringId = substr($ids, 0, -2);


		$sql = "SELECT book_id
				FROM cart_to_books
				WHERE cart_id IN ($stringId)";
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

	public function countBooksInCart($cartId)
	{
		$sql = "SELECT COUNT(*)
				FROM cart_to_books
				WHERE cart_id = $cartId";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchColumn();
	}

	public function countBooksInCarts($cartIds)
	{
		$ids = "";
		foreach ($cartIds as $cartId) {
			$ids .= $cartId . ", "; 
		}

		$stringId = substr($ids, 0, -2);


		$sql = "SELECT COUNT(*)
				FROM cart_to_books
				WHERE cart_id IN ($stringId)";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchColumn();
	}

	public function removeCart($cartId)
	{
		$sql ="DELETE FROM carts 
				WHERE id = $cartId ";

		$sth = $this->dbh->prepare($sql);
		return $sth->execute();

	}

	public function removeBooks($cartId)
	{
		$sql = "DELETE FROM cart_to_books WHERE cart_id = $cartId";
		$sth = $this->dbh->prepare($sql);
		return $sth->execute();

	}

	public function convertCartToOrder($cartId, $deliveryplaceId)
	{
		$sql = "UPDATE " . $this->table . " 
				SET status = 1, deliveryplace_id = :deliveryplaceId, begin_date = NOW() 
				WHERE id = $cartId";
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':deliveryplaceId',$deliveryplaceId);
		return $sth->execute();
	}

	public function getIdsExpiredCarts()
	{
		$sql = "SELECT id
				FROM " . $this->table . "
    			WHERE modified_date < date_sub(NOW(),INTERVAL 10 MINUTE)
    			AND status = 0";
    	$sth = $this->dbh->prepare($sql);
    	$sth->execute();

    	return $sth->fetchAll();
	}

	public function showAllCarts()
	{
		$sql = "SELECT c.id as cartId, c.status, c.deliveryplace_id, c.begin_date, c.end_date, u.id as userId, u.username
				FROM ". $this->table ." as c
				LEFT JOIN users as u
				ON user_id = u.id";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
	}

	public function getDeliveryplaceId($cartId)
	{
		$sql = "SELECT deliveryplace_id
				FROM ".$this->table. "
				WHERE id = $cartId";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchColumn();
	}

}