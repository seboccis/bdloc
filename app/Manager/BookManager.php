<?php

namespace Manager;

/**
 * Le manager de la table books
 */
class BookManager extends DefaultManager
{

	public function findBooks($start, $number, $availability, $tri)
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

		$sql = "SELECT b.id, b.serieId, b.title, b.num, b.publisher, b.isbn, b.cover, b.exlibris, b.pages, b.dateCreated, b.dateModified , s.id scenaristId, s.firstName scenaristFirstName, s.lastName scenaristLastName, s.aka scenaristAka, i.id illustratorId, i.firstName illustratorFirstName, i.lastName illustratorLastName, i.aka illustratorAka, c.id coloristId, c.firstName coloristFirstName, c.lastName coloristLastName, c.aka coloristAka
				FROM books as b
				LEFT JOIN authors as s
				ON  b.scenarist = s.id
				LEFT JOIN authors as i
				ON  b.illustrator = i.id
				LEFT JOIN authors as c
				ON  b.colorist = c.id" . $availabilitySQL .
				" LIMIT " . $startSQL . " ".$number;
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

	public function showTitle($title)
	{
		$sql = "SELECT title
				FROM books
				WHERE title LIKE :keyword LIMIT 10";
		$sth = $this->dbh->prepare($sql);
		$sth->bindvalue(':keyword', '%' . $_GET['keyword'] . '%');
		$sth->execute();

		$titles = $sth->fetchAll();

		return $titles;			
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