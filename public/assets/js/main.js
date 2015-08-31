//// JS pour toutes les pages dépendant de main_layout

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

//// JS pour la page catalog 

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

		var path = $('#sideBar').attr('data-ajax-catalog-getBooks-path');
		$.ajax({
			url: path,
			data: $('#formSideBarFilters').serialize()+'&'+$('#formResultsBarFilters').serialize()+'&start='+start,				
			type: "POST",
		})
		.done(showBooks)
		.fail(showRequestFailed);
	}

	// Affichage de la fenêtre modale

	$("#showBooks").on("click", ".detail", function(event){
		event.preventDefault();

		var path = $('#showDetail').attr('data-ajax-catalog-detail-path');
		
		$.ajax({
			url: path,
			data: {
				id: $(this).attr('value'),
			}
		})
		.done(function(response){
			$('#showDetail').html(response);

			var numberBooksInCart = document.getElementById('numberBooksInCart').innerHTML;
			if(numberBooksInCart == 10){
				$("#showDetail .addToCart").css({'display': 'none'});
			}

			$('#shadow').fadeIn(200);
			$('#showDetail').fadeIn(200);

			event.stopPropagation();
			
		});

		$('#showDetail').on("click",function(event){
			event.stopPropagation();
		});

		$('#showDetail').on("click", '#btn',function(event){
			$('#showDetail').fadeOut(200);
			$('#shadow').fadeOut(200);
			event.stopPropagation();
		});

		$('html').on("click",function(event){
			$('#shadow').fadeOut(200);
			event.stopPropagation();
		});

	})

	// Ajouter au panier

	function showAddToCart(response){
		countBooksInCart();
		$('#cartError').html(response);
		var start = $('#showBooks > #dataRequest').attr('data-request-first') - 1;
		getBooks(start);
	}

	function addToCart(that){
		var path = that.attr('href');
		var bookId = that.attr('data-bookIdToCart');
		$.ajax({
			url: path,
			data: {
				id: bookId,
			}
		})
		.done(showAddToCart);
	}
	
	// Gestion des événements sur les vignettes

	$('#showBooks').on('click', '.addToCart', function(event){
		event.preventDefault();
		var that = $(this);
		addToCart(that);
	})
	
	// Gestion des événements sur les filtres (appel de la fonction getBooks)

	$('.checkbox').on('click', function(e){
		getBooks(0);
	})
		
	$("#inputKeyword").on('keyup', function(){
		var keywordBeginning = $('#inputKeyword').val();
		var path = $('#inputKeyword').attr('data-ajax-catalog-keyword-path');
		if (keywordBeginning.length < 3){
			$('#resultKeywordResearch').html('');
		}
		else{
			$.ajax({
				url : path,
				data : {
				'keywordBeginning' : keywordBeginning,
				}
			})
			.done(function(response){
				if(response.length > 0){
					$('#resultKeywordResearch').html(response);							
				}
				else{
					$('#resultKeywordResearch').html('Aucun mot-clé ne correspond à cette recherche.');
				}
			});	
		}
	})

	// Gestion des événements sur le tri (appel de la fonction getBooks)

	$('#selectCatalogSort').on('change', function(e){
	  	e.preventDefault();
		getBooks(0);
	})

	// Gestion des événements sur le nombre de BD à afficher (appel de la fonction getBooks)

	$('#selectCatalogNumber').on('change', function(e){
	  	e.preventDefault();
		getBooks(0);
	})
	
	//Gestion des événements sur la pagination (appel de la fonction getBooks)

	$('#prevBooks').on('click', function(e){
		e.preventDefault();
		var start = $('#showBooks > #dataRequest').attr('data-request-precStart');
		getBooks(start);
	})

	$('#nextBooks').on('click', function(e){
		e.preventDefault();
		var start = $('#showBooks > #dataRequest').attr('data-request-nextStart');
		getBooks(start);
	})
	

	$('#showDetail').on('click', '.addToCart', function(event){
		event.preventDefault();
		var that = $(this);
		that.fadeOut(500);		
		addToCart(that);
	})





	



function attachKeyword(event)
{  
   var data = $(this).attr('data-keyword');
   $("#inputKeyword").val(data);
   event.preventDefault();
   getBooks(0);
   $("#resultKeywordResearch").html('');
}

$("#resultKeywordResearch").on('click', 'a', attachKeyword);

$('#btnRefresh').on('click', function(e){
	e.preventDefault();
	$("#inputKeyword").val('');
	getBooks(0);
})

//// JS pour la page cart

// Remove from Cart

$(".removeFromCart").on('click',function(event){
	event.preventDefault();
	var that = $(this);
	var path = that.attr('href');
	$.ajax({
		url: path,
	})
	.done(function(){
		that.parents('tr').fadeOut(200);
		countBooksInCart();
	});

})

//// A l'ouverture de la page

$(window).on("load", function(){
	countBooksInCart();
	getBooks(0);
})