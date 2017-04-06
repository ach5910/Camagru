<?php
session_start();
include 'setup.php';
include 'database.php';
// function do_likes_exist($img){
// 	if (array_key_exists($_SESSION['name'], $img) &&
// 		array_key_exists($_SESSION['file'], $img[$_SESSION['name']]) &&
// 		array_key_exists('like', $img[$_SESSION['name']][$_SESSION['file']]))
// 	{
// 		return TRUE;
// 	}
// 	return FALSE;
// }
if($_POST['submit'] === 'liked_by')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$users = $db->get_liked_by($_SESSION['img_id']);
	$db = null;
	echo $users;
	// if (file_exists('private/image_data'))
	// {
	// 	$img = unserialize(file_get_contents('private/image_data'));
	// 	if (do_likes_exist($img))
	// 	{
	// 		foreach ($img[$_SESSION['name']][$_SESSION['file']]['like'] as $user)
	// 		{
	// 			$users .= $user."\n";
	// 		}
	// 	}
	// }
	// echo $users;
}
?>