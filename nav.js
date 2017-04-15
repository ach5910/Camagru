var home, gallery;
document.body.onload = init;

function init(){
	home = document.getElementById('home');
	gallery = document.getElementById('gallery');
}

function redirectHome(){
	console.log('reHome');
	window.location.href = 'index.php';
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

function redirectGallery(){
	window.location.href = 'gallery.php';
}