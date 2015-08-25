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

$(window).on("load", function(){
	getBooks(0);
})

$('.checkbox').on('click', function(e){
	getBooks(0);
})

$('#btnNumber').on('click', function(e){
	e.preventDefault();
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
})


$("#keyword").on('keyup', function(){
	var keyword = $('#keyword').val();
	console.log(keyword);
	var path = $('#keyword').attr('data');
	console.log(path);
	if (keyword.length < 2){
		$('#result').html('');
	}
	else{

		$.ajax({
			url : path,
			data : {
			'keyword' : $('#keyword').val(),
			}

		}).done(function(response){
			$('#result').html(response);
			
		});	
	}
});
