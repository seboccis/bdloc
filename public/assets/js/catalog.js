function showBooks(response){
	$('#showBooks').html(response);
}

function showRequestFailed(){
	$('#showBooks').html('<span>La requête a échoué</span>');
}

function getBooks(){

	var path = $('#sideBar').attr('data-ajax-catalog-getBooks-path');
	$.ajax({
		url: path,
		data: $('#formSideBarFilters').serialize()+'&'+$('#formResultsBarFilters').serialize(),				
		type: "POST",
	})
	.done(showBooks)
	.fail(showRequestFailed);
}


$(window).on("load", getBooks);

$('#sideBar').on('click', '.checkbox', function(e){
	getBooks();
})

$('#btnNumber').on('click', function(e){
	e.preventDefault();
	getBooks();
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