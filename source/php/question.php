<!DOCTYPE HTML>
<html>
<head>
<link type="text/css" rel="stylesheet" href="css/stylesheet.css" />
<title>Poll</title>
</head>
<body>
<div id = 'header'>
<h1>Distribution Generator</h1>
</div>
<?php 
session_start();

$_SESSION['pageviews'] = ($_SESSION['pageviews']) ? $_SESSION['pageviews'] + 1 : 1;
$qText = "Select any of the numbers:" + $_SESSION['pageviews']?>
	<div id="question">
	<form name ="question_form" action ="graph.php" method = "POST" >
			<table class="question_tb">
				<tr>
					<td><span>Question </span></td>
					<td><div id = 'question_text'><?php if(isset($qText)){ echo $qText; } ?></div></td>
				
				<tr>
					<td><input type="radio" name = "ans" value = "ans1">1</input></td>
				</tr>
				<tr>
					<td><input type="radio" name = "ans" value = "ans2"/>2</td>
				</tr>
				<tr>
					<td><input type="radio" name = "ans" value = "ans3"/>3</td>
				</tr>
				<tr>
					<td><input type="radio" name = "ans" value = "ans4"/>4</td>
				</tr>
				<tr>
					<td colspan="2" align="right"><input type="button"
						value="submit" onclick="submitResponse();" /></td>
				</tr>
			</table>
		</form>
</div>
<div id="footer">

</div>
</body>
</html>

