<?php

/**
 * set up database connection
 *
 * @param $dbhost
 * @param $dbuser
 * @param $dbpass
 * @return resource
 */
function db_conn($dbhost, $dbuser, $dbpass) {
	$conn = mysql_connect ( $dbhost, $dbuser, $dbpass );
	if (! $conn) {
		die ( 'Could not connect: ' + mysql_error () );
	}
	return $conn;
}

$dbhost = 'localhost:3036';
$dbuser = 'root';
$dbpass = 'oxford';
$dbname = 'CSE574';

$conn = db_conn ( $dbhost, $dbuser, $dbpass );
mysql_select_db ( $dbname );
?>