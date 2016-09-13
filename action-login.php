<?php
	include("function.php");
	db_connect();
	global $link;

	$err = "";
	
	//	check email/ password vaild
	$email = test_input($_POST["email"]);
	$pw = test_input($_POST["password"]);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$err = "lo_1"; 
	}else if($pw == "") {
		$err = "lo_2"; 
	}else if(strlen($pw) < 6) {
		$err = "lo_2a"; 
	}
	$uid = "";
	$user = array();
	if($err == "") {
		// 	check if email existed in database
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`users` WHERE `email` = '%s' AND `password` = '%s'", mysql_real_escape_string($email), mysql_real_escape_string(md5($pw)));
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
    	$err = "lo_3";
		while ($row = mysql_fetch_array($result)) {  
    		$err = "";
			$uid = $row['uid'];
			$user = $row;
		}
	}

	// error message
	if($err != "") {
		redirect("index.php?l=".$err);
	} else {
		// login success
		$_SESSION['uname'] = $_POST["email"];
		$_SESSION['upw'] = md5($pw);
		$_SESSION['uid'] = $uid;
		$_SESSION['user'] = $user;
		// redirect
		redirect("home.php");
	}
?>