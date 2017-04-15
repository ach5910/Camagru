<?php
session_start();
if ($_POST['submit'] === 'Log Out')
{
	$_SESSION['loggedIn'] = '';
	header('Location: login.php');	
}
$_SESSION['detail'] = FALSE;
if ($_POST['submit'] === 'det')
	$_SESSION['img_src'] = $_POST['img_src'];
?>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='gallery.css'/>
	
</head>
<body>
	<?php include'nav.html';?>
		<div class='main'>
			<div class='title'><h1> Gallery </h1></div>
			<div class='main-container' id='main-container'>
			</div>
			<script type="text/javascript" src='gallery.js'></script>
		</div>
	<div class='pagify'>
		<div class='prev' onclick='decrementIndex()'><p>&#9664; PREVIOUS </p></div>
		<div class='next' onclick='incrementIndex()'><p>NEXT &#9654;</p></div>
		<script type="text/javascript" src='gallery.js'></script>
	</div>
</body>
</html>