<?php
if (isset($_GET['ansid'])) {
	$dbhost = 'localhost:3036';
	$dbuser = 'root';
	$dbpass = 'oxford';
	$dbname = 'CSE574';
	$conn = mysql_connect ( $dbhost, $dbuser, $dbpass );
	
	$ansid = $_GET['ansid'];
	$sql = "UPDATE answers
    SET pollval = pollval + 1
    WHERE aid = '$ansid'";
	
	mysql_select_db( $dbname );
	$retval = mysql_query( $sql, $conn );
	if ( ! $retval ) {
		die ( 'update error: ' . mysql_error () );
	}
	session_start();
	$_SESSION['voted'] = 'YES';
	mysql_close( $conn );
}
?>
<html>
<head>
</head>
<body>
<div>Thanks for polling!</div>
</body>
</html>