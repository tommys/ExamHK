<?php
	include("function.php");
	db_connect();
	global $link;
	
	$name 			= $_POST['name'];
	$old_password	= $_POST['old_password'];
	$new_password	= $_POST['new_password'];
	
	$err = "";
	
	
	
	// update password
	if(isset($old_password) && $old_password != ""){
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`users` WHERE `uid` = '%s' AND `password` = '%s'", mysql_real_escape_string($_SESSION['uid']), mysql_real_escape_string(md5($old_password)));
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
    	$err = "f_2";
		while ($row = mysql_fetch_array($result)) {  
    		$err = "";
		}
		
		if($err == ""){
			//	check password vaild
			if($new_password == "") {
				$err = "re_2"; 
			}else if(strlen($new_password) < 6) {
				$err = "re_2a"; 
			}
		}
		
		if($err == ""){
			// changed password
			$sql = sprintf("UPDATE `db882_faqtest`.`users` SET `password` = '%s', `name` = '%s' WHERE `uid` = '%s'", md5($new_password), $name, mysql_real_escape_string($_SESSION['uid']));
			$result = mysql_query($sql);
			if($result === FALSE) { 
		    	die(mysql_error()); // TODO: better error handling
			}
			 $_SESSION['upw'] = md5($new_password);
		}
		
		
	}else{
		// just changed password
		$sql = sprintf("UPDATE `db882_faqtest`.`users` SET `name` = '%s' WHERE `uid` = '%s'", mysql_real_escape_string($name), mysql_real_escape_string($_SESSION['uid']));
		$result = mysql_query($sql);
		if($result === FALSE) { 
			die(mysql_error()); // TODO: better error handling
		}
	}

	// error message
	if($err != "") {
		redirect("myprofile.php?s=".$err);
	} else {
		// redirect
		redirect("myprofile.php?s=success");
	}
?>