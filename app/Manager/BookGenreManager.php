<?php

namespace Manager;

use \W\Manager\ConnectionManager;

/**
 * Le manager de la table books
 */
class BookGenreManager extends DefaultManager
{

	public function __construct()
	{
		$this->table = 'books_genres';
		$this->dbh = ConnectionManager::getDbh();
	}

	public function findBooksIdsByGenresAndAvailability($selectedGenresId, $availability)
	{
		$selectedGenreId = $selectedGenresId[0];

		$selectedGenresIdSQL = " WHERE bg.genreId = ".$selectedGenreId;		
		
		if(count($selectedGenresId) > 1){

			for($index = 1; $index < count($selectedGenresId); $index++){
				$selectedGenreId = $selectedGenresId[$index];

				$selectedGenresIdSQL .= " OR bg.genreId = ".$selectedGenreId;
			}
		}

		$availabilitySQL = "";

		if($availability == 1){
			$availabilitySQL .= " AND b.is_available = 1";
		}

		$sql = "SELECT bookId as id
				FROM " . $this->table . " as bg 
				LEFT JOIN books as b 
				ON bg.bookId = b.id" . $selectedGenresIdSQL . $availabilitySQL;

		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		$arrayResponse = $sth->fetchAll();

		$booksIdsToFind = [];

		foreach($arrayResponse as $rowResponse){
			$booksIdsToFind[] = $rowResponse['id'];
		}

		return $booksIdsToFind;
	}

}