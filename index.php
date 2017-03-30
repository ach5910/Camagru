<?php
session_start();
if ($_POST['submit'] === 'Log Out')
	$_SESSION['loggedIn'] = '';
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === '')
	header('Location: login.php');
if ($_POST['submit'] === 'det')
{
	$_SESSION['img_src'] = $_POST['img_src'];
}
?>

<!DOCTYPE HTML>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='index.css'/>
    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
</head>
<body>
	<?php include'nav.html';?>
	<div class='media'>
		<div class='main-content'>
			<div class='filter-container'>
				<form>
					<div class='filter'>
						<img style='width: 7vw; min-width: 60px;height: auto;border: solid;' src="images/rainbow.png">
						<input type='radio' name='filter' value='0' checked>
					</div>
					<div class='filter'>
						<img style='width: 7vw;min-width: 60px;height: auto;border: solid;' src="images/grass.png">
						<input type='radio' name='filter' value='1'>
					</div>
					<div class='filter'>
						<img style='width: 7vw;min-width: 60px;height: auto;border: solid;' src="images/clouds.png">
						<input type='radio' name='filter' value='2'>
					</div>
					<div class='filter'>
						<img style='width: 7vw;min-width: 60px;height: auto;border: solid;' src="images/vines.png">
						<input type='radio' name='filter' value='3'>
					</div>
				</form>
			</div>
			<div class="webcam">
				<video id="video" style='display: none;' autoplay></video>
				<canvas id="canvas" style='width:320px; height:240px;'></canvas>
			</div>
			<div class='webcam-action'>
                <button id="start" onclick="onLoad()">Start</button>
                <button id="snapshot" onclick="takeSnap()">Snapshot</button>
                <button id="save" onclick="save()">Save</button>
			</div>
			
		</div>
		<div class='side-bar' id='side-bar'>
		</div>
		<script src='webcam.js'></script>
	</div>
</body>
</html>