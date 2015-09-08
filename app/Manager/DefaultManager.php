<?php

namespace Manager;

/**
 * Le manager par défaut qui sert à définir des méthodes perso
 * communes à toutes nos classes de manager
 */
class DefaultManager extends \W\Manager\Manager
{

	public function deleteSeveral($column, $array)
	{
		if(empty($array)){
			return true;
		}

		$stringArray = "";

		foreach($array as $value){
			$stringArray .= $value . ", ";
		}

		$stringArray = substr($stringArray, 0, -2);

		$sql = "DELETE FROM " . $this->table . "
				WHERE $column IN ($stringArray)";

		$sth = $this->dbh->prepare($sql);

		return $sth->execute(); 
	}

}