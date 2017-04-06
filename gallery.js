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
    gallerySize = imgArray.length;
    for (img = imgIndex; img < imgIndex + 12 && img < imgArray.length; img++){
      if (imgArray[img].length > 0)
        addImage(imgArray[img]);
    }
  }
}

function addImage(img_file){
  console.log(img_file);
  var img = document.createElement('img');
  img.setAttribute('src', img_file);
  img.setAttribute('class', 'user_image');
  img.addEventListener('click', function(){detailView(this);}, false);
  img.style.width = '16vw';
  img.style.height = '12vh';
  img.style.margin = '2vw';
  gallery.appendChild(img);
}

function detailView(img_tag){
  var src = img_tag.getAttribute("src");
  loadDoc('gallery.php', 'submit=det&img_src=' + encodeURIComponent(src), console.log);
  window.location.href = 'detail_view.php';
}