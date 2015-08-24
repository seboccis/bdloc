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

	public function showMiniDetail($number)
	{

    	$sql = "SELECT b.id, b.serieId, b.title, b.num, b.publisher, b.isbn, b.cover, b.exlibris, b.pages, b.dateCreated, b.dateModified , s.id scenaristId, s.firstName scenaristFirstName, s.lastName scenaristLastName, s.aka scenaristAka, i.id illustratorId, i.firstName illustratorFirstName, i.lastName illustratorLastName, i.aka illustratorAka FROM books as b LEFT JOIN authors as s ON  b.scenarist = s.id LEFT JOIN authors as i ON  b.illustrator = i.id LIMIT ". $number;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
    
	}

}