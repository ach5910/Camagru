<?php
session_start();
include 'database.php';
include 'setup.php';

if ($_POST['img_path'] !== '')
{
	$file_name = substr(strrchr($_POST['img_path'], '/'), 1);
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$db->add_image($file_name, $_POST['img_path'], $_SESSION['loggedIn']);
	$db = null;
	echo $_POST['img_path'];
}
?>