<?php
session_start();
include 'setup.php';
include 'database.php';

if ($_POST['submit'] === 'comment_set' && $_POST['img_name'] !== '')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$comments = $db->get_comment_info_str_by_path($_POST['img_name']);
	$db = null;
	echo $comments;
}
?>