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

	public function findBooksIdsByGenres($selectedGenresId)
	{
		$selectedGenreId = $selectedGenresId[0];

		$selectedGenresIdSQL = " WHERE genreId = ".$selectedGenreId;		
		
		if(count($selectedGenresId) > 1){

			for($index = 1; $index < count($selectedGenresId); $index++){
				$selectedGenreId = $selectedGenresId[$index];

				$selectedGenresIdSQL .= " OR genreId = ".$selectedGenreId;
			}
		}

		$sql = "SELECT bookId as id
				FROM " . $this->table . $selectedGenresIdSQL;

		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		$arrayResponse = $sth->fetchAll();

		$booksIdsToFindAccordingToGenres = [];

		foreach($arrayResponse as $rowResponse){
			$booksIdsToFindAccordingToGenres[] = $rowResponse['id'];
		}

		return $booksIdsToFindAccordingToGenres;
	}

}