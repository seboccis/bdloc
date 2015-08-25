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

$('#buttonChooseGenres').on('click', function(e){
	e.preventDefault();
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


$("#keyword").on('keyup', function(){
	var keyword = $('#keyword').val();
	console.log(keyword);
	var path = $('#keyword').attr('data');
	console.log(path);
	if (keyword.length < 2){
		$('#showBooks').html('');
	}
	else{

		$.ajax({
			url : path,
			data : {
			'keyword' : $('#keyword').val(),
			}

		}).done(function(response){
			$('#showBooks').html(response);
		});	
	}
});