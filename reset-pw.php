<?php
	include("function.php");
	db_connect();
	
	$email = $_GET['email'];
	$code = $_GET['code'];
	
	$uid = checkUID($email, $code);
	if($uid <= 0 ){
		redirect("index.php?l=reset_pw_err");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	
	<script>
		$(document).ready(function(){
			<?php if(isset($_GET['err'])){ ?>
				$( ".form-alert" ).effect( "shake", {"distance": 5});
				$( ".form-success").fadeIn();
			<?php }else{?>
				$( ".form-alert" ).hide();
				$( ".form-success").hide();
			<?php }?>
		});
	</script>
</head>
<body>

	<div class="content">
		<h1>Reset Password</h1>
		<form action="action-reset-pw.php" method="post" type="submit">
			<div>
				New Password: <input type="password" name="newpw" />
			</div>
			<br/>
			<div class="form-alert">
				<?php echo ${$_GET['err']} ?>
			</div>
			<input type="hidden" name="code" value="<?php echo $code;?>" />
			<input type="hidden" name="email" value="<?php echo $email;?>" />
			<input type="hidden" name="uid" value="<?php echo $uid;?>" />
			<input type="hidden" name="code" value="<?php echo $code;?>" />
			<input type="submit" name="submitBtm" />
		</form>
		<p><a href="index.php">Back</a></p>
	</div>
</body>
</html>