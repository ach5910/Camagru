<?php
function get_like_count(){
	if (file_exists('private/image_data'))
	{
		$img = unserialize(file_get_contents('private/image_data'));
		if (array_key_exists('like', $img[$_SESSION['name']][$_SESSION['file']]))
		{
			$count = 0;
			foreach ($img[$_SESSION['name']][$_SESSION['file']]['like'] as $user)
			{
				if ($user)
					$count++;
			}
		}
		return $count;
	}
}
?>