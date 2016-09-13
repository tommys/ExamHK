<?php
	include("function.php");
	if(!checkAdmin()){
		redirect("login.php");
	}
	db_connect();
// 	echo "<pre>";
// 	var_dump($_POST);
// 	echo "</pre>";
	
	// insert test
	$sql = sprintf("UPDATE `db882_faqtest`.`users` SET `is_available` = '%s' WHERE `users`.`uid` = '%s'", (isset($_POST['switch_available'])?"1":"0"), $_POST['uid']);
	$result = mysql_query($sql);
	if($result === FALSE) { 
	    die(mysql_error()); // TODO: better error handling
	}
	
// 	echo $link_home."/test.php?id=".encrypt($fid);
	
	$qidList = array();
	redirect("test.php");
?>