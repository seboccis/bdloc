<?php

namespace Controller;

use \Manager\DeliveryplaceManager;

class GoogleAPIController extends DefaultController
{

	public function getCoordinates($address, $zipcode)
	{
		$googleAddress = urlencode($address . ", " . $zip_code ." Paris");

		$response = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$googleAddress);
		$arrayResponse = json_decode($response, true);

		$lat = NULL;
		$lng = NULL;

		if(!empty($arrayResponse['results'][0])){

				$lat = $arrayResponse['results'][0]['geometry']['location']['lat'];
				$lng = $arrayResponse['results'][0]['geometry']['location']['lng'];

		}

		return [$lat, $lng];
	}

	public function deliveryPlace()
	{
		$this->lock();

		debug($_POST); debug($_GET); die($cartIdToOrder);

		$cartIdToOrder = $_POST['cartIdToOrder'];

		$this->show('googleAPI/deliveryPlace', ['cartIdToOrder' => $cartIdToOrder,]);
	}

	public function ajaxDeliveryPlaceGetMap()
	{
		$user = $this->getUser();

		$deliveryplaceManager = new DeliveryplaceManager();
		$deliveryPlaces = $deliveryplaceManager->findAll();

		$numberDeliveryPlaces = count($deliveryPlaces);

		$data = [
					'user'					=> $user,
					'numberDeliveryPlaces'	=> $numberDeliveryPlaces,
					'deliveryPlaces'		=> $deliveryPlaces,
				];

		$this->showJson($data);
	}

}