<?php
session_start();
include 'setup.php';
include 'database.php';
// function do_comments_exist($img){
// 	if (array_key_exists($_SESSION['name'], $img) &&
// 		array_key_exists($_SESSION['file'], $img[$_SESSION['name']]) &&
// 		array_key_exists('comments', $img[$_SESSION['name']][$_SESSION['file']]))
// 	{
// 		return TRUE;
// 	}
// 	return FALSE;
// }
if ($_POST['submit'] === 'comment_set')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$comments = $db->get_comment_info_str($_SESSION['img_id']);
	$db = null;
	echo $comments;
	// if (file_exists('private/image_data'))
	// {
	// 	$img = unserialize(file_get_contents('private/image_data'));
	// 	if (do_comments_exist($img))
	// 	{
	// 		foreach($img[$_SESSION['name']][$_SESSION['file']]['comments'] as $comment)
	// 		{
	// 			$comments .= $comment['author'].': '.$comment['date'] .';'.$comment['content']."\n";
	// 			// echo "<div style='background-color:white; width: 75%;'><em>".$comment['author'].': '.$comment['date']."</em><hr><p style=' margin: 2vw;'><strong>".$comment['content']."</strong></p></div><br>";
	// 		}
	// 	}
	// }
	// echo $comments;
}
?>