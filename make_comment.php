<?php
session_start();
if ($_POST['comment'] !== '')
{
	if (file_exists('private/image_data'))
		$img = unserialize(file_get_contents('private/image_data'));
	else
		$img = array();
	$img[$_SESSION['name']][$_SESSION['file']]['comments'][] = array('content' => $_POST['comment'],
		'author' => $_SESSION['loggedIn'], 'date' => date('m-d-Y'));
	@mkdir('private');
	file_put_contents("private/image_data", serialize($img));
	echo $_SESSION['loggedIn'].': '.date('m-d-Y').';'.$_POST['comment']."\n";
}
?>