<?php
session_start();
include 'setup.php';
include 'database.php';

if($_POST['submit'] === 'like_count')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$size = $db->get_like_count($_SESSION['img_id']);
	$db = null;
	echo $size;
}
?>