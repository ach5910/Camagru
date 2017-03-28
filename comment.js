function makeComment(){
	var comment = prompt('Enter Comment:', '');
	if (comment != null && comment !== ''){
		addComment(comment);
	}
}

function addComment(comment){
	$.ajax({
		url: 'make_comment.php',
		type: 'post',
		dataType: 'text',
		data: {
			'comment': comment
		},
		success: function(response){
			console.log(response);
		}
	})
}