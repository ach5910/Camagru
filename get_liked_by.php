<?php
session_start();
include 'setup.php';
include 'database.php';

if($_POST['submit'] === 'liked_by')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$users = $db->get_liked_by($_SESSION['img_id']);
	$db = null;
	echo $users;
}
?>