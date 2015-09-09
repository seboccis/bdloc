<?php

namespace Manager;

/**
 * Le manager de la table deliveryplaces
 */
class DeliveryplaceManager extends DefaultManager
{
	public function showDeliveryplace($deliveryplaceId)
	{
		$sql = "SELECT name, address
				FROM ".$this->table."
				WHERE id = $deliveryplaceId";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetch();
	}
}