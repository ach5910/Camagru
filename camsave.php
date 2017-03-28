<?php
session_start();
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
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
        // creating a cut resource 
        $cut = imagecreatetruecolor($src_w, $src_h); 

        // copying relevant section from background to the cut resource 
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 
        
        // copying relevant section from watermark to the cut resource 
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h); 
        
        // insert cut resource to destination image 
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);

        $timestamp = date('YmdHis');
        $img_file = './private/user_images/'.$_SESSION['loggedIn'].'/'.$timestamp.'.png';
        @mkdir('./private/user_images/'.$_SESSION['loggedIn']);
        imagepng($dst_im, $img_file);
        imagedestroy($dst_im);
        imagedestroy($src_im);
        return $img_file;
}
if ($_POST['imgBase64'] !== '' && is_numeric($_POST['filter']))
{
	$filterImage = array('./images/rainbow.png', 'images/grass.png', 'images/clouds.png', 'images/vines.png');
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
	$src = @imagecreatefrompng($filterImage[$_POST['filter']]);
	$dest = @imagecreatefrompng('imagetaken.png');
	$new_img = imagecopymerge_alpha($dest, $src,  0, 0, 0, 0, 320, 240, 100);
	echo $new_img;

	// list($width, $height) = getimagesize('imagetaken.png');

	// if ($dest && $src)
	// {
	// 	// imagealphablending($dest, true);
	// 	// imagesavealpha($src, true);
	// 	imagealphablending($dest, false);
	// 	imagesavealpha($dest, true);
	// 	// Copy and merge
	// 	imagecopymerge($src, $dest,   0, 0, 0, 0, 320, 240, 0);

	// 	// Output and free from memory
	// 	// header('Content-Type: image/png');
	// 	imagepng($src, 'merged.png');

	// 	imagedestroy($dest);
	// 	imagedestroy($src);
	// 	echo 'Success';
	// }
	// else
	// {
	// 	if (!$dest)
	// 		echo 'Fail dest';
	// 	if (!$src)
	// 		echo 'Fail src';
	// }
} 
?>