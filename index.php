<?php
session_start();
if ($_POST['submit'] === 'Log Out')
	$_SESSION['loggedIn'] = '';
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === '')
	header('Location: login.php');

?>

<!DOCTYPE HTML>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='index.css'/>
    
</head>
<body>
	<object type="text/html" data="nav.html"></object>
	<div class='media'>
		<div class='main-content'>
			<div class='filter-container'>
				<form>
					<input type='radio' name='filter' value='#' checked>
					<input type='radio' name='filter' value='#'>
					<input type='radio' name='filter' value='#'>
					<input type='radio' name='filter' value='#'>
				</form>
			</div>
			<div class="webcam">
				<video id="video" style='display: none;' autoplay></video>
				<canvas id="canvas" style='width:320px; height:240px;'></canvas>
			</div>
			<div class='webcam-action'>
				<button id="stop" onclick="stop()">Stop</button>
                <button id="start" onclick="onLoad()">Start</button>
                <button id="snapshot" onclick="takeSnap()">Snapshot</button>
					
			</div>
			<script src="webcam.js"></script>
		</div>
		<div class='side-bar'>
		</div>
	</div>
</body>
</html>