<?php
include 'database.php';

function create_db($DBHOST, $DBUSER, $DBPASS, $DBNAME){
	$link = mysqli_connect($DBHOST, $DBUSER, $DBPASS);
	if (!$link) {
	    die('Could not connect: ' . mysqli_error());
	}

	$sql = 'CREATE DATABASE IF NOT EXISTS '.$DBNAME;
	if (mysqli_query($link, $sql)) {
	    return (TRUE);
	}
    return (FALSE);
}
?>