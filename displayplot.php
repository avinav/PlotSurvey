<?php
require 'phplot-6.1.0/phplot.php';
require 'db_connect.php';
require 'functions.php';

$qid = $_GET['qid'];
$plot = plot_bar_graph($qid);

// echo get_question_text($conn, $qid);
// $cmd = escapeshellcmd("/usr/bin/python2.7 ./scripts/fetchData.py $qid");
// $out = shell_exec($cmd);
// echo $out;
// sleep(1);

?>
<html>
<head>
<title></title>
</head>
<body>
<div><span style="font-size: 20">
Question: <?php echo get_question_text($conn, $qid);?>
</span>&nbsp;|&nbsp;<span>Poll Count: <?php echo get_poll_count($qid); ?></span>
</div>
<hr>
<div>
<img src="<?php echo $plot->EncodeImage();?>">
</div>
</body>
</html>