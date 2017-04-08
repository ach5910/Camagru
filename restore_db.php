<?php
include 'database.php';
function restore_db($DBHOST, $DBUSER, $DBPASS, $DBNAME){
	$cmd = "mysql -h ".$DBHOST." -u ".$DBUSER." -p".$DBPASS." ".$DBNAME." < ".$DBNAME.".sql";
	exec($cmd);
}

?>