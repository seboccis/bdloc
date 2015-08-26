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

}