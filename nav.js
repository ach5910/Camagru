var home, gallery;
document.body.onload = init;

function init(){
	home = document.getElementById('home');
	// home.addEventListener('click', function(){});
	gallery = document.getElementById('gallery');
	// gallery.addEventListener('click', function(){redirectGallery();});
}

function redirectHome(){
	console.log('reHome');
	window.location.href = 'index.php';
}

function redirectGallery(){
	window.location.href = 'gallery.php';
}