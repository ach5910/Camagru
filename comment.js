var likes, comments, likedby;
document.body.onload = initUserFeedback;

function initUserFeedback(){
	comments = document.getElementById('comment-list');
	likes = document.getElementById('user-feedback');
	likedby = document.getElementById('liked_by');
	getComments();
	getLikeCount();
	getLikedBy();
}

function loadDoc(url, data, myFunction){
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
    if (xhr.readyState == 4 && xhr.status == 200){
      console.log(xhr.responseText);
      myFunction(xhr.responseText);
    }
  };
  xhr.open('POST', url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
}

function getComments(){
	loadDoc('get_comments.php', 'submit=comment_set', parseComments);
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
	commentBox.style.width = '340px';
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
	loadDoc('like.php', 'like=like', console.log);
	likedby.innerHTML = "";
	getLikeCount();
	getLikedBy();
}

function getLikeCount(){
	loadDoc('get_like_count.php', 'submit=like_count', updateLikeCount);
}

function updateLikeCount(like_count){
	console.log(likes);
	likes.innerHTML = "Likes - " + like_count;
}

function getLikedBy(){
	loadDoc('get_liked_by.php', 'submit=liked_by', parseLikes);
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
	if (likedby.innerHTML.length > 0)
		likedby.innerHTML = likedby.innerHTML + ", " + liked_by;
	else
		likedby.innerHTML = liked_by;
}

function addComment(comment){
	loadDoc('make_comment.php', 'comment=' + comment, parseComments);
}