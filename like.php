<?php
session_start();
include 'setup.php';
include 'database.php';
include 'email.php';

if ($_POST['like'] === 'like' && $_POST['img_id'] !== '')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$db->toggle_like($_POST['img_id'], $_SESSION['loggedIn']);
	if ($db->liked_by_user($_POST['img_id'], $_SESSION['loggedIn']))
	{
		$img = $db->get_image($_POST['img_id']);
		$email = $db->get_user_email($img['user_id']);
		send_liked_email($img['img_name'], $db->get_user_name($img['user_id']), $email, 
			$_SESSION['loggedIn']);
	}
	$db = null;
}
else
?>