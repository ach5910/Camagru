<?php
session_start();
if ($_POST['submit'] === 'OK'){
	if ($_SESSION['detail'])
		echo 'Detail';
	else
		echo '';
}