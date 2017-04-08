<?php
include 'database.php';

function create_db($DBHOST, $DBUSER, $DBPASS, $DBNAME){
	$link = mysql_connect($DBHOST, $DBUSER, $DBPASS);
	if (!$link) {
	    die('Could not connect: ' . mysql_error());
	}

	$sql = 'CREATE DATABASE IF NOT EXISTS '.$DBNAME;
	if (mysql_query($sql, $link)) {
	    echo "Database my_db created successfully\n";
	    return (TRUE);
	}
    echo 'Error creating database: ' . mysql_error() . "\n";
    return (FALSE);
}
?>