<!DOCTYPE HTML>
<html>
<head>
<title>Question</title>
</head>
<?php
/**
 * set up database connection
 *
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
	return $conn;
}


/**
 * Assume the max id in questions table to be latest entry,
 * Use maxid to set foreign key in answers table
 *
 * @param unknown $conn
 */
function selectMaxId($conn) {
	$sql = 'SELECT MAX(qid) AS `maxid` FROM `questions`';
	$retval = mysql_query ( $sql, $conn );
	if (! $retval) {
		die ( 'Could not select max ' . mysql_error () );
	}
	$row = mysql_fetch_array ( $retval, MYSQL_NUM );
	return $row [0];
}


/**
 * insert the data (question and answer) in corresponding tables
 *
 * @param unknown $dbname
 * @param unknown $qtext
 * @param unknown $atext
 * @param unknown $conn
 */
function insertquestion($dbname, $qtext, $atextlist, $conn) {
	mysql_select_db ( $dbname );

	// Insert into questions table
	$sql = "INSERT INTO questions " . "(qtext) " . "VALUES " . "('$qtext')";
	$retval = mysql_query ( $sql, $conn );
	if (! $retval) {
		die ( 'Could not enter data: ' . mysql_error () );
	}

	// Get question id to set the foreign key of answers table
	$qid = selectMaxId ( $conn );

	// Insert into answers table
	foreach ( $atextlist as $atext ) {
		$sql = "INSERT INTO answers " . "(atext,quesid) " . "VALUES " . "('$atext',$qid)";
		$retval = mysql_query ( $sql, $conn );
		if (! $retval) {
			die ( 'Could not enter data: ' . mysql_error () );
		}
	}
	return $qid;
}
// ----------------main-------------------
$qtext = "";
$qid = "";
$atextlist = array();
// on POST request
if (isset ( $_POST ['insertq'] )) {
	$dbhost = 'localhost:3036';
	$dbuser = 'root';
	$dbpass = 'oxford';
	$dbname = 'CSE574';
	
	// Get data from the input text fields
//	$conn = db_conn ( $dbhost, $dbuser, $dbpass );
	$qtext = $_POST ['inp_ques'];
	$atext = $_POST ["inp_ans"];
	
	// split data on ','
	$atextlist = explode ( ",", $atext );
	
	// Insert in database
//	$qid = insertquestion ( $dbname, $qtext, $atextlist, $conn );
	
	mysql_close ( $conn );
}

?>
	<body>
	<div id='header'>
		<h1>Poll Survey</h1>
	</div>

	<div id="question">
		<form name="question_form" action="graph.php" method="POST">
			<table class="question_tb">
				<tr>
					<td><span>Question </span></td>
					<td><div id='question_text'><?php if(isset($qText)){ echo $qText; } ?></div></td>
				</tr>
				<?php
				// List all the answers as radio buttons
				$i = 0; 
				foreach ($atextlist as $atext) {
					echo "<tr><td><input type='radio' name='$qid' value='$i'>$atext</input></td></tr>";
				}
				?>
				<tr>
					<td colspan="2" align="right"><input type="button" value="submit"
						onclick="submitResponse();" /></td>
				</tr>
			</table>
		</form>
	</div>
	<div id="footer"></div>
</body>
</html>

