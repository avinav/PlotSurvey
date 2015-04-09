<?php
/**
 * set up database connection
 * @param unknown $dbhost
 * @param unknown $dbuser
 * @param unknown $dbpass
 * @return resource
 */
function db_conn($dbhost, $dbuser, $dbpass) {
	$conn = mysql_connect ( $dbhost, $dbuser, $dbpass );
	if (! $conn) {
		die ( 'Could not connect: ' + mysql_error () );
	}
	echo '\nConnected successfully';
	return $conn;
}
/**
 * Assume the max id in questions table to be latest entry, 
 * Use maxid to set foreign key in answers table
 * @param unknown $conn
 */
function selectMaxId($conn) {
	$sql = 'SELECT MAX(qid) AS `maxid` FROM `questions`';
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not select max ' . mysql_error());
	}
	$row = mysql_fetch_array($retval, MYSQL_NUM);
	echo 'MAXID:'.$row[0];
	return $row[0];
}
/**
 * insert the data (question and answer) in corresponding tables
 * @param unknown $dbname
 * @param unknown $qtext
 * @param unknown $atext
 * @param unknown $conn
 */
function insertquestion($dbname, $qtext, $atextlist, $conn) {
	mysql_select_db($dbname);
	
	// Insert into questions table
	$sql = "INSERT INTO questions ".
			"(qtext) ".
			"VALUES ".
			"('$qtext')";
	$retval = mysql_query( $sql, $conn );
	if(! $retval )
	{
		die('Could not enter data: ' . mysql_error());
	}

	// Get question id to set the foreign key of answers table
	$qid = selectMaxId($conn);
	
	// Insert into answers table
	foreach($atextlist as $atext) {
		$sql = "INSERT INTO answers ".
				"(atext,quesid) ".
				"VALUES ".
				"('$atext',$qid)";
		$retval = mysql_query( $sql, $conn );
		if(! $retval )
		{
			die('Could not enter data: ' . mysql_error());
		}
	}
}
//----------------main-------------------
// on POST request
if (isset($_POST['insertq'])) {
	$dbhost = 'localhost:3036';
	$dbuser = 'root';
	$dbpass = 'oxford';
	$dbname = 'CSE574';
	
	// Get data from the input text fields
	$conn = db_conn($dbhost, $dbuser, $dbpass);
	$qtext = $_POST['inp_ques'];
	$atext = $_POST["inp_ans"];
	
	// split data on ','
	$atextlist = explode(",",$atext);
	
	// Insert in database
	insertquestion($dbname, $qtext,$atextlist,$conn);
	mysql_close($conn);
}

?>
<html>
<head>
<title>Insert questions</title>
</head>
<body>
	<div id='qform'
		<?php if (isset($_POST['insertq'])){ echo ' style="display:none;"'; } ?>>
		<form name="question_form" action="<?php $_PHP_SELF ?>" method="POST">
			<table>
				<tr>
					<td><span>Enter Question:</span></td>
					<td><textarea id='inp_ques' name='inp_ques' rows='4' cols='50'
							maxlength='200'></textarea></td>
				</tr>
				<tr>
					<td><span>Enter options , sepereated</span></td>
					<td><input id='inp_ans' name='inp_ans' type="text" /></td>
				</tr>
				<tr>
					<td><input type='submit' name='insertq' value='Submit' /></td>
			
			</table>
		</form>
	</div>
	<?php if(isset($_POST['insertq'])) { echo "<div id='qres'>Insert successfull!</div>"; }?>
	</body>
</html>