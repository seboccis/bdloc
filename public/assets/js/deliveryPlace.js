function showDeliveryPlace(response){
	$('#choicedDeliveryPlace').html(response);
}

function getDeliveryPlace(id){
	var path = $('#mapDeliveryPlacesChoice').attr('data-ajax-deliveryPlace-getDeliveryPlace-path');
	$.ajax({
		url: path,
		data:{
			id: id,
		}
	})
	.done(showDeliveryPlace);
}

function showMap(response){

	var numberDeliveryPlaces = response.numberDeliveryPlaces;

	var mapCenter = new google.maps.LatLng(response.user.lat, response.user.lng);
	var mapOptions = {
		zoom: 15,
		center: mapCenter
	}
	
	var mapDeliveryPlacesChoice = new google.maps.Map(document.getElementById("mapDeliveryPlacesChoice"), mapOptions);

	var userMarker = new StyledMarker({styleIcon:new StyledIcon(StyledIconTypes.BUBBLE,{color:"00ff00",text:"Vous habitez ici"}),position:mapDeliveryPlacesChoice.getCenter(),map:mapDeliveryPlacesChoice});

	for(var i = 0; i < numberDeliveryPlaces; i++){
		var data = response.deliveryPlaces[i].id;
		var position = new google.maps.LatLng(response.deliveryPlaces[i].lat, response.deliveryPlaces[i].lng);
		var marker = new google.maps.Marker({
   												position: position,
    											map: mapDeliveryPlacesChoice,
    											title: response.deliveryPlaces[i].name + '\n' + response.deliveryPlaces[i].address
  											});
		(function (marker, data) {
		                google.maps.event.addListener(marker, "click", function (e) {
		                			$('#inputChoicedDeliveryPlace').attr('value', data);
		                			$('#validateChoicedDeliveryPlace').fadeIn(400);
	                   				getDeliveryPlace(data);
		 						});
		})(marker, data);
	}

}

function getMap(){
	path = $('#mapDeliveryPlacesChoice').attr('data-ajax-deliveryPlace-getMap-path');
	$.ajax({
		url: path,
	})
	.done(showMap);
}

$(window).on('load',getMap);