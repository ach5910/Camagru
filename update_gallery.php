<?php
session_start();
function sort_by_image($str1, $str2){
	$s1 = substr(strrchr($str1, '/'), 1);
	$s2 = substr(strrchr($str2, '/'), 1);
	return (strcmp($s2, $s1));
}
if ($_POST['submit'] === 'OK')
{
	$users_dir = './private/user_images/';
	$images = '';
	$img_array = array();
	if(file_exists($users_dir))
	{
		$dir = new DirectoryIterator($users_dir);
		foreach($dir as $user)
		{
			if(!$user->isDot())
			{
				
				$user_dir = new DirectoryIterator('./private/user_images/'.$user);
				foreach ($user_dir as $img)
				{
					if (!$img->isDot())
						$img_array[] = './private/user_images/'.$user.'/'.$img."\n";
				}
			}
		}
		usort($img_array, 'sort_by_image');
		foreach($img_array as $image_file)
			$images .= $image_file;
	}
	echo $images;
}
?>