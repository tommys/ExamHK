<?php
	include("function.php");
	db_connect();
	if(!checkUser()){
		redirect("index.php");
	}
	$user = $_SESSION['user'];
	$tests = getAllAvailableTestWithCat($user['cat']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Test</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	
</head>
<body>

	<div class="content">
	<h1>My Test</h1>
	<hr/>
	<table width="100%">
		<tr>
			<td>Test name</td>
			<td>Score</td>
			<td>Action</td>
		</tr>
	<?php foreach($tests as $test){ ?>
		<tr>
			<td>
				<h2><a href="test.php?id=<?php echo encrypt($test['formid']);?>"><?php echo $test['name'];?></a></h2>
			</td>
			<td>
				<div class="final-score">
				<?php 
					$score = getUserScoreWithUID($test['formid'], $_SESSION['uid']);
					echo ($score>=0?$score:"Not finished yet");
				?>
				</div>
			</td>
			<td>
				<a href="dotest.php?id=<?php echo encrypt($test['formid']);?>">Do</a>
				<a href="test.php?id=<?php echo encrypt($test['formid']);?>"><img src="img/Search-48.png" width="18" /></a>
			</td>
		</tr>
	<?php } ?>
	</table>
	<hr/>
	<p><a href="home.php">Back</a></p>
	</div>
</body>
</html>