<?php
	include("function.php");
	db_connect();
	global $link;

	$err = "";
	
	$fbid = $_POST['fbid'];
	$fbname = $_POST['fbname'];
	$fbemail = $_POST['fbemail'];
	
	$uid = "";
	
	$status = false;
	if($err == "") {
		// 	check if email existed in database
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`users` WHERE `email` = '%s' OR `fbid` = '%s'", mysql_real_escape_string($fbemail), mysql_real_escape_string($fbid));
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
		
			if($row['email'] == $fbemail && $row['fbid'] == $fbid){
				$err = "";
				$_SESSION['fbid'] = $_POST["fbid"];
				$_SESSION['uid'] = $uid;
			}else if($row['email'] != $fbemail && $row['fbid'] == $fbid){
				$err = "lo_4";
			}else if($row['email'] == $fbemail && $row['fbid'] != $fbid){
				$err = "lo_5";
			}
			$uid = $row['uid'];
			break;
		}
		
		if($err != ""){
			$status = $err;
			
			if($err == "lo_4"){
				
				$sql = sprintf("UPDATE `db882_faqtest`.`users` SET `email` = '%s',  `name` = '%s' WHERE `users`.`uid` = '%s'", $fbemail, $fbname, $uid);
				$result = mysql_query($sql);
				if($result === FALSE) { 
			    	die(mysql_error()); // TODO: better error handling
				}
				$_SESSION['fbid'] = $fbid;
				$_SESSION['uid'] = $uid;
			}else if($err == "lo_5"){
				
				$sql = sprintf("UPDATE `db882_faqtest`.`users` SET `fbid` = '%s',  `name` = '%s' WHERE `users`.`uid` = '%s'", $fbid, $fbname, $uid);
				$result = mysql_query($sql);
				if($result === FALSE) { 
			    	die(mysql_error()); // TODO: better error handling
				}
				$_SESSION['fbid'] = $fbid;
				$_SESSION['uid'] = $uid;
			}
			$status = "true";
		}else{
		
		
			// update database
			if($uid != ""){
			
				$sql = sprintf("UPDATE `db882_faqtest`.`users` SET `fbid` = '%s',  `name` = '%s',  `email` = '%s' WHERE `users`.`uid` = '%s'", $fbid, $fbname, $fbemail, $uid);
				$result = mysql_query($sql);
				if($result === FALSE) { 
			    	die(mysql_error()); // TODO: better error handling
				}
				$_SESSION['fbid'] = $fbid;
				$_SESSION['uid'] = $uid;
			
			}else{
				$sql = sprintf("INSERT INTO `db882_faqtest`.`users` (`uid`, `email`, `password`, `name`, `fbid`, `is_available`, `created_date`, `updated_date`) 
					VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', NULL);", $fbemail, '', $fbname, $fbid, '1', date('Y-m-d H:i:s'));
				$result = mysql_query($sql);
				if($result === FALSE) { 
				    die(mysql_error()); // TODO: better error handling
				}
				if (!$result) {
					return "Error insert user data!";
				}
				$_SESSION['fbid'] = $fbid;
				$_SESSION['uid'] = mysql_insert_id();
			}
			$status = "true";
		
		}
		
	}
// 	var_dump($_SESSION);
	echo json_encode(array("status"=>$status));
?>