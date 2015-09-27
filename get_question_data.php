<?php 
	
	//---------------- main -----------------
	// script fetch $qtext, $atextlist, $qid, $aidlist of the active question
	
	//return $conn,$dbuser,$dbpass,$dbname,$dbhost
	require 'db_connect.php';
	require 'functions.php';
	
	
	$qid = get_active_question($conn);
	$qtext = get_question_text($conn, $qid);
	list($aidlist, $atextlist) = get_anslist($conn, $qid);
	mysql_close($conn);
	?>