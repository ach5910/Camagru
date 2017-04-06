<?php
session_start();
include 'setup.php';
include 'database.php';
include 'email.php';

if ($_POST['comment'] !== '')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$db->add_comment($_SESSION['file'], $_SESSION['name'], $_POST['comment'], 
		$_SESSION['loggedIn'], date('m-d-Y'));
	$email = $db->get_user_email($_SESSION['user_id']);
	send_comment_email($_SESSION['file'], $_SESSION['name'], $email, $_POST['comment'], $_SESSION['loggedIn']);
	$db = null;
	echo $_SESSION['loggedIn'].': '.date('m-d-Y').';'.$_POST['comment']."\n";
}
?>