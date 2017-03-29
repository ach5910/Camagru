var home, gallery;
document.body.onload = init;

function init(){
	home = getElementById('home');
	home.addEventListener('click', function(){redirectHome();});
	gallery = getElementById('gallery');
	gallery.addEventListener('click', function(){redirectGallery();});
}

function redirectHome(){
	location.href = 'index.php';
}

function redirectGallery(){
	location.href = 'login.php';
}