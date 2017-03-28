<?php
function merge($filename_x, $filename_y, $filename_result) {

	// Get dimensions for specified images

	list($width_x, $height_x) = getimagesize($filename_x);
	list($width_y, $height_y) = getimagesize($filename_y);

	// Create new image with desired dimensions

	$image = imagecreatetruecolor($width_y, $height_y);
	// $image = imagecreatetruecolor($width_x + $width_y, $height_x);

	// Load images and then copy to destination image

	$image_x = imagecreatefrompng($filename_x);
	$image_y = imagecreatefrompng($filename_y);

	// imagecopy($image, $image_x, 0, 0, 0, 0, $width_x, $height_x);
	// imagecopy($image, $image_y, $width_x, 0, 0, 0, $width_y, $height_y);
	imagecopy($image, $image_y, 0, 0, 0, 0, $width_y, $height_y);
	imagecopy($image, $image_x, 0, 0, 0, 0, $width_x, $height_x);
	

	// Save the resulting image to disk (as JPEG)
	$ret = FALSE;
	if (imagepng($image, $filename_result))
		$ret = TRUE;

	// Clean up

	imagedestroy($image);
	imagedestroy($image_x);
	imagedestroy($image_y);
	return $ret;

}
if ($_POST['imgBase64'] !== '' && is_numeric($_POST['filter']))
{
	$filterImage = array('./images/Dora.png', 'images/Mario.png', 'images/clouds.png', 'images/vines.png');
	$filteredData = explode(',', $_POST['imgBase64']);
	$unencoded = base64_decode($filteredData[1]);
	// $randomName = rand(0, 99999);
	//Create image

	// if (file_exists('private/user_images'))
	// {
	// 	$accounts  = unserialize(file_get_contents("private/user_images"));
	// }
	// else{
	// 	$accounts = array();
	// }
	// $accounts[$_SESSION['loggedIn']][] = $randomName.'.png';
	// file_put_contents("private/user_images", serialize($accounts));
	$fp = fopen('imagetaken.png', 'w+');
	fwrite($fp, $unencoded);
	fclose($fp);
	
	// if (merge('./images/Dora.png', 'imagetaken.png', 'merged.png'))
	// 	echo 'Success';
	// else
	// 	echo 'Fail';
	// Create image instances
	$dest = @imagecreatefrompng($filterImage[$_POST['filter']]);
	$src = @imagecreatefrompng('imagetaken.png');
	list($width, $height) = getimagesize('imagetaken.png');

	if ($dest && $src)
	{
		imagealphablending($dest, false);
		imagesavealpha($dest, true);
		// Copy and merge
		imagecopymerge($src,$dest,   0, 0, 0, 0, 320, 240, 100);

		// Output and free from memory
		// header('Content-Type: image/png');
		imagepng($src, 'merged.png');

		imagedestroy($dest);
		imagedestroy($src);
		echo 'Success';
	}
	else
	{
		if (!$dest)
			echo 'Fail dest';
		if (!$src)
			echo 'Fail src';
	}
} 
?>