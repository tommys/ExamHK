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
	$sql = sprintf("UPDATE `db882_faqtest`.`forms_cat` SET `is_available` = '%s' WHERE `forms_cat`.`forms_cat` = '%s'", '-1', $_POST['tid']);
	$result = mysql_query($sql);
	if($result === FALSE) { 
	    die(mysql_error()); // TODO: better error handling
	}
// 	echo $link_home."/test.php?id=".encrypt($fid);
	
	$qidList = array();
	return json_encode(array("status"=>"true"));
?>