<?php
session_start();
include ('setup.php');
include 'database.php';
if ($_POST['submit'] === 'Log Out')
{
	$_SESSION['loggedIn'] = '';
	$_SESSION['detail'] = FALSE;
	header('Location: login.php');	
}
$_SESSION['detail'] = TRUE;
if ($_SESSION['img_src'] !== '')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$img_data = $db->get_image_by_path($_SESSION['img_src']);
	$_SESSION['user_id'] = $img_data['user_id'];
	$_SESSION['name'] = $db->get_user_name($img_data['user_id']);
	$_SESSION['img_id'] = $img_data['id'];
	$file = $img_data['img_name'];
	$db = null;
	$_SESSION['file'] = $file;
	$y = substr($file, 0, 4);
	$m = substr($file, 4, 2);
	$d = substr($file, 6, 2);
	$_SESSION['date'] = $m.'/'.$d.'/'.$y;
}
?>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='gallery.css'/>
</head>
<body>
	<?php include'nav.html';?>
		<div class='main'>
			<div class='title'><h1> Detail View </h1></div>
			<div class='main-container' id='main-container'>
			</div>
			<button onclick='deleteImage()'>Delete</button>
			<script type="text/javascript" src='gallery.js'></script>

		</div>
		<div>Footer</div>
</body>
</html>