<?php
	include("function.php");
	db_connect();
	if(!checkAdmin()){
		redirect("login.php");
	}
	$users = getUsers(null, true);
	
	$page = "testcats";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Test</title>
	<link media="all" rel="stylesheet" type="text/css" href="css/all.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
	
</head>
<body>
	<div id="wrapper">
		<div id="content">
			<div class="c1">
				<?php include("controls.php");?>
				<div class="tabs">
					<div id="tab-1" class="tab">
						<div class="text-section">
							<h1>Add Test Category</h1>
							<p>This is a quick overview of some features</p>
						</div>
						<div class="block-users">
							<div class="form-test">
								<form action="action-addtestcat.php" id="add-test-form" method="POST" enctype="multipart/form-data">
									<div class="input-block">Test Category Name: <input type="text" name="name" /></div>
									
									<hr/>
									<div class="input-block"><input type="submit" value="Submit"/></div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("sidebar.php");?>
	</div>
</body>
</html>