<html>
<head>
<title>Login</title>
</head>
<?php
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
	mysql_select_db ( $dbname );
	$uid = $_POST ['uid'];
	$pass = $_POST ['pid'];
	if (check_password ( $conn, $uid, $pass )) {
		$loggedin = True;
		$_SESSION['logged'] = True;
	} else {
	}
}

?>
<body>
	<div id='login_page'
		<?php if(isset($loggedin)) { echo ' style="display:none;"';}?>>
		<form method='POST' action=<?php echo $_SERVER['PHP_SELF']?>>
			<div id='login'>
				<table>
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
		<div id='poll'>
			<span>Students: </span><a href='./question.php'>Poll</a>
		</div>
	</div>
</body>
</html>