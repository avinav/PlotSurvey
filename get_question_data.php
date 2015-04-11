<?php 
	/**
	 * returns active qid
	 * @param unknown $conn
	 * @return active qid
	 */
	function get_active_question($conn) {
		// table should have a single row. Max just a double-check to return a single row.
		$sql = 'SELECT MAX(qid) AS `maxid` from active_questions;';
		$retval = mysql_query ( $sql, $conn );
		if (! $retval ) {
			echo "<br>Could not get active qid: ". mysql_error();
		}
		$row = mysql_fetch_array ( $retval, MYSQL_NUM );
		return $row[0];
	}
	/**
	 * 
	 * @param unknown $conn
	 * @param unknown $qid
	 * @return returns question text for qid
	 */
	function get_question_text($conn, $qid) {
		$sql = 'SELECT qtext from questions '.
				"WHERE qid = $qid;";
		$retval = mysql_query($sql, $conn);
		if (! $retval ) {
			echo "<br>Could not select qtext: ". mysql_error();
		}
		$row = mysql_fetch_array($retval, MYSQL_NUM);
		return $row[0];
	}
	/**
	 * 
	 * @param unknown $conn
	 * @param unknown $qid
	 * @return list of answer ids and answer texts for given qid
	 */
	function get_anslist($conn, $qid) {
		$sql = 'SELECT aid, atext from answers '.
				"WHERE quesid = $qid;";
		$retval = mysql_query($sql, $conn);
		if (! $retval ) {
			echo "Could not select answer ids: ". mysql_error();
		}
		$atextlist = array();
		$aidlist = array();
		while ($row = mysql_fetch_array($retval, MYSQL_NUM)) {
			array_push($aidlist, $row[0]);
			array_push($atextlist, $row[1]);
		}
		return array($aidlist, $atextlist);
	}
	//---------------- main -----------------
	// script fetch $qtext, $atextlist, $qid, $aidlist of the active question
	
	//return $conn,$dbuser,$dbpass,$dbname,$dbhost
	include 'db_connect.php';
	mysql_select_db($dbname);
	
	$qid = get_active_question($conn);
	$qtext = get_question_text($conn, $qid);
	list($aidlist, $atextlist) = get_anslist($conn, $qid);
	mysql_close($conn);
	?>