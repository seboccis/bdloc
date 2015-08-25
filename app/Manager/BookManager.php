<?php

namespace Manager;

/**
 * Le manager de la table books
 */
class BookManager extends DefaultManager
{

	public function findBooks($start)
	{
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
				ON  b.colorist = c.id
				LIMIT " . $startSQL . " 20";
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

}