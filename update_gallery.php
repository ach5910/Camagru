<?php
session_start();
if ($_POST['submit'] === 'OK')
{
	$user_gallery = './private/user_images/'.$_SESSION['loggedIn'];
	$images = '';
	$img_array = array();
	if(file_exists($user_gallery))
	{
		$dir = new DirectoryIterator($user_gallery);
		foreach($dir as $image_file)
		{
			if(!$image_file->isDot())
			{
				$img_array[] = $user_gallery.'/'.$image_file."\n";
			}
		}
		sort($img_array);
		foreach($img_array as $image_file)
			$images .= $image_file;
	}
	echo $images;
}
?>