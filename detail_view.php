<?php
session_start();
if ($_SESSION['img_src'] !== '')
{
	$img_path = explode('/', $_SESSION['img_src']);
	$_SESSION['name'] = $img_path[3];
	$file = $img_path[4];
	$_SESSION['file'] = $file;
	$y = substr($file, 0, 4);
	$m = substr($file, 4, 2);
	$d = substr($file, 6, 2);
	$_SESSION['date'] = $m.'/'.$d.'/'.$y;
}
?>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='detail_view.css'/>
    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
</head>
<body>
	<?php include'nav.html';?>
	<div class='middle'>
		<div class='image-content'>
			<div class='image-data' >
				<?php
				if (isset($_SESSION['name']) && $_SESSION['name'] !== '')
				{
					echo "<strong>".$_SESSION['name']."</strong>";
					echo "<strong>".$_SESSION['date']."</strong>";
				}
				?>
			</div>
			<div class="image-src">
				<?php
				echo "<img src='".$_SESSION['img_src']."' style='width: 480px;height: 360px;'>";
				?>
			</div>
			<div class='comment-container'>
				<div class='user-feedback' id='user-feedback'>
				</div>
				<br>
				<?php
				if ($_SESSION['loggedIn'])
				{
				?>
				<button id="Comment" onclick="makeComment()">Comment</button>
				<button id="Like" onclick="like()">Like</button>
				<?php
				}
				?>
				<script type="text/javascript" src='comment.js'></script>
			</div>
		</div>
		<div class='comment-list' id='comment-list'><h2>Comments</h2>
		</div>
	</div>
</body>
</html>