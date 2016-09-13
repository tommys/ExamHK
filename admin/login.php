<?php
	include("function.php");
	
	if(isset($_POST['username'])) {
		if(!adminLogin($_POST['username'], $_POST['password'])){
			$_GET['err'] = "err_1";
		}else{
			redirect("index.php");
			exit();
		}
	}
?>
<!DOCTYPE html>
<html>
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
	
	<script>
		$(document).ready(function(){
			<?php if(isset($_GET['err']) && $_GET['err'] != ""){ ?>
				$( ".form-alert" ).effect( "shake", {"distance": 5});
			<?php }?>
		});
	</script>
	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
</head>
<body>
	<div class="content-login" align="center">
	<form action="login.php" method="post" type="submit">
		<h1>Admin Page</h1>
		<div class="form-input"><input type="text" placeholder="Username" name="username" /></div>
		<div class="form-input"><input type="password" placeholder="Password" name="password"/></div>
		<?php if(isset($_GET['err']) && $_GET['err'] != ""){ ?>
			<div class="form-alert">Invail Password</div>
		<?php } ?>
		<div class="form-input"><input type="submit" name="btnLogin" id="btnLogin" value="Login" class="btn"/></div>
	</form>
	</div>
</body>
</html>