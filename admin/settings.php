<?php
	include("function.php");
	if(!checkAdmin()){
		redirect("login.php");
	}
	db_connect();
	
	$page = "settings";
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>AdminPanel</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/all.css" />
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
						<article>
							<div class="text-section">
								<h1>Settings </h1>
								<p>This is a quick overview of some features</p>
							</div>
							<!-- 
<ul class="states">
								<li class="error">Error : This is an error placed text message.</li>
								<li class="warning">Warning: This is a warning placed text message.</li>
								<li class="succes">Succes : This is a succes placed text message.</li>
							</ul>
 -->
						</article>
						<div class="block-users">
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("sidebar.php");?>
	</div>
</body>
</html>