<html>
<head>
<title>Insert questions</title>
</head>
<?php include 'db_insert_question.php'; session_start()?>

<body>
		<div id=loggedin
		<?php if (!(isset($_SESSION) && isset($_SESSION['logged']))) {echo "style='display:none';";}?>>
		<h1>Welcome!</h1>
		<div id='qform'
			<?php if (isset($_POST['insertq'])){ echo ' style="display:none;"'; } ?>>
			<form name="question_form" action="<?php echo $_SERVER['PHP_SELF']?>"
				method="POST">
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
		<div id='inserted'
			<?php  if(!isset($_POST['insertq'])) { echo " style='display: none;'"; }?>>
			<span>Insert Succesfull! </span> <span><a href='./displayplot.php'>View
					Result</a></span>
		</div>
	</div>
	<?php  if (!(isset($_SESSION) && isset($_SESSION['logged']))) { echo 'not logged in!';}?>
</body>
</html>