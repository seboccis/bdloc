//// JS pour toutes les pages dépendant de main_layout

function showCount(response)
{
	$('#numberBooksInCart').html(response);
	$('#showNumberBooksInCart').html(response);

	if(response == 10){
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

// Ajouter au panier

$('#showDetail').on('click', '.addToCart', function(event){
	event.preventDefault();
	$(this).fadeOut(500);
	var path = $(this).attr('href');
	var bookId = $(this).attr('data-bookIdToCart');
	$('#numberBooksInCart').fadeIn(500);
	$.ajax({
		url: path,
		data: {
			id: bookId,
		}
	})
	.done(function(response){
		countBooksInCart();
		$('#cartError').html(response);
		var start = $('#showBooks > #dataRequest').attr('data-request-first') - 1;
		getBooks(start);
	});
})

$('#showBooks').on('click', '.addToCart', function(event){
	event.preventDefault();
	var path = $(this).attr('href');
	var bookId = $(this).attr('data-bookIdToCart');
	$('#numberBooksInCart').fadeIn(500);
	$.ajax({
		url: path,
		data: {
			id: bookId,
		}
	})
	.done(function(response){
		countBooksInCart();
		$('#cartError').html(response);
		var start = $('#showBooks > #dataRequest').attr('data-request-first') - 1;
		getBooks(start);
	});
})
		
// Fin de la fonction

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


$('.checkbox').on('click', function(e){
	getBooks(0);
})

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

$('#selectCatalogSort').on('change', function(e){
  	e.preventDefault();
	getBooks(0);
})

$('#selectCatalogNumber').on('change', function(e){
  	e.preventDefault();
	getBooks(0);
})


// Afficher le détail de la BD sélectionnée avec une light-box
$("#showBooks").on("click", ".detail", function(e){
	e.preventDefault();

	var path = $('#showDetail').attr('data-ajax-catalog-detail-path');
	

	$.ajax({
		url: path,
		data: {
			id: $(this).attr('value'),
		}
	})
	.done(function(response){
		$('#showDetail').html(response);
	})
		$('#shadow').fadeIn(200);
		$('#showDetail').fadeIn(200);
		e.stopPropagation();
	$('#showDetail').on("click",function(e){
		e.stopPropagation();
	});
	$('#showDetail').on("click", '#btn',function(e){
		$('#showDetail').fadeOut(200);
		$('#shadow').fadeOut(200);
		e.stopPropagation();
	});
	$('html').on("click",function(e){
		$('#shadow').fadeOut(200);
		e.stopPropagation();
	});

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
			$('#resultKeywordResearch').html(response);			
		});	
	}
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

$('#order').on('click',function(e){
	var path = $('#showOrder').attr('data-ajax-order-path');
	e.preventDefault();
	$.ajax({
		url: path,
	}).done(function(response){
		$('#showOrder').html(response);
	});
	$('#shadow').fadeIn(200);
		$('#showOrder').fadeIn(200);
		e.stopPropagation();
	$('#showOrder').on("click",function(e){
		e.stopPropagation();
	});
	$('#showOrder').on("click", '#btn',function(e){
		$('#showOrder').fadeOut(200);
		$('#shadow').fadeOut(200);
		e.stopPropagation();
	});
	$('html').on("click",function(e){
		$('#shadow').fadeOut(200);
		e.stopPropagation();
	});
});

//// A l'ouverture de la page

$(window).on("load", function(){
	countBooksInCart();
	getBooks(0);
})