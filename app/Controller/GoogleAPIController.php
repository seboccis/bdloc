<?php

namespace Controller;

use \Manager\DeliveryplaceManager;

class GoogleAPIController extends DefaultController
{

	public function getCoordinates($address, $zip_code)
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