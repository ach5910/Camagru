<?php
session_start();
if ($_POST['submit'] === 'OK')
{
	if ($_SESSION['loggedIn'] !== '')
		echo "Yes";
	else
		echo "";
}
?>