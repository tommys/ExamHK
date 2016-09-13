<?php
	include("function.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forget Password</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	
	<script>
		$(document).ready(function(){
			<?php if(isset($_GET['f'])){ ?>
				$( ".form-alert" ).effect( "shake", {"distance": 5});
			<?php }?>
		});
	</script>
</head>
<body>
	<div class="content-login" align="center">
		<div class="block-forgetpw fl">
		<form action="action-forgetpw.php" method="post" type="submit">
			<h1>Forget Password</h1>
			<div class="form-input"><input type="text" placeholder="E-mail" name="email" /></div>
			<?php if(isset($_GET['f'])){ ?>
				<div class="form-alert"><?php echo ${$_GET['f']} ?></div>
			<?php }?>
			<div class="form-input">
				<input type="submit" name="btnLogin" id="btnLogin" value="Send" class="btn"/>
				<input type="button" name="btnBack" id="btnBack" value="Back" class="btn" onclick="window.location='index.php'"/>
			</div>
			</div>
		</form>
		<div class="cb"> </div>
	</div>
</body>
</html>