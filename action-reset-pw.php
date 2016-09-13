<?php
	include("function.php");
	db_connect();
	global $link;
	
	$err = "";
	
	$uid = $_POST['uid'];
	$pw = $_POST['newpw'];
	$email = $_POST['email'];
	$code = $_POST['code'];
	
	//	check email/ password vaild
	if($pw == "") {
		$err = "re_2"; 
	}else if(strlen($pw) < 6) {
		$err = "re_2a"; 
	}
	
	if($err == "") {
		$sql = sprintf("UPDATE `db882_faqtest`.`users` SET `password` = '%s', `reset_code` = '' WHERE `uid` = '%s'", md5($pw), mysql_real_escape_string($uid));
		$result = mysql_query($sql);
		if($result === FALSE) { 
			die(mysql_error()); // TODO: better error handling
		}
	}

	// error message
	if($err != "") {
		redirect("reset-pw.php?email=".$email."&code=".$code."&err=".$err );
	} else {
		// redirect
		redirect("index.php?l=reset_pw_success");
	}
?>