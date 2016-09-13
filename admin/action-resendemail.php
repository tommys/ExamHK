<?php
	include("function.php");
	if(!checkAdmin()){
		redirect("login.php");
	}
	db_connect();
// 	echo "<pre>";
// 	var_dump($_POST);
// 	echo "</pre>";
	
	$uid = $_POST['user_id'];
	$pw = generateRandomString(8);
	
	$sql = sprintf("UPDATE `db882_faqtest`.`users` SET `password` = '%s', `reset_code` = '' WHERE `uid` = '%s'", md5($pw), mysql_real_escape_string($uid));
	$result = mysql_query($sql);
	if($result === FALSE) { 
		die(mysql_error()); // TODO: better error handling
	}
	
	// send email
	$to      = $email;
	$subject = 'Reset your password';
	$message = 'Your new password:'.$pw;
	$headers = 'From: '.$admin_email. "\r\n" .
	    'Reply-To: '.$admin_email. "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);
	
	return json_encode(array("status"=>"true"));
?>