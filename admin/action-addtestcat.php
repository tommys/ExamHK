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
	$sql = sprintf("INSERT INTO `db882_faqtest`.`forms_cat` (`forms_cat`, `name`, `is_available`,  `created_date`, `updated_date`) 
		VALUES (NULL, '%s', '%s', '%s', NULL);", $_POST['name'], '1', date('Y-m-d H:i:s'));
	$result = mysql_query($sql);
	if($result === FALSE) { 
	    die(mysql_error()); // TODO: better error handling
	}
	
	// get test id
	$fid = mysql_insert_id();
// 	echo $link_home."/test.php?id=".encrypt($fid);
	
	redirect('testscat.php');
?>