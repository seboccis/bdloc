function showBooks(response){
	$('#showBooks').html(response);
}

function showRequestFailed(){
	$('#showBooks').html('<span>La requête a échoué</span>');
}

function getBooks(){
	var path = $('.container').attr('value');
	$.ajax({
		url: path
	})
	.done(showBooks)
	.fail(showRequestFailed);
}

function getBooksByGenres(){

	var path = $('.container').attr('value');
	$.ajax({
		url: path,
		data: $('#formChooseGenres').serialize(),
		type: "POST",
	})
	.done(showBooks)
	.fail(showRequestFailed);
}


$(window).on("load", getBooks);

$('#buttonChooseGenres').on('click', function(e){
	e.preventDefault();

	getBooksByGenres();
})