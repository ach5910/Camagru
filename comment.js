var likes, comments;
document.body.onload = initUserFeedback;

function initUserFeedback(){
	likes = document.getElementById('like-list');
	comments = document.getElementById('user-feedback');
	getComments();
	getLikeCount();
	getLikedBy();
	
	
}

function getComments(){
	$.ajax({
		url:'get_comments.php',
		type: 'post',
		dataType: 'text',
		data: {
			'submit': 'comment_set'
		},
		success: function(response){
			console.log('parseComments');
			console.log(response);
			parseComments(response);
			
		}
	})
}

function parseComments(comments){
	if(comments.length > 0){
		var comArray = comments.split("\n");
		for (c in comArray){
			if (comArray[c].indexOf(';') !== -1 && comArray[c].length > 0)
			{
				var comContent = comArray[c].split(';');
				addCommentDiv(comContent[0], comContent[1]);
			}
		}
	}
}

function addCommentDiv(authAndDate, content){
	var commentBox = document.createElement('div');
	var timeStamp = document.createElement('em');
	var lineBreak = document.createElement('hr');
	var spaceBreak = document.createElement('br');
	var commentPara = document.createElement('p');
	var commentContext = document.createElement('strong');
	commentBox.style.backgroundColor = 'white';
	commentBox.style.width = '75%';
	timeStamp.innerHTML = authAndDate;
	commentContext.innerHTML = content;
	commentContext.style.margin = "2vw";
	commentPara.insertBefore(commentContext, commentPara.firstChild);
	commentBox.insertBefore(commentPara, commentBox.firstChild);
	commentBox.insertBefore(lineBreak, commentBox.firstChild);
	commentBox.insertBefore(timeStamp, commentBox.firstChild);
	insertAfter(spaceBreak, comments.firstChild);
	insertAfter(commentBox, comments.firstChild);

}
function makeComment(){
	var comment = prompt('Enter Comment:', '');
	if (comment != null && comment !== ''){
		addComment(comment);
	}
}

function like(){
	$.ajax({
		url:'like.php',
		type: 'post',
		dataType: 'text',
		data: {
			'like': 'like'
		},
		success: function(response){
			getLikeCount();
			getLikedBy();
			console.log(response);
		}
	})
}

function getLikeCount(){
	$.ajax({
		url:'get_like_count.php',
		type: 'post',
		dataType: 'text',
		data: {
			'submit': 'like_count'
		},
		success: function(response){
			console.log('getLikeCount');
			console.log(response);
			updateLikeCount(response);
			console.log(response);
		}
	})
}

function updateLikeCount(like_count){
	console.log(likes);
	likes.innerHTML = "Likes - " + like_count;
}

function getLikedBy(){
	$.ajax({
		url:'get_liked_by.php',
		type: 'post',
		dataType: 'text',
		data: {
			'submit': 'liked_by'
		},
		success: function(response){
			parseLikes(response);
			console.log(response);
		}
	})
}

function parseLikes(liked_by){
	if(liked_by.length > 0){
		var likeArray = liked_by.split("\n");
		for (l in likeArray){
			if (likeArray[l].length > 0)
			{
				addLikedByDiv(likeArray[l]);
			}
		}
	}
}

function insertAfter(el, referenceNode) {
    referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
}

function addLikedByDiv(liked_by){
	var likedByUser = document.createElement('div');
	likedByUser.setAttribute('id', liked_by);
	likedByUser.innerHTML = liked_by;
	likedByUser.style.margin = '2vw';
	console.log(likedByUser);
	insertAfter(likedByUser, likes.firstChild); 
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
			parseComments(response);
			console.log(response);
		}
	})
}