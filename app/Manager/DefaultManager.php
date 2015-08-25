<?php

namespace Manager;

/**
 * Le manager par défaut qui sert à définir des méthodes perso
 * communes à toutes nos classes de manager
 */
class DefaultManager extends \W\Manager\Manager
{

	public function count()
	{
		$sql = "SELECT COUNT(*)
				FROM " . $this->table;
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchColumn();
	}

}