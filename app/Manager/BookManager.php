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

	public function showBooksbyIds($booksIdsToFind, $start)
	{
		if(count($booksIdsToFind) == 0){
			$booksIdsToFindSQL = '';
		}
		else{
			$bookIdToFind = $booksIdsToFind[0];

			$booksIdsToFindSQL = " WHERE b.id = ".$bookIdToFind;

			if(count($booksIdsToFind) > 1){

				for($index = 1; $index < count($booksIdsToFind); $index++){
					$bookIdToFind = $booksIdsToFind[$index];

					$booksIdsToFindSQL .= " OR b.id = ".$bookIdToFind;
				}

			}
		}

		if($start == 0){
			$startSQL = '';
		}
		else{
			$startSQL = $start . ',';
		}

		$sql = "SELECT b.id, b.serieId, b.title, b.num, b.publisher, b.isbn, b.cover, b.exlibris, b.pages, b.dateCreated, b.dateModified , s.id scenaristId, s.firstName scenaristFirstName, s.lastName scenaristLastName, s.aka scenaristAka, i.id illustratorId, i.firstName illustratorFirstName, i.lastName illustratorLastName, i.aka illustratorAka, c.id coloristId, c.firstName coloristFirstName, c.lastName coloristLastName, c.aka coloristAka
				FROM books as b
				LEFT JOIN authors as s
				ON  b.scenarist = s.id
				LEFT JOIN authors as i
				ON  b.illustrator = i.id
				LEFT JOIN authors as c
				ON  b.colorist = c.id" . $booksIdsToFindSQL .
				" LIMIT " . $startSQL . " 6";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
		
	}

}