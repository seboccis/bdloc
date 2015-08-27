<?php

namespace Manager;

/**
 * Le manager de la table keywors
 */
class KeywordManager extends DefaultManager
{

	public function findIdByKeyword($keyword)
	{

		$sql = "SELECT id
				FROM " . $this->table . " 
				WHERE keyword = '" . $keyword . "'";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchColumn();

	}

	public function findKeywords($keywordBeginnig)
	{
		$sql = "SELECT keyword
				FROM " . $this->table . " 
				WHERE keyword LIKE :keywordBeginnig LIMIT 10";
		$sth = $this->dbh->prepare($sql);
		$sth->bindvalue(':keywordBeginnig', $keywordBeginnig . '%');
		$sth->execute();

		$keywords = $sth->fetchAll();

		return $keywords;			
	}

}