<?php
session_start();
include 'setup.php';
include 'database.php';
// function is_liked_by_user($img){
// 	if (array_key_exists($_SESSION['name'], $img) &&
// 		array_key_exists($_SESSION['file'], $img[$_SESSION['name']]) &&
// 		array_key_exists('like', $img[$_SESSION['name']][$_SESSION['file']]) &&
// 		array_key_exists($_SESSION['loggedIn'], $img[$_SESSION['name']][$_SESSION['file']]['like']))
// 	{
// 		return TRUE;
// 	}
// 	return FALSE;
// }
if ($_POST['like'] === 'like')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$db->toggle_like($_SESSION['img_id'], $_SESSION['loggedIn'], $_SESSION['name']);
	$db = null;
	// if (file_exists('private/image_data'))
	// 	$img = unserialize(file_get_contents('private/image_data'));
	// else
	// 	$img = array();
	// if (is_liked_by_user($img)) 
	// {
	// 	echo 'if';
	// 	unset($img[$_SESSION['name']][$_SESSION['file']]['like'][$_SESSION['loggedIn']]);
	// }
	// else
	// {
	// 	echo 'else';
	// 	$img[$_SESSION['name']][$_SESSION['file']]['like'][$_SESSION['loggedIn']] = $_SESSION['loggedIn'];
	// }
	// echo $img[$_SESSION['name']][$_SESSION['file']]['like'][$_SESSION['loggedIn']];
	// @mkdir('private');
	// file_put_contents("private/image_data", serialize($img));
}
?>