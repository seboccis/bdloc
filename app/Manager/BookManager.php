<?php

namespace Manager;

/**
 * Le manager de la table books
 */
class BookManager extends DefaultManager
{

	public function findBooks($number)
	{
		$sql = "SELECT * FROM " . $this->table . " ORDER BY RAND() LIMIT " . $number;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
	}

}