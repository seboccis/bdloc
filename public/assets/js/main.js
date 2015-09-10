////// JS pour toutes les pages dépendant de main_layout

	function showCount(response)
	{
		var numberBooksInCart = response;
		$('#numberBooksInCart').html(numberBooksInCart);
		$('#showNumberBooksInCart').html(numberBooksInCart);

		$('#numberBooksInCart').css({'background-color' : 'green'});
		if(numberBooksInCart == 10){
			$('#numberBooksInCart').css({'background-color' : 'red'});
		}

		$('#numberBooksInCart').fadeIn(500);
	}

	function countBooksInCart(){
		var path = $('#numberBooksInCart').attr('data-ajax-main-countBooksInCart');
		$.ajax({
			url: path,				
			type: "POST",
		})
		.done(showCount);
	}



////// JS pour la page catalog


	//// Functions

		// Affichage des vignettes de BD correspondant aux critères de filtres et de tri

		function showBooks(response){

			$('#showBooks').html(response);

			var numberBooksInCart = document.getElementById('numberBooksInCart').innerHTML;

			if(numberBooksInCart == 10){
				$("#showBooks .addToCart").css({'display': 'none'});
			}
			
			var first = $('#showBooks > #dataRequest').attr('data-request-first');
			var last = $('#showBooks > #dataRequest').attr('data-request-last');
			var total = $('#showBooks > #dataRequest').attr('data-request-total');

			$('#first').html(first);
			$('#last').html(last);
			$('#total').html(total);

			if(first == 1){
				$('#prevBooks').css({'display' : 'none'});
			}
			if(first > 1){
				$('#prevBooks').css({'display' : 'inline'});
			}
			if(last == total){
				$('#nextBooks').css({'display' : 'none'});
			}
			if(last < total){
				$('#nextBooks').css({'display' : 'inline'});
			}
		}

		function showRequestFailed(){
			$('#showBooks').html('<span>La requête a échoué</span>');
		}

		function getBooks(start){

			var path = $('#showBooks').attr('data-ajax-catalog-getBooks-path');
			$.ajax({
				url: path,
				data: $('#formSideBarFilters').serialize()+'&'+$('#formResultsBarFilters').serialize()+'&start='+start,				
				type: "POST",
			})
			.done(showBooks)
			.fail(showRequestFailed);
		}

		// Affichage de la fenêtre modale

		function showDetail(response){
			$('#lightBox').html(response);

			var numberBooksInCart = document.getElementById('numberBooksInCart').innerHTML;
			if(numberBooksInCart == 10){
				$("#lightBox .addToCart").css({'display': 'none'});
			}

			$('#shadow').fadeIn(200);
			$('#lightBox').fadeIn(200);

		}

		function getDetail(bookId){
			var path = $('#lightBox').attr('data-ajax-catalog-getDetail-path');
			
			$.ajax({
				url: path,
				data: {
					id: bookId,
				}
			})
			.done(showDetail);
		}

		// Affichage des mots-clé

		function showKeywords(response){
			if(response.length > 0){
				$('#resultKeywordResearch').html(response);							
			}
			else{
				$('#resultKeywordResearch').html('Aucun mot-clé ne correspond à cette recherche.');
			}
		}

		function getKeywords(keywordBeginning){
			var keywordBeginning = $('#inputKeyword').val();
			if (keywordBeginning.length < 3){
				$('#resultKeywordResearch').html('');
			}
			else{
				var path = $('#inputKeyword').attr('data-ajax-catalog-getKeywords-path');

				$.ajax({
						url : path,
						data : {
							'keywordBeginning' : keywordBeginning,
					}
				})
				.done(showKeywords);	
			}
		}

		// Choix du mot-clé

		function attachKeyword(event)
		{  
		   event.preventDefault();
		   var data = $(this).attr('data-keyword');
		   $("#inputKeyword").val(data);
		   $("#resultKeywordResearch").html('');
		   getBooks(0);
		}

		// Ajouter au panier

		function showAddToCart(response){
			countBooksInCart();
			$('#cartError').html(response);
			var start = $('#showBooks > #dataRequest').attr('data-request-first') - 1;
			getBooks(start);
		}

		function addToCart(bookId){
			var path = $('#showBooks').attr('data-ajax-catalog-addToCart-path');
			$.ajax({
				url: path,
				data: {
					id: bookId,
				}
			})
			.done(showAddToCart);
		}

		// Affichage de la vignette de BD visée dans le carousel

		function translateCarousel(actualPosition, newPosition){

			var numberPanels	= $('#carouselWindow').attr('data-numberBooksInSerie');

			$('#carouselIndicators span a:nth-child(' + parseInt(actualPosition) + ') i').removeClass("fa-circle").addClass("fa-circle-thin");
			$('#carouselIndicators span a:nth-child(' + parseInt(newPosition) + ') i').removeClass("fa-circle-thin").addClass("fa-circle");

			if(newPosition == 1){
				$('#btnCarouselPrev').css({'visibility': 'hidden'});
				$('#btnCarouselNext').css({'visibility': 'visible'});
			}
			else if(newPosition == numberPanels){
				$('#btnCarouselPrev').css({'visibility': 'visible'});
				$('#btnCarouselNext').css({'visibility': 'hidden'});
			}
			else{
				$('#btnCarouselPrev').css({'visibility': 'visible'});
				$('#btnCarouselNext').css({'visibility': 'visible'});
			}

			var translate = (parseInt(newPosition) - 1) * -500;

			$('#spriteCarousel').css({'left': translate + 'px'});

			$('#carouselWindow').attr('data-carouselPosition', newPosition);

		}


	//// Gestion des événements

		// Gestion des événements sur les vignettes

		$("#showBooks").on("click", ".detail", function(event){
			event.preventDefault();
			var bookId = $(this).parent().parent().parent('.card').attr('data-bookId');		
			getDetail(bookId);
			
		});

		$('#showBooks').on('click', '.addToCart', function(event){
			event.preventDefault();
			var bookId = $(this).parent().parent().parent('.card').attr('data-bookId');
			addToCart(bookId);
		});
		
		// Gestion des événements sur les checkboxes (appel de la fonction getBooks)

		$('.checkbox').on('click', function(e){
			getBooks(0);
		});

		// Gestion des événements sur la recherche par mot-clé (appel de la fonction getBooks)
			
		$("#inputKeyword").on('keyup', getKeywords);

		$("#resultKeywordResearch").on('click', 'a', attachKeyword);

		$('#btnRefresh').on('click', function(e){
			e.preventDefault();
			$("#inputKeyword").val('');
			getBooks(0);
		});

		// Gestion des événements sur le tri (appel de la fonction getBooks)

		$('#selectCatalogSort').on('change', function(e){
		  	e.preventDefault();
			getBooks(0);
		});

		// Gestion des événements sur le nombre de BD à afficher (appel de la fonction getBooks)

		$('#selectCatalogNumber').on('change', function(e){
		  	e.preventDefault();
			getBooks(0);
		});
		
		//Gestion des événements sur la pagination (appel de la fonction getBooks)

		$('#prevBooks').on('click', function(e){
			e.preventDefault();
			var start = $('#showBooks > #dataRequest').attr('data-request-precStart');
			getBooks(start);
		});

		$('#nextBooks').on('click', function(e){
			e.preventDefault();
			var start = $('#showBooks > #dataRequest').attr('data-request-nextStart');
			getBooks(start);
		});

		// Gestion des événements sur la fenêtre modale
		
		$('#lightBox').on('click', '.addToCart', function(event){
			event.preventDefault();
			var bookId = $(this).attr('data-bookId');

			$(this).fadeOut(500);		
			addToCart(bookId);
		});

		$('#lightBox').on('click', '#btnCarouselPrev',function(event){
			event.preventDefault();

			var actualPosition	= $('#carouselWindow').attr('data-carouselPosition');
			var newPosition = parseInt(actualPosition) - 1;

			translateCarousel(actualPosition, newPosition);

			event.stopPropagation();
		});

		$('#lightBox').on('click', '#btnCarouselNext',function(event){
			event.preventDefault();

			var actualPosition	= $('#carouselWindow').attr('data-carouselPosition');
			var newPosition = parseInt(actualPosition) + 1;

			translateCarousel(actualPosition, newPosition);

			event.stopPropagation();
		});

		$('#lightBox').on('click', '.carouselIndicator',function(event){
			event.preventDefault();

			var actualPosition	= $('#carouselWindow').attr('data-carouselPosition');
			var newPosition = $(this).attr('data-carouselPosition');

			translateCarousel(actualPosition, newPosition);

			event.stopPropagation();
		});

		$('#lightBox').on('click', '.newDetail',function(event){
			event.preventDefault();

			var bookId = $(this).attr('data-bookId');
			getDetail(bookId);

			event.stopPropagation();
		});

		$('#lightBox').on("click",function(event){
			event.stopPropagation();
		});

		$('#lightBox').on("click", '#closeLightBox', function(event){
			$('#lightBox').fadeOut(200);
			$('#shadow').fadeOut(200);
			event.stopPropagation();
		});

		$('html').on("click",function(event){
			$('#shadow').fadeOut(200);
			event.stopPropagation();
		});
	

////// JS pour la page cart

		// Remove from Cart

		$(".removeFromCart").on('click',function(event){
			event.preventDefault();
			var that = $(this);
			var path = that.attr('href');
			$.ajax({
				url: path,
			})
			.done(function(){
				that.parents('tr').attr('class','hidden');
				that.parents('tr').fadeOut(200);
				countBooksInCart();
				if ($('tr.visible').length == 0){
					$('#order').css({'display':'none'});
				}; 
			});
		});


////// JS pour la page submit_order

function showDeliveryPlace(response){
	$('#choicedDeliveryPlace').html(response);
	// var nameChoiced$('#deliveryplace>optgroup>option[value="impair"]')')
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

	$('.legendShowMap').css({"display":"block"});
  						
}

function getMap(){
	if($('#mapDeliveryPlacesChoice').attr('data-showMap') == 1){
		path = $('#mapDeliveryPlacesChoice').attr('data-ajax-deliveryPlace-getMap-path');
		$.ajax({
			url: path,
		})
		.done(showMap);
	}
}



		
////// A l'ouverture de la page

$(window).on("load", function(){
	countBooksInCart();
	getBooks(0);
	getMap();
});
