var gallery = document.getElementById('side-bar');
document.body.onload = getGallery;

function getGallery(){
	$.ajax({
		url: 'update_gallery.php',
		type: 'post',
		dataType: 'text',
		data: {
			'submit': 'OK'
		},
		success: function(response){
			console.log(response);
			populateGallery(response);
		}
	});
};

function populateGallery(imgData){
	if (imgData.length > 0){
		var imgArray = imgData.split("\n");
		for (img in imgArray){
			addImage(imgArray[img]);
		}
	}
};

function addImage(img_file){
	console.log(img_file);
	var img = document.createElement('img');
	img.setAttribute('src', img_file);
	img.style.width = (320 / 2) + "px";
	img.style.height = (240 / 2) +"px";
	gallery.insertBefore(img, gallery.firstChild);
};