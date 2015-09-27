<html>
<head>
<title>Login</title>
</head>
<?php
require 'db_connect.php';
require 'functions.php';
/**
 *
 * @param unknown $conn        	
 * @param unknown $uid        	
 */

function check_password($conn, $inpUid, $inpPass) {
	$sql = "SELECT pass from users " . "WHERE uname = '$inpUid';";
	$retval = mysql_query ( $sql, $conn );
	if (! $retval) {
		echo "Incorrect userid: " . mysql_error ();
	}
	$row = mysql_fetch_array ( $retval );
	$pass = $row [0];
	if ($pass == $inpPass) {
		return True;
	} else {
		echo "Password Incorrect!";
	}
	return False;
}
// --------------------main ----------------------

if (isset ( $_POST ['login'] )) {
	session_start();
	
	include 'db_connect.php';
// 	mysql_select_db ( $dbname );
	$uid = $_POST ['uid'];
	$pass = $_POST ['pid'];
	if (check_password ( $conn, $uid, $pass )) {
		$loggedin = True;
		$_SESSION['logged'] = True;
		$_SESSION['user'] = $uid;
		header("Location: ./logquestion.php");
	} else {
	}
}

?>
<body>
<br><br><br><br><br><br><br>
	<div id='login_page'
		<?php if(isset($loggedin)) { echo ' style="display:none;"';}?>>
		<form method='POST' action=<?php echo $_SERVER['PHP_SELF']?>>
			<div id='login' style="text-align: right;width: 45%;float:left;">
			<span style="font-size: 24">Login to create a Poll</span><br><br>
				<table align="right">
					<tr>
						<td><span>User: </span></td>
						<td><input type='text' id='uid' name='uid' /></td>
					</tr>
					<tr>
						<td><span>Password: </span></td>
						<td><input type="password" id='pid' name='pid' /></td>
					</tr>
					<tr>
						<td><input type='submit' name='login' value='Login' /></td>
					</tr>
				</table>
			</div>
		</form>
		<div id='poll' style="text-align: left;width:45%;float:right;">
		<br><br>
			<span style="font-size: 20"><a href='./question.php'>Take Poll</a></span>
			&nbsp;|&nbsp;<span style="font-size: 20"><a href=<?php $active_qid = get_active_question($conn);
						 echo "'./displayplot.php?qid=$active_qid'";?>>View Poll Result</a></span>
		</div>
	</div>
</body>
</html>