<?php
session_start();
function do_likes_exist($img){
	if (array_key_exists($_SESSION['name'], $img) &&
		array_key_exists($_SESSION['file'], $img[$_SESSION['name']]) &&
		array_key_exists('like', $img[$_SESSION['name']][$_SESSION['file']]))
	{
		return TRUE;
	}
	return FALSE;
}
if($_POST['submit'] === 'liked_by')
{
	$users = '';
	if (file_exists('private/image_data'))
	{
		$img = unserialize(file_get_contents('private/image_data'));
		if (do_likes_exist($img))
		{
			foreach ($img[$_SESSION['name']][$_SESSION['file']]['like'] as $user)
			{
				$users .= $user."\n";
			}
		}
	}
	echo $users;
}
?>