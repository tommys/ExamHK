<?php
	session_start();
	include("../function.php");
	$link_home = "http://faqtest.swf.hk";
	$link_admin = "http://faqtest.swf.hk/admin";
	$admin_email = "faqtest@swf.hk";
	
	$auser = "admin";
	$apw = "qazwsx123";
	
	$dbHost = "external-db.s882.gridserver.com";
	$dbUser = "db882_faqtest";
	$dbPW = "2##OB}d6ppq";
	
	$link;
	
	$lo_1 = "Invalid E-mail";
	$lo_2 = "Password Can't Empty";
	$lo_2a = "Password length at least 6 characters";
	$lo_3 = "E-mail & password not match";
	$reset_pw = "Sent Password Email";
	
	$re_1 = "Invalid E-mail";
	$re_2 = "Password Can't Empty";
	$re_2a = "Password length at least 6 characters";
	$re_3 = "E-mail already existed";
	$re_success = "Registration Successfully";
	
	$f_1 = "Invalid E-mail";
	$f_2 = "E-mail doesn't existed";
	
	$user;

	
	function checkAdmin() {
		global $auser, $apw;
		$isExisted = false;
		if( !isset($_SESSION['auser']) || $_SESSION['auser'] == "" ||
			!isset($_SESSION['apw']) || $_SESSION['apw'] == "" ){
			$isExisted = false;
		}
		if($_SESSION['auser'] == $auser && $_SESSION['apw'] == $apw){
			$isExisted = true;
		}
		return $isExisted;
	}
	function adminLogin($in_uname, $in_pw) {
		global $auser, $apw;
		if($in_uname == $auser && $in_pw == $apw){
			$_SESSION['auser'] = $in_uname;
			$_SESSION['apw'] = $in_pw;
			return true;
		}else{
			return false;
		}
	}
	function getQuestionsCount($testid) {
		$count = 0;
		$sql = sprintf("SELECT Count(`qid`) as count FROM `db882_faqtest`.`questions`
						WHERE `db882_faqtest`.`questions`.`fid` = '%s'", $testid);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$count = $row['count'];
		}
		return $count;
	}
	function getUsers($limit, $isLatest) {
		$users = array();
		$sql = "SELECT * FROM `db882_faqtest`.`users` WHERE `is_available` != '-1' ";
		if($isLatest){
			$sql .= "ORDER BY `updated_date` DESC ";
		}
		if($limit != ""){
			$sql .= "LIMIT ".$limit;
		}
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			array_push($users, $row);
		}
		return $users;
	}


?>