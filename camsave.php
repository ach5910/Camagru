<?php
session_start();
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
	$fp = fopen('imagetaken.png', 'w+');
	fwrite($fp, $unencoded);
	fclose($fp);
	$src = @imagecreatefrompng($filterImage[$_POST['filter']]);
	$dest = @imagecreatefrompng('imagetaken.png');
	$new_img = imagecopymerge_alpha($dest, $src,  0, 0, 0, 0, 320, 240, 100);
	echo $new_img;
}
?>