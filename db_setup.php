<html>
<head>
<title>Connecting MySql DB</title>
</head>
<body>
<?php
function db_conn($dbhost, $dbuser, $dbpass) {
	$conn = mysql_connect ( $dbhost, $dbuser, $dbpass );
	if (! $conn) {
		die ( 'Could not connect: ' + mysql_error () );
	}
	echo 'Connected successfully';
	return $conn;
}
function create_db($dbname) {
	$sql = 'CREATE DATABASE ' + $dbname;
	$retval = mysql_query ( $sql, $conn );
	if (! $retval) {
		die ( 'Could not connect to database: ' + mysql_error () );
	}
	echo '\nDatabase CSE574 created successfully';	
}

function create_tables($dbname, $conn) {
	$sql = 'CREATE TABLE questions('.
			"qid INT NOT NULL AUTO_INCREMENT, ".
			"qtext VARCHAR(200) NOT NULL, ".
			"PRIMARY KEY (qid)); ";
	mysql_select_db($dbname);
	$retval = mysql_query($sql, $conn);
	if ( ! $retval ) {
		die("Could not create table: " + mysql_error());
	}
	echo "Table created successfully: questions";
	$sql = 'CREATE TABLE answers('.
			"aid INT NOT NULL AUTO_INCREMENT, ".
			"atext VARCHAR(200) NOT NULL, ".
			"quesid INT, ".
			"pollval INT DEFAULT 0, ".
			"PRIMARY KEY (aid)); ";
	$retval = mysql_query($sql, $conn);
	if ( ! $retval ) {
		die("Could not create table: " + mysql_error());
	}
	echo "Table created successfully: answers";
}

$dbhost = 'localhost:3036';
$dbuser = 'root';
$dbpass = 'oxford';
$dbname = 'CSE574';
$conn = db_conn($dbhost, $dbuser, $dbpass);
create_db($dbname);
create_tables($dbname, $conn);
mysql_close ( $conn );
?>
	</body>
</html>