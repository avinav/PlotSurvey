<!DOCTYPE HTML>
<html>
<head>
<title>Question</title>
<script type ="text/javascript">
function ans_poll() {
 	var ques = document.getElementsByName('question_text');
	
	var qid = ques[0].getAttribute('id');
	var radios = document.getElementsByName(qid);
	var ansid = "";
	for (var i = 0; i < radios.length; i++ ) {
 		if(radios[i].checked) {
 			ansid = radios[i].value;
 		}
	}
	if (ansid) {
		self.location = 'http://localhost/PlotSurvey/updatepoll.php?ansid='+ansid;
	}	
	else {
		alert('select a choice!');
	}
}

</script>
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
 * returns max id in questions table to be latest entry,
 * 
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
 * returns question id and list of answer ids
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
	$qid = mysql_insert_id($conn);
	
	// Insert into answers table
	$ansidlist = array();
	foreach ( $atextlist as $atext ) {
		$sql = "INSERT INTO answers " . "(atext,quesid) " . "VALUES " . "('$atext',$qid)";
		$retval = mysql_query ( $sql, $conn );
		if (! $retval) {
			die ( 'Could not enter data: ' . mysql_error () );
		}
		//Generate list of ids of answers
		array_push($ansidlist, mysql_insert_id($conn));
	}
	return array($qid,$ansidlist);
}
// ----------------main-------------------
$qtext = "";
$qid = "";
$atextlist = array();
$ansidlist = array();
// on POST request
if (isset ( $_POST ['insertq'] )) {
	$dbhost = 'localhost:3036';
	$dbuser = 'root';
	$dbpass = 'oxford';
	$dbname = 'CSE574';
	
	// Get data from the input text fields
	$conn = db_conn ( $dbhost, $dbuser, $dbpass );
	$qtext = $_POST ['inp_ques'];
	$atext = $_POST ["inp_ans"];
	
	// split data on ','
	$atextlist = explode ( ",", $atext );
	
	// Insert in database
	list($qid,$ansidlist) = insertquestion ( $dbname, $qtext, $atextlist, $conn );
	
	mysql_close ( $conn );
}
?>
	<body>
	<div id='header'>
		<h1>Poll Survey</h1>
	</div>

	<div id="question">
		<form name="question_form" action="poll.php" method="POST">
			<table class="question_tb">
				<tr>
					<td><span>Question </span></td>
					<td><div name='question_text'<?php echo " id='$qid'>"; 
					if(isset($qtext)){ echo $qtext; } ?></div></td>
				</tr>
				<?php
				// List all the answers as radio buttons
				$i = 0; 
				foreach ($atextlist as $atext) {
					echo "<tr><td><input type='radio' name='$qid' value='$ansidlist[$i]'>$atext</input></td></tr>";
					$i = $i + 1;
				}
				?>
				<tr>
					<td>
					<input type="button" name="poll" value="Poll" onclick="ans_poll();"/></td>
					<td><input type="submit" name="plot" value="Plot" /> <td>
				</tr>
			</table>
		</form>
	</div>
	<div id="footer"></div>
</body>
</html>

