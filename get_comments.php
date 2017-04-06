<?php
session_start();
include 'setup.php';
include 'database.php';

if ($_POST['submit'] === 'comment_set')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$comments = $db->get_comment_info_str($_SESSION['img_id']);
	$db = null;
	echo $comments;
}
?>