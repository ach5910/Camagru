<?php
session_start();
include 'setup.php';
include 'database.php';

function sort_by_image($str1, $str2){
	$s1 = substr(strrchr($str1, '/'), 1);
	$s2 = substr(strrchr($str2, '/'), 1);
	return (strcmp($s2, $s1));
}

if ($_POST['submit'] === 'OK')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$img_array = $db->populate_main_gallery();
	$db = null;
	usort($img_array, 'sort_by_image');
	foreach($img_array as $image_file)
		$images .= $image_file;
	echo $images;
}
?>