<html>
<head>
<title>Insert questions</title>
</head>
<?php 
require "db_connect.php";
require "functions.php";
include 'db_insert_question.php'; 
session_start()?>

<body>
		<div id=loggedin
		<?php if (!(isset($_SESSION) && isset($_SESSION['logged']))) {echo "style='display:none';";}?>>
		<span style="font-size: 20">Welcome <?=$_SESSION['user']?>!</span>
		<div id='qform'
			<?php if (isset($_POST['insertq'])){ echo ' style="display:none;"'; } ?>>
			<form name="question_form" action="<?php echo $_SERVER['PHP_SELF']?>"
				method="POST">
				<br><br><br>
				<table align="center">
					<tr>
						<td><span>Enter New Question:</span></td>
						<td><textarea id='inp_ques' name='inp_ques' rows='4' cols='50'
								maxlength='200'></textarea></td>
					</tr>
					<tr>
						<td><span>Enter options , sepereated</span></td>
						<td><input id='inp_ans' name='inp_ans' type="text" /></td>
					</tr>
					<tr>
						<td><input type='submit' name='insertq' value='Submit' /></td>
						<td><span><a href=<?php $active_qid = get_active_question($conn);
						 echo "'./displayplot.php?qid=$active_qid'";?>>View
					Result</a></span></td>
				
				</table>
			</form>
		</div>
		<div id='inserted'
			<?php  if(!isset($_POST['insertq'])) { echo " style='display: none;'"; }?>>
			<span>Question added! </span> <span><a href=<?php echo "'./displayplot.php?qid=$qid'"?>>View
					Result</a></span>
		</div>
	</div>
	<?php  if (!(isset($_SESSION) && isset($_SESSION['logged']))) { echo 'not logged in!';}?>
</body>
</html>