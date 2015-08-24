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

	public function showBooks($selectedGenres)
	{

		if(count($selectedGenres) == 0){
			$selectedGenreSQL = '';
		}
		else if(count($selectedGenres) == 1){
			$selectedGenre = $selectedGenres[0];

			$selectedGenreSQL = "	LEFT JOIN books_genres as bg
									ON b.id = bg.bookId
									WHERE bg.genreId = ".$selectedGenre;		
		}
		else{
			$selectedGenre = $selectedGenres[0];

			$selectedGenreSQL = "	LEFT JOIN books_genres as bg
									ON b.id = bg.bookId
									WHERE bg.genreId = ".$selectedGenre;
			for($index = 1; $index < count($selectedGenres); $index++){
				$selectedGenre = $selectedGenres[$index];

				$selectedGenreSQL .= " OR bg.genreId = ".$selectedGenre;
			}
		}

		$start = 0;

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
				ON  b.colorist = c.id "
				. $selectedGenreSQL ." LIMIT " . $startSQL . " 6";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
		
	}

}