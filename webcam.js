
var video, canvas, context, imageData, gallery;
document.body.onload = init;

function init(){
  video = document.getElementById("video");
  canvas = document.getElementById("canvas");
  context = canvas.getContext("2d");
  canvas.width = parseInt(canvas.style.width);
  canvas.height = parseInt(canvas.style.height);
  gallery = document.getElementById('side-bar');
  getGallery();
}
function onLoad(){
  console.log(canvas.height);
  console.log(canvas.width);
  navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia|| navigator.msGetUserMedia || navigator.oGetUserMedia;
  if (navigator.getUserMedia){
    
    function successCallback(stream){
      if (window.URL) {
        video.src = window.URL.createObjectURL(stream);
      } else if (video.mozSrcObject !== undefined) {
        video.mozSrcObject = stream;
      } else {
        video.src = stream;
      }
    }
    function errorCallback(error){
      console.log('Error');
    }
    navigator.getUserMedia({video: true}, successCallback, errorCallback);
    requestAnimationFrame(tick);
  }
}

function takeSnap(){
  video.pause();
}

function tick(){
  requestAnimationFrame(tick);
       if (video.readyState === video.HAVE_ENOUGH_DATA){
    snapshot();
  }
}

function snapshot(){
  context.drawImage(video, 0, 0, canvas.width, canvas.height);
  imageData = context.getImageData(0, 0, canvas.width, canvas.height);
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

function save(){
  var dataUrl = canvas.toDataURL();
  var filterIndex = document.querySelector("input[name=filter]:checked").value;
  loadDoc('camsave.php', 'imgBase64=' + encodeURIComponent(dataUrl) + '&filter=' + filterIndex, update_db);
}

function update_db(img_file){
  loadDoc('image_to_database.php', 'img_path=' + img_file, addImage);
}

function getGallery(){
  loadDoc('update_user_gallery.php', 'submit=OK', populateGallery);
}

function populateGallery(imgData){
  if (imgData.length > 0){
    var imgArray = imgData.split("\n");
    for (img in imgArray){
      if (imgArray[img].length > 0)
        addImage(imgArray[img]);
    }
  }
}

function addImage(img_file){
  console.log(img_file);
  var img = document.createElement('img');
  img.setAttribute('src', img_file);
  img.addEventListener('click', function(){detailView(this);}, false);
  img.style.width = 100 + "px";
  img.style.marginTop = "5px 0px 0px 0px";;
  gallery.insertBefore(img, gallery.firstChild);
}

function detailView(img_tag){
  var src = img_tag.getAttribute("src");
  loadDoc('index.php', 'submit=det&img_src=' + encodeURIComponent(src), console.log);
  window.location.href = 'detail_view.php';
}