<html>
<head>
<title>Insert questions</title>
</head>
<body>
	<h1>Welcome!</h1>
	<div id='qform'
		<?php //if (isset($_POST['insertq'])){ echo ' style="display:none;"'; } ?>>
		<form name="question_form" action="question.php" method="POST">
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
	<?php // if(isset($_POST['insertq'])) { echo "<div id='qres'>Insert successfull!</div>"; }?>
	</body>
</html>