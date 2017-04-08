var gallery, imgIndex, gallerySize;
document.body.onload = init;

function init(){
	gallery = document.getElementById('main-container');
	imgIndex = 0;
	getGallery();
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

function incrementIndex(){
	if (imgIndex + 12 < gallerySize){
		imgIndex += 12;
    console.log(imgIndex);
    console.log(gallerySize);
		clearImagesFromPage();
		getGallery();
	}
}

function clearImagesFromPage(){
	while(gallery.firstChild){
		gallery.removeChild(gallery.firstChild);
	}
}

function decrementIndex(){
	if (imgIndex - 12 >= 0){
		imgIndex -= 12;
		clearImagesFromPage();
		getGallery();
	}
	
}
function getGallery(){
	loadDoc('update_gallery.php', 'submit=OK', populateGallery);
}

function populateGallery(imgData){
  if (imgData.length > 0){
    var imgArray = imgData.split("\n");
    console.log(imgIndex);
    gallerySize = imgArray.length - 1;
    for (img = imgIndex; img < imgIndex + 12 && img < imgArray.length; img++){
      if (imgArray[img].length > 0)
        addImage(imgArray[img]);
    }
  }
}

function addImage(img_file){
  console.log(img_file);
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
  text.setAttribute('class', 'form-control');
  text.setAttribute('placeholder', 'Textarea');
  n1.setAttribute('class','badge');
  n2.setAttribute('class','badge');
  n1.textContent = '10';
  n2.textContent = '25';
  s1.textContent = 'like';
  s2.textContent = 'comment';
  s1.appendChild(n1);
  s2.appendChild(n2);
  like.appendChild(s1);
  like.appendChild(s2);
  he.textContent = 'author';
  title.appendChild(he);
  title.setAttribute('class','car-title');
  like.setAttribute('class', 'card-like');
  card.setAttribute('class', 'card');
  img.setAttribute('src', img_file);
  img.setAttribute('class', 'user_image');
  img.addEventListener('click', function(){detailView(this);}, false);
  img.style.width = '480px';
  img.style.height = '400px';
  card.appendChild(title);
  card.appendChild(img);
  card.appendChild(like);
  
  card.appendChild(text);
  gallery.appendChild(card);
}

function detailView(img_tag){
  var src = img_tag.getAttribute("src");
  loadDoc('gallery.php', 'submit=det&img_src=' + encodeURIComponent(src), console.log);
  window.location.href = 'detail_view.php';
}