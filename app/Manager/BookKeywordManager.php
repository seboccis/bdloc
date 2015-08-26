<?php

namespace Manager;

use \W\Manager\ConnectionManager;

/**
 * Le manager de la table books_keywords
 */
class BookKeywordManager extends DefaultManager
{

	public function __construct()
	{
		$this->table = 'books_keywords';
		$this->dbh = ConnectionManager::getDbh();
	}

	public function findBooksIdByKeywordId($keywordId)
	{
		$sql = "SELECT bookId
				FROM " . $this->table . " 
				WHERE keywordId = " . $keywordId;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		$arrayResponse = $sth->fetchAll();

		$booksIdsToFindAccordingToKeyword = [];

		foreach($arrayResponse as $rowResponse){
			$booksIdsToFindAccordingToKeyword[] = $rowResponse['bookId'];
		}

		return $booksIdsToFindAccordingToKeyword;
	}

}