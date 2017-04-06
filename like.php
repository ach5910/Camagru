<?php
session_start();
include 'setup.php';
include 'database.php';
include 'email.php';

if ($_POST['like'] === 'like')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$db->toggle_like($_SESSION['img_id'], $_SESSION['loggedIn'], $_SESSION['name']);
	if ($db->liked_by_user($_SESSION['img_id'], $_SESSION['loggedIn']))
	{
		$email = $db->get_user_email($_SESSION['user_id']);
		send_liked_email($_SESSION['file'], $_SESSION['name'], $email, $_SESSION['loggedIn']);
	}
	$db = null;
}
?>