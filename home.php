<?php
	include("function.php");
	db_connect();
	if(!checkUser()){
		redirect("index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	
</head>
<body>
	<div class="content">
		<div class="welcome">
			Welcome back.<a href="action-logout.php" class="fr" >( Logout )</a>
		</div>
		<div class="home_btn btn_profile">
			<a href="myprofile.php">My Profile</a>
		</div>
		<div class="home_btn btn_mytest">
			<a href="mytest.php">My Test</a>
		</div>
	</div>
</body>
</html>