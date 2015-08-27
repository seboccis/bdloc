<?php

namespace Manager;

/**
 * Le manager de la table books
 */
class BookManager extends DefaultManager
{
	public function showBooks($booksIds)
	{
		foreach ($booksIds as $bookId) {
			$id =  $bookId['book_id'];
			$sql = "SELECT id, cover, title
					FROM books
					WHERE id = $id";

			$sth = $this->dbh->prepare($sql);
			$sth->execute();

			$books[] =  $sth->fetch();
		}
		return $books;
	}

	public function findBooks($start, $number, $availability, $sort)
	{
		if($start == 0){
			$startSQL = '';
		}
		else{
			$startSQL = $start . ',';
		}

		$availabilitySQL = '';
		if($availability == 1){
			$availabilitySQL = ' WHERE b.is_available = 1';
		}

		$sortSQL = "";
		if($sort == "serie"){
			$sortSQL = ' ORDER BY b.serieId';
		}
		if($sort == "title"){
			$sortSQL = ' ORDER BY b.title';
		}

		$sql = "SELECT b.id, b.serieId, b.title, b.num, b.publisher, b.isbn, b.cover, b.exlibris, b.pages, b.dateCreated, b.dateModified , s.id scenaristId, s.firstName scenaristFirstName, s.lastName scenaristLastName, s.aka scenaristAka, i.id illustratorId, i.firstName illustratorFirstName, i.lastName illustratorLastName, i.aka illustratorAka, c.id coloristId, c.firstName coloristFirstName, c.lastName coloristLastName, c.aka coloristAka
				FROM books as b
				LEFT JOIN authors as s
				ON  b.scenarist = s.id
				LEFT JOIN authors as i
				ON  b.illustrator = i.id
				LEFT JOIN authors as c
				ON  b.colorist = c.id" . $availabilitySQL . $sortSQL.
				" LIMIT " . $startSQL . " ".$number;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
	}

	public function findBooksByArrayIds($bookIds, $start, $number, $sort)
	{
		$idsSQL = '';
		$nbIds = count($bookIds);
		if($nbIds >= 1){
			$idsSQL = ' WHERE b.id = ' . $bookIds[0];
			if($nbIds >= 2){
				for($index = 1; $index < $nbIds; $index++){
					$idsSQL .= ' OR b.id = ' . $bookIds[$index];
				}
			}
		}

		if($start == 0){
			$startSQL = '';
		}
		else{
			$startSQL = $start . ',';
		}

		$sortSQL = "";
		if($sort == "serie"){
			$sortSQL = ' ORDER BY b.serieId';
		}
		if($sort == "title"){
			$sortSQL = ' ORDER BY b.title';
		}

		$sql = "SELECT b.id, b.serieId, b.title, b.num, b.publisher, b.isbn, b.cover, b.exlibris, b.pages, b.dateCreated, b.dateModified , s.id scenaristId, s.firstName scenaristFirstName, s.lastName scenaristLastName, s.aka scenaristAka, i.id illustratorId, i.firstName illustratorFirstName, i.lastName illustratorLastName, i.aka illustratorAka, c.id coloristId, c.firstName coloristFirstName, c.lastName coloristLastName, c.aka coloristAka
				FROM books as b
				LEFT JOIN authors as s
				ON  b.scenarist = s.id
				LEFT JOIN authors as i
				ON  b.illustrator = i.id
				LEFT JOIN authors as c
				ON  b.colorist = c.id" . $idsSQL . $sortSQL.
				" LIMIT " . $startSQL . " ". $number;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();	
	}

	public function extendedFind($id)
	{
		$sql = "SELECT b.id, b.serieId, b.title, b.num, b.publisher, b.isbn, b.cover, b.exlibris, b.pages, b.dateCreated, b.dateModified , s.id scenaristId, s.firstName scenaristFirstName, s.lastName scenaristLastName, s.aka scenaristAka, i.id illustratorId, i.firstName illustratorFirstName, i.lastName illustratorLastName, i.aka illustratorAka, c.id coloristId, c.firstName coloristFirstName, c.lastName coloristLastName, c.aka coloristAka
				FROM books as b
				LEFT JOIN authors as s
				ON  b.scenarist = s.id
				LEFT JOIN authors as i
				ON  b.illustrator = i.id
				LEFT JOIN authors as c
				ON  b.colorist = c.id
				WHERE b.id = " . $id;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetch();
	}

	public function countBooks($availability)
	{
		$availabilitySQL = '';
		if($availability == 1){
			$availabilitySQL = ' WHERE is_available = 1';
		}

		$sql = "SELECT COUNT(*)
				FROM " . $this->table . $availabilitySQL;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchColumn();
	}

	public function findBooksdIdAvailable($booksIdsToFindAccordingToFilters)
	{
		$nbBooksId = count($booksIdsToFindAccordingToFilters);

		if($nbBooksId == 0){
			$authorizedBooksIdsToFindAccordingToFiltersAndAvailability = [];
		}
		else{

			$stringId ='';

			foreach($booksIdsToFindAccordingToFilters as $id){
				$stringId .= $id . ' ,';
			}

			$stringId = substr($stringId, 0, -2);

			$booksIdSQL = ' WHERE id IN (' . $stringId . ')';			

			$sql = "SELECT id
					FROM " . $this->table .
					$booksIdSQL . " 
					AND is_available = 1";
			$sth = $this->dbh->prepare($sql);
			$sth->execute();

			$authorizedBooksIdsToFindAccordingToFiltersAndAvailability = $sth->fetchAll();
		}

		return $authorizedBooksIdsToFindAccordingToFiltersAndAvailability; 
	}

}