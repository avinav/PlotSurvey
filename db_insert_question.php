<?php
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

	// Update active_questions table
	update_active($conn, $qid);
	
	// Insert into answers table
	$aidlist = array();
	foreach ( $atextlist as $atext ) {
		$sql = "INSERT INTO answers " . "(atext,quesid) " . "VALUES " . "('$atext',$qid)";
		$retval = mysql_query ( $sql, $conn );
		if (! $retval) {
			die ( 'Could not enter data: ' . mysql_error () );
		}
		//Generate list of ids of answers
		array_push($aidlist, mysql_insert_id($conn));
	}
	return array($qid,$aidlist);
}

function update_active($conn, $qid) {
	$sql = 'UPDATE active_questions SET '.
			"qid = $qid;";
	mysql_query($sql, $conn);
}
// ----------------main-------------------
$qtext = "";
$qid = "";
$atextlist = array();
$ansidlist = array();
// on POST request
if (isset ( $_POST ['insertq'] )) {
	
	// returns $conn,$dbuser,$dbpass,$dbname,$dbhost
// 	include 'db_connect.php';
	
	// Get data from the input text fields
	$qtext = $_POST ['inp_ques'];
	$atext = $_POST ["inp_ans"];
	
	// split data on ','
	$atextlist = explode ( ",", $atext );
	
	// Insert in database
	list($qid,$aidlist) = insertquestion ( $dbname, $qtext, $atextlist, $conn );
	
	mysql_close ( $conn );
}
?>