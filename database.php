<?php
$dbhost = 'localhost:8080';
$dbuser = "root";
$dbpass = "root";
$con = mysql_connect('localhost', $dbuser, $dbpass);

if (!$con){
	die('Could not connect: ' .mysql_error());
}

echo 'Connect Successfully';
mysql_close($con);
?>
