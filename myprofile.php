<?php
	include("function.php");
	db_connect();
	if(!checkUser()){
		redirect("index.php");
	}
	$user = getUserInfo();
?>
<!DOCTYPE html>
<html>
<head>
	<title>My Profile</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	
	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$('.status-box').slideUp();
			}, 2000);
		});
	</script>
	
</head>
<body>
	<?php if(isset($_GET['s']) && $_GET['s'] != ""){?>
	<div class="status-box <?php echo ($_GET['s'] == "success")?"success-box":"fail-box"?>">
		<?php if($_GET['s'] == "success"){?>
			Updated Successful.
		<?php }else if($_GET['s'] == 'f_2') {?>
			Old password not correct.
		<?php }else if($_GET['s'] == 're_2') {?>
			Please enter new password.
		<?php }else if($_GET['s'] == 're_2a') {?>
			New password at least 6 characters.
		<?php }?>
	</div>
	<?php }?>
	<div class="content">
	<h1>My Profile</h1>
	<hr/>
	<form action="action-update-profile.php" method="POST">
	<table width="100%">
		<tr>
			<td>Email:</td>
			<td><input type="text" name="email" value="<?php echo $user['email'];?>" disabled="disabled"/></td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="name" value="<?php echo $user['name'];?>"/></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="old_password"/></td>
		</tr>
		<tr>
			<td>New Password:</td>
			<td><input type="password" name="new_password"/></td>
		</tr>
		<!-- 
<tr>
			<td>Facebook:</td>
			<td><?php echo $user['fbid'];?></td>
		</tr>
 -->
		<tr>
			<td>Created Date:</td>
			<td><?php echo $user['created_date'];?></td>
		</tr>
		<tr>
			<td>Updated Date:</td>
			<td><?php echo $user['updated_date'];?></td>
		</tr>
	</table>
	<hr/>
	<input type="submit" value="Submit" />
	</form>
	
	<p><a href="home.php">Back</a></p>
	</div>
</body>
</html>