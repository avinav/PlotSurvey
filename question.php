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
		self.location = './updatepoll.php?ansid='+ansid;
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
	<div id='header' style="text-align: center">
		<span style="font-size: 2em">Poll Survey</span>
	</div>
	<hr>
	<div id="question"
	<?php if (isset($_SESSION['voted'])){ echo ' style="display:none;"'; } ?>>
		<form name="question_form" action="poll.php" method="POST">
			<table class="question_tb" align="center">
				<tr>
					<td><b><span>Question: </span></b></td>
					<td><b><div name='question_text'<?php echo " id='$qid'>"; 
					if(isset($qtext)){ echo $qtext; } ?></div></b></td>
				</tr>
				<?php
				// List all the answers as radio buttons
				$i = 0; 
				foreach ($atextlist as $atext) {
					echo "<tr><td></td><td><input type='radio' name='$qid' value='$aidlist[$i]'>$atext</input></td></tr>";
					$i = $i + 1;
				}
				?>
				<tr>
					<td>
					<input type="button" name="poll" value="Poll" onclick="ans_poll();"/></td>
				</tr>
			</table>
		</form>
	</div>
	<?php  if(isset($_SESSION['voted'])) { echo "<div id='qres'>Already voted!</div>"; }?>
	<div id="footer"></div>
</body>
</html>

