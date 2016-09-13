<?php
	include("function.php");
	db_connect();
	global $link;
	
// 	echo "email: ".$_POST['email'];
// 	echo "password: ".$_POST['password'];
	
	$err = "";
	
	//	check email/ password vaild
	$email = test_input($_POST["email"]);
	$pw = test_input($_POST["password"]);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$err = "re_1"; 
	}else if($pw == "") {
		$err = "re_2"; 
	}else if(strlen($pw) < 6) {
		$err = "re_2a"; 
	}
	if($err == "") {
		// 	check if email existed in database
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`users` WHERE `email` = '%s'", mysql_real_escape_string($email));
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {  
    		$err = "re_3";
		}
	}

	// error message
	if($err != "") {
		redirect("index.php?s=".$err);
	} else {
		// register success
		insertUser($email, $pw);
		redirect("index.php?s=re_success");
	}
?>