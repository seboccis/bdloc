<?php

namespace Controller;

use \W\Controller\Controller;
use \Manager\DeliveryplaceManager;

class DeliveryplaceController extends Controller
{
	public function getZip($address)
	{
		debug($address);
	}

	public function ajaxDeliveryPlaceGetDeliveryPlace()
	{
		$id = $_GET['id'];

		$deliveryplaceManager = new DeliveryplaceManager();
		$deliveryPlace = $deliveryplaceManager->find($id);
		
		die('Vous avez choisi : ' . $deliveryPlace['name'] . ' au ' . $deliveryPlace['address'] . '.');
	}
}