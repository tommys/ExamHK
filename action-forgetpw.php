<?php
	include("function.php");
	db_connect();
	global $link;
	
	$err = "";
	
	//	check email/ password vaild
	$email = test_input($_POST["email"]);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$err = "f_1"; 
	}
	
	if($err == "") {
		// 	check if email existed in database
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`users` WHERE `email` = '%s'", mysql_real_escape_string($email));
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
    	$err = "f_2";
		while ($row = mysql_fetch_array($result)) {  
    		$err = "";
		}
	}

	// error message
	if($err != "") {
		redirect("forget-pw.php?f=".$err);
	} else {
		$code = generateRandomString(10);
		
		$sql = sprintf("UPDATE `db882_faqtest`.`users` SET `reset_code` = '%s' WHERE `email` = '%s'", $code, mysql_real_escape_string($email));
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
	
		// send email
		$to      = $email;
		$subject = 'Reset your password';
		$message = 'Please go the following link to reset password.'.$link_home.'/reset-pw.php?email='.$email.'&code='.$code;
		$headers = 'From: '.$admin_email. "\r\n" .
		    'Reply-To: '.$admin_email. "\r\n" .
		    'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);

		// redirect
		redirect("index.php?l=reset_pw");
	}
?>