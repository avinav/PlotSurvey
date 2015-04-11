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
	// returns $qid, $qtext, $aidlist, $atextlist
	if (session_id() == '' || !isset($_SESSION)) {
		session_start();
	} 
	include 'get_question_data.php';
	?>		
	<body>
	<div id='header'>
		<h1>Poll Survey</h1>
	</div>
	<div id="question"
	<?php if (isset($_SESSION['voted'])){ echo ' style="display:none;"'; } ?>>
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
					echo "<tr><td><input type='radio' name='$qid' value='$aidlist[$i]'>$atext</input></td></tr>";
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
	<?php  if(isset($_SESSION['voted'])) { echo "<div id='qres'>Already voted!</div>"; }?>
	<div id="footer"></div>
</body>
</html>

