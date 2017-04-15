<?php
session_start();
include 'database.php';
include ('setup.php');
if ($_POST['submit'] === 'OK')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$img = $db->get_image_by_path($_SESSION['img_src']);
	$image .= $_SESSION['img_src'].'-'.$db->get_like_count($img['id'])."-".
	$db->get_comment_count($img['id']).'-'.$db->get_user_name($img['user_id'])
	.'-'.$img['id'].'-';
	if ($db->liked_by_user($img['id'], $_SESSION['loggedIn']))
		$image .="1\n";
	else
		$image .="0\n";
	$db= null;
	echo $image;
}
?>