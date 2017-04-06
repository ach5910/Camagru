<?php
session_start();
include 'setup.php';
include 'database.php';
if ($_POST['submit'] === 'OK')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$img_array = $db->populate_user_gallery($_SESSION['loggedIn']);
	$db = null;
	sort($img_array);
	foreach($img_array as $image_file)
		$images .= $image_file;
	echo $images;
}
?>