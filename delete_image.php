<?php
session_start();
include ('setup.php');
include 'database.php';
if ($_POST['submit'] === 'delete'){
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$db->delete_image($_SESSION['img_id']);
	echo 'Done';
}
?>