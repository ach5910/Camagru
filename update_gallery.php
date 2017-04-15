<?php
session_start();
include 'database.php';
include ('setup.php');

function sort_by_image($str1, $str2){
	$s1 = substr(strrchr($str1, '/'), 1);
	$s2 = substr(strrchr($str2, '/'), 1);
	return (strcmp($s2, $s1));
}

if ($_POST['submit'] === 'OK')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$img_array = $db->populate_main_gallery();
	
	usort($img_array, 'sort_by_image');
	foreach($img_array as $image_file)
	{
		$img = $db->get_image_by_path($image_file);
		$images .= $image_file.'-'.$db->get_like_count($img['id'])."-".
		$db->get_comment_count($img['id']).'-'.$db->get_user_name($img['user_id'])
		.'-'.$img['id'].'-';
		if ($db->liked_by_user($img['id'], $_SESSION['loggedIn']))
			$images .="1\n";
		else
			$images .="0\n";
	}
	$db = null;
	echo $images;
}
?>