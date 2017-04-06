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

function redirectGallery(){
	window.location.href = 'gallery.php';
}