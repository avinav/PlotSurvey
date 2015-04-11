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
function create_db($dbname, $conn) {
	$sql = 'CREATE DATABASE '. $dbname;
	$retval = mysql_query ( $sql, $conn );
	if (! $retval) {
		echo '<br>Could not connect to database: '. mysql_error () ;
	}
	echo '<br>Database CSE574 created successfully';	
}

function create_tables($dbname, $conn) {
	$sql = 'CREATE TABLE questions('.
			"qid INT NOT NULL AUTO_INCREMENT, ".
			"qtext VARCHAR(200) NOT NULL, ".
			//"active TINYINT(1) DEFAULT 0,".
			"PRIMARY KEY (qid)); ";
	mysql_select_db($dbname);
	$retval = mysql_query($sql, $conn);
	if ( ! $retval ) {
		echo "Could not create table: ". mysql_error() ;
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
		echo '<br>Could not create table: '. mysql_error() ;
	}
	echo "<br>Table created successfully: answers";
	
	$sql = 'CREATE TABLE users('.
			"uid INT NOT NULL AUTO_INCREMENT, ".
			"uname VARCHAR(20) NOT NULL, ".
			"pass VARCHAR(20) NOT NULL, ".
			"PRIMARY KEY(uid)); ";
	$retval = mysql_query($sql, $conn);
	if ( ! $retval ) {
		echo "<br>Could not create table: ". mysql_error();
	}
	echo "Table created successfully: users";
	
	// table to keep a single row for the "active question"
	$sql = "CREATE TABLE active_question(".
			"qid INT NOT NULL, ".
			"PRIMARY KEY(qid)); ";
	$retval = mysql_query($sql, $conn);
	if ( ! $retval ) {
		echo "<br>Could not create table: ". mysql_error();
	}
	
	echo "Table created successfully: active_questions";
	// insert qid = 0 in active question as we will always update this row
	$sql = "INSERT into active_questions ".
			"values (0);";
	$retval = mysql_query($sql, $conn);
}

$dbhost = 'localhost:3036';
$dbuser = 'root';
$dbpass = 'oxford';
$dbname = 'CSE574';
$conn = db_conn($dbhost, $dbuser, $dbpass);
create_db($dbname,$conn);
create_tables($dbname, $conn);
mysql_close ( $conn );
?>
	</body>
</html>