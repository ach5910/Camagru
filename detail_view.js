var gallery, imgIndex, gallerySize, currentCard;
document.body.onload = init;

function init(){
	gallery = document.getElementById('main-container');
	imgIndex = 0;
	getImage();
}

function insertAfter(el, referenceNode) {
    referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
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

function loadDocImage(url, data, myFunction, image_name){
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
    if (xhr.readyState == 4 && xhr.status == 200){
      console.log("image_name = " + image_name);
      myFunction(xhr.responseText, image_name);
    }
  };
  xhr.open('POST', url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
}
function incrementIndex(){
	if (imgIndex + 10 < gallerySize){
		imgIndex += 10;
    console.log(imgIndex);
    console.log(gallerySize);
		clearImagesFromPage();
		getGallery();
    document.body.scrollTop = document.documentElement.scrollTop = 0;
	}
}

function clearImagesFromPage(){
	while(gallery.firstChild){
		gallery.removeChild(gallery.firstChild);
	}
}

function decrementIndex(){
	if (imgIndex - 10 >= 0){
		imgIndex -= 10;
		clearImagesFromPage();
		getGallery();
    document.body.scrollTop = document.documentElement.scrollTop = 0;
	}
	
}
function getGallery(){
	loadDoc('update_gallery.php', 'submit=OK', populateGallery);
}

function getImage(){
  loadDoc('get_image_data.php', 'submit=OK', populateGallery);
}
function populateGallery(imgData){
  if (imgData.length > 0){
    var imgArray = imgData.split("\n");
    console.log(imgIndex);
    gallerySize = imgArray.length - 1;
    for (img = imgIndex; img < imgIndex + 10 && img < imgArray.length; img++){
      if (imgArray[img].length > 0)
      {
        var imgDetails = imgArray[img].split('-');
        addImage(imgDetails[0], imgDetails[1], imgDetails[2],
          imgDetails[3], imgDetails[4], imgDetails[5]);
      }
    }
  }
}

function addImage(img_file, like_count, comment_count, name, id, is_liked){
  var img = document.createElement('img');
  var card = document.createElement('div');
  var title = document.createElement('div');
  var like = document.createElement('div');
  var he = document.createElement('h2');
  var s1 = document.createElement('a');
  var s2 = document.createElement('a');
  var n1 = document.createElement('span');
  var n2 = document.createElement('span');
  var hr = document.createElement('hr');
  var text = document.createElement('textarea');
  var form = document.createElement('div');
  var c_btn = document.createElement('button');
  var liked_img = document.createElement('span');
  card.setAttribute('id', id);
  liked_img.setAttribute('class', 'liked-img');
  liked_img.addEventListener('click', function(){toggleLike(card);}, false);
  c_btn.addEventListener('click', function(){addComment(card);}, false);
  if (is_liked > 0)
  {
    liked_img.setAttribute('id', '1');
    liked_img.innerHTML = "&#x2665;";
  }
  else
  {
    liked_img.setAttribute('id', '0')
    liked_img.innerHTML = "&#x2661;";
  }
  c_btn.innerHTML = '+';
  form.setAttribute('class', 'like-comment-form');
  // form.appendChild(l_btn);
  // form.appendChild(c_btn);
  var commentBox = document.createElement('div');
  text.setAttribute('class', 'form-control');
  text.setAttribute('placeholder', 'Add comment...');
  form.appendChild(text);
  form.appendChild(c_btn);
  n1.setAttribute('class','badge');
  n2.setAttribute('class','badge');
  n1.textContent = like_count;
  n2.textContent = comment_count;
  s1.textContent = 'likes';
  s2.textContent = 'comments';
  s1.appendChild(n1);
  s2.appendChild(n2);
  like.appendChild(s1);
  like.appendChild(s2);
  he.textContent = name;
  title.appendChild(he);
  title.setAttribute('class','car-title');
  like.setAttribute('class', 'card-like');
  card.setAttribute('class', 'card');
  commentBox.setAttribute('id', img_file);
  commentBox.style.width = "100%";
  img.setAttribute('src', img_file);
  img.setAttribute('class', 'user_image');
  img.addEventListener('click', function(){viewCard(card);}, false);
  img.style.width = '480px';
  img.style.height = '400px';
  card.appendChild(title);
  card.appendChild(img);
  card.appendChild(liked_img);
  card.appendChild(like);

  card.appendChild(commentBox);
  if (comment_count > 0)
    getImageComments(img_file);
  // card.appendChild(text);
  card.appendChild(form);
  gallery.appendChild(card);
  
}

function viewCard(card){
  console.log(card);
}

function getImageComments(img_name){
  console.log('getImageComments');
  loadDocImage('get_image_comments.php', 'submit=comment_set&img_name=' + img_name, parseComments, img_name);
}

function parseComments(comments, image_name){
  if(comments.length > 0){
    var comArray = comments.split("\n");
    for (c in comArray){
      if (comArray[c].indexOf(';') !== -1 && comArray[c].length > 0)
      {
        var comContent = comArray[c].split(';');
        var name = comContent[0].split(':');
        addCommentDiv(name[0], comContent[1], image_name);
      }
    }
  }
}

function toggleLike(card){
  loadDoc('like.php', 'like=like', console.log);
  var count = 1;
  if (card.childNodes[2].getAttribute('id') == "0")
  {
    card.childNodes[2].setAttribute('id', '1');
    card.childNodes[2].innerHTML = "&#x2665;";
  }
  else
  {
    card.childNodes[2].setAttribute('id', '0');
    card.childNodes[2].innerHTML = "&#x2661;";
    count *= -1;
  }
  count = parseInt(card.childNodes[3].childNodes[0].childNodes[1].innerHTML) + count;
  card.childNodes[3].childNodes[0].childNodes[1].innerHTML = count;
}

function addComment(card){
  var count;
  var comment = card.childNodes[5].childNodes[0].value;
  card.childNodes[5].childNodes[0].value = '';
  var image_path = card.childNodes[1].getAttribute('src');
  count = parseInt(card.childNodes[3].childNodes[1].childNodes[1].innerHTML) + 1;
  card.childNodes[3].childNodes[1].childNodes[1].innerHTML = count;
  loadDocImage('make_comment.php', 'comment=' + comment + '&path=' + image_path, parseComments, image_path);
}

function addCommentDiv(auth, content, image_name){
  var card = document.getElementById(image_name);
  console.log(image_name);
  console.log(card);
  var commentBox = document.createElement('div');
  var timeStamp = document.createElement('em');
  var lineBreak = document.createElement('hr');
  var spaceBreak = document.createElement('br');
  var commentPara = document.createElement('p');
  var commentContext = document.createElement('strong');
  commentBox.style.backgroundColor = 'white';
  commentBox.style.margin = '2px 15px';
  timeStamp.innerHTML = auth + ":   ";
  commentContext.innerHTML =content;
  // commentContext.style.margin = "2vw";

  // commentPara.insertBefore(commentContext, commentBox.firstChild);
  // commentBox.insertBefore(timeStamp, commentBox.firstChild);
  commentBox.setAttribute('class', 'commentBox');
  commentBox.appendChild(timeStamp);
  commentBox.appendChild(commentContext);
  // commentBox.insertBefore(timeStamp, commentBox.firstChild);
  // insertAfter(spaceBreak, comments.firstChild);
  // insertAfter(commentBox, comments.firstChild);
  card.insertBefore(commentBox, card.firstChild);
}

function insertAfter(el, referenceNode) {
    referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
}
