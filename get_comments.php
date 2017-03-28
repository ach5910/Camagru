<?php
session_start();
function get_comments(){
	if (file_exists('private/image_data'))
	{
		$img = unserialize(file_get_contents('private/image_data'));
		if (array_key_exists('comments', $img[$_SESSION['name']][$_SESSION['file']]))
		{
			foreach($img[$_SESSION['name']][$_SESSION['file']]['comments'] as $comment)
			{
				echo "<div style='background-color:white; width: 75%;'><em>".$comment['author'].': '.$comment['date']."</em><hr><p style=' margin: 2vw;'><strong>".$comment['content']."</strong></p></div><br>";
			}
		}
	}
}
?>