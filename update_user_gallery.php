<?php
session_start();
include 'setup.php';
include 'database.php';
if ($_POST['submit'] === 'OK')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$img_array = $db->populate_user_gallery($_SESSION['loggedIn']);
	$db = null;
	sort($img_array);
	foreach($img_array as $image_file)
		$images .= $image_file;
	echo $images;
	// $user_gallery = './private/user_images/'.$_SESSION['loggedIn'];
	// $images = '';
	// $img_array = array();
	// if(file_exists($user_gallery))
	// {
	// 	$dir = new DirectoryIterator($user_gallery);
	// 	foreach($dir as $image_file)
	// 	{
	// 		if(!$image_file->isDot())
	// 		{
	// 			$img_array[] = $user_gallery.'/'.$image_file."\n";
	// 		}
	// 	}
	// 	sort($img_array);
	// 	foreach($img_array as $image_file)
	// 		$images .= $image_file;
	// }
	// echo $images;
}
?>