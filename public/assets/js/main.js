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

			event.stopPropagation();
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
			var bookId = $(this).parent().parent('figure').attr('data-bookId');
			$(this).fadeOut(500);		
			addToCart(bookId);
		});

		$('#lightBox').on("click",function(event){
			event.stopPropagation();
		});

		$('#lightBox').on("click", '#closeLightBox',function(event){
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
				that.parents('tr').fadeOut(200);
				countBooksInCart();
			});
		});

		// Submit Order

		$('#order').on('click',function(e){
			var path = $('#lightBox').attr('data-ajax-submit-order-path');
			e.preventDefault();
			$.ajax({
				url: path,
			}).done(function(response){
				$('#lightBox').html(response);
			});
			$('#shadow').fadeIn(200);
				$('#lightBox').fadeIn(200);
				e.stopPropagation();
		});

		
////// A l'ouverture de la page

$(window).on("load", function(){
	countBooksInCart();
	getBooks(0);
});
