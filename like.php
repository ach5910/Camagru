<?php
session_start();
if ($_POST['like'] === 'like')
{
	if (file_exists('private/image_data'))
		$img = unserialize(file_get_contents('private/image_data'));
	else
		$img = array();
	if (array_key_exists($_SESSION['loggedIn'], $img[$_SESSION['name']][$_SESSION['file']]['like']) && $img[$_SESSION['name']][$_SESSION['file']]['like'][$_SESSION['loggedIn']] === TRUE)
	{
		echo 'if';
		$img[$_SESSION['name']][$_SESSION['file']]['like'][$_SESSION['loggedIn']] = FALSE;
	}
	else
	{
		echo 'else';
		$img[$_SESSION['name']][$_SESSION['file']]['like'][$_SESSION['loggedIn']] = TRUE;
	}
	echo $img[$_SESSION['name']][$_SESSION['file']]['like'][$_SESSION['loggedIn']];
	@mkdir('private');
	file_put_contents("private/image_data", serialize($img));
}
?>