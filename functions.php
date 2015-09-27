<?php
/**
 * returns active qid
 * @param connection to db $conn
 * @return active question id
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
 * @param connection to db $conn
 * @param question id $qid
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
 * @param connection to db $conn
 * @param question id $qid
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
/**
 *
 * @param question id $qid
 * @return question text for given qid
 */
function plot_bar_graph($qid) {
	$query = "SELECT atext, pollval FROM answers WHERE quesid = $qid";
	$result = mysql_query($query);
	$data = array();
	while ($row = mysql_fetch_array($result)) {
		$data[] = array($row[0], $row[1]);
	}

	$plot = new PHPlot(800, 600);
	$plot->SetPrintImage(False);
	$plot->SetImageBorderType('plain');

	$plot->SetPlotType('bars');
	$plot->SetDataType('text-data');
	$plot->SetDataValues($data);

	# Main plot title:
	$plot->SetTitle('User answers');

	# Make sure Y axis starts at 0:
	$plot->SetPlotAreaWorld(NULL, 0, NULL, NULL);

	$plot->DrawGraph();
	return $plot;
}
/**
 * 
 * @param question id $qid
 * @return total number of poll
 */
function get_poll_count($qid) {
	$query = "SELECT sum(pollval) from answers where quesid = $qid";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	return $row[0];
}
?>