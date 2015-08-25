function showBooks(response){
	$('#showBooks').html(response);
}

function showRequestFailed(){
	$('#showBooks').html('<span>La requête a échoué</span>');
}

function getBooks(){

	var path = $('.sideBar').attr('data');
	$.ajax({
		url: path,
		data: $('#formChooseGenres').serialize(),
		type: "POST",
	})
	.done(showBooks)
	.fail(showRequestFailed);
}


$(window).on("load", getBooks);

$('.checkbox').on('click', function(e){
	getBooks();
})

$("#showBooks").on("click", ".detail", function(e){
	e.preventDefault();

	var path = $('#showDetail').attr('data');
	

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