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

	public function extendedFind($id)
	{
		$sql = "SELECT b.id, b.serieId, b.title, b.num, b.publisher, b.isbn, b.cover, b.exlibris, b.pages, b.quantity_available, b.dateCreated, b.dateModified , s.id scenaristId, s.firstName scenaristFirstName, s.lastName scenaristLastName, s.aka scenaristAka, i.id illustratorId, i.firstName illustratorFirstName, i.lastName illustratorLastName, i.aka illustratorAka, c.id coloristId, c.firstName coloristFirstName, c.lastName coloristLastName, c.aka coloristAka
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

	public function findCatalogBooks($selectedGenresId, $availability, $keyword, $sort, $start, $number)
	{
		$sql = $this->createSQLCatalog(1, $selectedGenresId, $availability, $keyword, $sort, $start, $number);

		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
	}

	public function countCatalogBooks($selectedGenresId, $availability, $keyword, $sort, $start, $number)
	{
		$sql = $this->createSQLCatalog(2, $selectedGenresId, $availability, $keyword, $sort, $start, $number);

		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchColumn();
	}

	private function createSQLCatalog($int, $selectedGenresId, $availability, $keyword, $sort, $start, $number)
	{

		$genresSQL = ' ';
		if(!empty($selectedGenresId)){

			$underGenresSQL = '';

			foreach($selectedGenresId as $genreId){
				$underGenresSQL .= 'genreId = ' . $genreId . ' OR ';
			}

			$underGenresSQL = substr($underGenresSQL, 0, -4);

			$genresSQL = ' AND b.id IN	(
											SELECT bookId
											FROM books_genres
											WHERE ' . $underGenresSQL . ' 
										)';
		}

		$availabilitySQL = ' ';
		if($availability == 1){
			$availabilitySQL = ' AND b.quantity_available > 0';
		}

		$keywordSQL = ' ';
		if(!empty($keyword)){
			$keywordSQL = " AND b.id IN	(
											SELECT bookId
											FROM books_keywords
											WHERE keywordId IN	(
																	SELECT id
																	FROM keywords
																	WHERE keyword = '" . $keyword . "'
																)
										)";
		}

		$sortSQL = " ";
		if($sort == "serie"){
			$sortSQL = 'ORDER BY serieId';
		}
		if($sort == "title"){
			$sortSQL = ' ORDER BY title';
		}

		$paginationSQL = ' LIMIT ' . $start . ', ' . $number;

		$columnsSQL = 'COUNT(*) ';
		if($int == 1){
			$columnsSQL = 'b.id, b.serieId, b.title, b.num, b.publisher, b.isbn, b.cover, b.exlibris, b.pages, b.quantity_available,b.dateCreated, b.dateModified , s.id scenaristId, s.firstName scenaristFirstName, s.lastName scenaristLastName, s.aka scenaristAka, i.id illustratorId, i.firstName illustratorFirstName, i.lastName illustratorLastName, i.aka illustratorAka, c.id coloristId, c.firstName coloristFirstName, c.lastName coloristLastName, c.aka coloristAka ';
		}
		else if($int == 2){
			$columnsSQL = 'COUNT(*) ';
			$paginationSQL = '';
		}

		$sql = "SELECT " . $columnsSQL . "
				FROM books as b
				LEFT JOIN authors as s
				ON  b.scenarist = s.id
				LEFT JOIN authors as i
				ON  b.illustrator = i.id
				LEFT JOIN authors as c
				ON  b.colorist = c.id
				WHERE b.id >= 0"
				. $genresSQL . $availabilitySQL . $keywordSQL . $sortSQL . $paginationSQL;

		return $sql; 
	}

	public function decreaseQuantityAvailable($bookId)
	{
		
		// réduire la quantité disponible
		$sql = "UPDATE ".$this->table."
				SET quantity_available = quantity_available - 1
				WHERE id = $bookId";
		$sth = $this->dbh->prepare($sql);
		return $sth->execute();

 	}

 	public function increaseQuantityAvailable($bookId)
	{
		
		// augmenter la quantité disponible
		$sql = "UPDATE ".$this->table."
				SET quantity_available = quantity_available + 1
				WHERE id = $bookId";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
 	}

}