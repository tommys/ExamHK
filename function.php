<?php
	session_start();
	$link_home = "http://faqtest.swf.hk";
	$admin_email = "faqtest@swf.hk";
	
	$dbHost = "external-db.s882.gridserver.com";
	$dbUser = "db882_faqtest";
	$dbPW = "2##OB}d6ppq";
	
	$link;
	
	$lo_1 = "Invalid E-mail";
	$lo_2 = "Password Can't Empty";
	$lo_2a = "Password length at least 6 characters";
	$lo_3 = "E-mail & password not match";
	$reset_pw = "Sent Password Email";
	$reset_pw_success = "Reset Password Successfully.";
	$reset_pw_err = "Email does not existed.";
	
	$re_1 = "Invalid E-mail";
	$re_2 = "Password Can't Empty";
	$re_2a = "Password length at least 6 characters";
	$re_3 = "E-mail already existed";
	$re_success = "Registration Successfully";
	
	$f_1 = "Invalid E-mail";
	$f_2 = "E-mail doesn't existed";
	
	$user;

	function db_connect() {
		global $dbHost, $dbUser, $dbPW, $link;
		// Create connection
		$link = mysql_connect($dbHost, $dbUser, $dbPW);
		if (!$link) {
		    die('Could not connect: ' . mysql_error());
		}
	}
	function close_connect() {
		global $link;
		mysql_close($link);
	}
	
	function insertUser($email, $password) {
		$sql = sprintf("INSERT INTO `db882_faqtest`.`users` (`uid`, `email`, `password`, `name`, `fbid`, `is_available`, `created_date`, `updated_date`) 
			VALUES (NULL, '%s', '%s', NULL, NULL, '%s', '%s', NULL);", $email, md5($password), '1', date('Y-m-d H:i:s'));
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		if (!$result) {
			return "Error insert user data!";
		}
	}
	function checkUser() {
		$err = "";
		$isExisted = false;
		$sql = "";
		if( (isset($_SESSION['uname']) && $_SESSION['uname'] != "") &&
			(isset($_SESSION['upw']) && $_SESSION['upw'] != "")){
			$sql = sprintf("SELECT * FROM `db882_faqtest`.`users` WHERE `email` = '%s' AND `password` = '%s' AND `is_available` = '1'", $_SESSION['uname'], $_SESSION['upw'] );
		}
		if( (isset($_SESSION['fbid']) && $_SESSION['fbid'] != "") &&
			(isset($_SESSION['uid']) && $_SESSION['uid'] != "")){
			$sql = sprintf("SELECT * FROM `db882_faqtest`.`users` WHERE `fbid` = '%s' AND `uid` = '%s' AND `is_available` = '1'", $_SESSION['fbid'], $_SESSION['uid']);
		}
		if($sql != ""){
			$result = mysql_query($sql);
			if($result === FALSE) { 
			    die(mysql_error()); // TODO: better error handling
			}
			while ($row = mysql_fetch_array($result)) {  
				$isExisted = true;
				$user = $row;
			}
		}
		return $isExisted;
		
	}

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function redirect($url) {
		header("Location: ".$url);
		die();
	}
	
	function getAllTest() {
		$tests = array();
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`forms` WHERE `is_available` != '-1' ORDER BY `created_date` DESC");
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			array_push($tests, $row);
		}
		return $tests;
	}
	function getTestCategory(){
		$cats = array();
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`forms_cat` WHERE `is_available` != '-1' ORDER BY `created_date` ASC");
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			array_push($cats, $row);
		}
		return $cats;
	}
	function getAllTestCategory(){
		$cats = array();
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`forms_cat` ORDER BY `created_date` ASC");
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$cats[$row['forms_cat']] = $row;
		}
		return $cats;
	}
	function getAllAvailableTest(){
		$tests = array();
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`forms` WHERE `is_available` = '1' ORDER BY `created_date` DESC");
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			array_push($tests, $row);
		}
		return $tests;
	}
	function getAllAvailableTestWithCat($catid){
		$tests = array();
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`forms` WHERE `is_available` = '1' AND `cat` = '%s' ORDER BY `created_date` DESC", $catid);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			array_push($tests, $row);
		}
		return $tests;
	}
	
	function getTest($tid) {
		$test = array();
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`forms` WHERE `formid` = '%s'", $tid );
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$test = $row;
		}
		return $test;
	}
	function getQuestions($tid) {
		$questions = array();
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`questions` WHERE `fid` = '%s'", $tid );
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			array_push($questions, $row);
		}
		return $questions;
	}
	function getAnswers($qid) {
		$answers = array();
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`answers` WHERE `qid` = '%s'", $qid );
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			array_push($answers, $row);
		}
		return $answers;
	}
	function getLatestUAID($tid){
		$uaid = 0;
		$sql = sprintf("SELECT MAX(`db882_faqtest`.`users_answer`.`uaid`) as `maxuaid`
		FROM `db882_faqtest`.`questions`, `db882_faqtest`.`users_answer` 
		WHERE  `db882_faqtest`.`questions`.`qid` = `db882_faqtest`.`users_answer`.`qid` 
		AND `db882_faqtest`.`questions`.`fid` = '%s' 
		AND `db882_faqtest`.`users_answer`.`uid` = '%s' ", $tid, $_SESSION['uid']);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$uaid = $row['maxuaid'];
		}
		return $uaid;
	}
	function getLatestUAIDWithUID($tid, $uid){
		$uaid = 0;
		$sql = sprintf("SELECT MAX(`db882_faqtest`.`users_answer`.`uaid`) as `maxuaid`
		FROM `db882_faqtest`.`questions`, `db882_faqtest`.`users_answer` 
		WHERE  `db882_faqtest`.`questions`.`qid` = `db882_faqtest`.`users_answer`.`qid` 
		AND `db882_faqtest`.`questions`.`fid` = '%s' 
		AND `db882_faqtest`.`users_answer`.`uid` = '%s' ", $tid, $uid);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$uaid = $row['maxuaid'];
		}
		return $uaid;
	}
	function getUserAnswer($tid){
		$uaid = getLatestUAID($tid);
		
		$tests = array();
		$sql = sprintf("SELECT `db882_faqtest`.`questions`.`qid` as `qid`,  
		`db882_faqtest`.`questions`.`type` as `type`, 
		`db882_faqtest`.`questions`.`fid` as `fid` ,  
		`db882_faqtest`.`users_answer`.`answer` as `answer` 
		FROM `db882_faqtest`.`questions`, `db882_faqtest`.`users_answer` 
		WHERE  `db882_faqtest`.`questions`.`qid` = `db882_faqtest`.`users_answer`.`qid` 
		AND `db882_faqtest`.`questions`.`fid` = '%s' 
		AND `db882_faqtest`.`users_answer`.`uid` = '%s'
		AND `db882_faqtest`.`users_answer`.`uaid` = '%s'", $tid, $_SESSION['uid'], $uaid);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			if($row['type'] == "open"){
				$tests[$row['qid']] = $row['answer'];
			}else if($row['type'] == "option"){
				$tests[$row['qid']] = getUserOptionAnswer($row['answer']);
			}
		}
		return $tests;
	}
	function getUserAnswerWithUID($tid, $uid){
		$uaid = getLatestUAIDWithUID($tid, $uid);
		
		$tests = array();
		$sql = sprintf("SELECT `db882_faqtest`.`questions`.`qid` as `qid`,  
		`db882_faqtest`.`questions`.`type` as `type`, 
		`db882_faqtest`.`questions`.`fid` as `fid` ,  
		`db882_faqtest`.`users_answer`.`answer` as `answer` 
		FROM `db882_faqtest`.`questions`, `db882_faqtest`.`users_answer` 
		WHERE  `db882_faqtest`.`questions`.`qid` = `db882_faqtest`.`users_answer`.`qid` 
		AND `db882_faqtest`.`questions`.`fid` = '%s' 
		AND `db882_faqtest`.`users_answer`.`uid` = '%s'
		AND `db882_faqtest`.`users_answer`.`uaid` = '%s' ", $tid, $uid, $uaid);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			if($row['type'] == "open"){
				$tests[$row['qid']] = $row['answer'];
			}else if($row['type'] == "option"){
				$tests[$row['qid']] = getUserOptionAnswer($row['answer']);
			}
		}
		return $tests;
	}
	function getUserScore($tid){
		$uaid = getLatestUAID($tid);
		
		$score = 0;
		$sql = sprintf("SELECT *
			FROM `db882_faqtest`.`questions`, `db882_faqtest`.`users_answer`, `db882_faqtest`.`answers` 
			WHERE  `db882_faqtest`.`questions`.`qid` = `db882_faqtest`.`users_answer`.`qid` 
			AND `db882_faqtest`.`questions`.`type` = 'open'
			AND `db882_faqtest`.`answers`.`answer` = `db882_faqtest`.`users_answer`.`answer`
			AND `db882_faqtest`.`answers`.`qid` = `db882_faqtest`.`users_answer`.`qid`
			AND `db882_faqtest`.`answers`.`is_correct` = '1'
			AND `db882_faqtest`.`questions`.`fid` = '%s' 
			AND `db882_faqtest`.`users_answer`.`uid` = '%s' 
			AND `db882_faqtest`.`users_answer`.`uaid` = '%s' ", $tid, $_SESSION['uid'], $uaid);

		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$score = $score + $row['score'];
		}
		$sql = sprintf("SELECT `db882_faqtest`.`questions`.`qid` as `qid`,
			`db882_faqtest`.`questions`.`fid` as `fid` ,  
			`db882_faqtest`.`users_answer`.`answer` as `answer`, 
			`db882_faqtest`.`questions`.`score` as `score` 
			FROM `db882_faqtest`.`questions`, `db882_faqtest`.`users_answer`, `db882_faqtest`.`answers` 
			WHERE  `db882_faqtest`.`questions`.`qid` = `db882_faqtest`.`users_answer`.`qid` 
			AND `db882_faqtest`.`questions`.`type` = 'option'
			AND `db882_faqtest`.`answers`.`answerid` = `db882_faqtest`.`users_answer`.`answer`
			AND `db882_faqtest`.`answers`.`is_correct` = '1'
			AND `db882_faqtest`.`questions`.`fid` = '%s' 
			AND `db882_faqtest`.`users_answer`.`uid` = '%s'
			AND `db882_faqtest`.`users_answer`.`uaid` = '%s' ", $tid, $_SESSION['uid'], $uaid);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$score = $score + $row['score'];
		}
		return $score;
		
	}
	
	function getUserScoreWithUID($tid, $uid){
		$uaid = getLatestUAIDWithUID($tid, $uid);
		
		$answered = false;
		$sql = sprintf("SELECT *
			FROM `db882_faqtest`.`questions`, `db882_faqtest`.`users_answer`
			WHERE `db882_faqtest`.`questions`.`qid` = `db882_faqtest`.`users_answer`.`qid` 
			AND `db882_faqtest`.`questions`.`fid` = '%s' 
			AND `db882_faqtest`.`users_answer`.`uid` = '%s'
			AND `db882_faqtest`.`users_answer`.`uaid` = '%s'  ", $tid, $uid, $uaid);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$answered = true;
		}
	
		if($answered == false){
			return -1;
		}
	
		$score = 0;
		$sql = sprintf("SELECT *
			FROM `db882_faqtest`.`questions`, `db882_faqtest`.`users_answer`, `db882_faqtest`.`answers` 
			WHERE  `db882_faqtest`.`questions`.`qid` = `db882_faqtest`.`users_answer`.`qid` 
			AND `db882_faqtest`.`questions`.`type` = 'open'
			AND `db882_faqtest`.`answers`.`answer` = `db882_faqtest`.`users_answer`.`answer`
			AND `db882_faqtest`.`answers`.`qid` = `db882_faqtest`.`users_answer`.`qid`
			AND `db882_faqtest`.`answers`.`is_correct` = '1'
			AND `db882_faqtest`.`questions`.`fid` = '%s' 
			AND `db882_faqtest`.`users_answer`.`uid` = '%s'
			AND `db882_faqtest`.`users_answer`.`uaid` = '%s'  ", $tid, $uid, $uaid);

		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$score = $score + $row['score'];
		}
		$sql = sprintf("SELECT `db882_faqtest`.`questions`.`qid` as `qid`,
			`db882_faqtest`.`questions`.`fid` as `fid` ,  
			`db882_faqtest`.`users_answer`.`answer` as `answer`, 
			`db882_faqtest`.`questions`.`score` as `score` 
			FROM `db882_faqtest`.`questions`, `db882_faqtest`.`users_answer`, `db882_faqtest`.`answers` 
			WHERE  `db882_faqtest`.`questions`.`qid` = `db882_faqtest`.`users_answer`.`qid` 
			AND `db882_faqtest`.`questions`.`type` = 'option'
			AND `db882_faqtest`.`answers`.`answerid` = `db882_faqtest`.`users_answer`.`answer`
			AND `db882_faqtest`.`answers`.`is_correct` = '1'
			AND `db882_faqtest`.`questions`.`fid` = '%s' 
			AND `db882_faqtest`.`users_answer`.`uid` = '%s' 
			AND `db882_faqtest`.`users_answer`.`uaid` = '%s' ", $tid, $uid, $uaid);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$score = $score + $row['score'];
		}
		return $score;
		
	}
	function getUserOptionAnswer($aid){
		$answer = "";
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`answers` WHERE  `db882_faqtest`.`answers`.`answerid` = '%s' ", $aid);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) {
			$answer = $row['answer'];
		}
		return $answer;
	}
	
	function getUserInfo(){
		$user = array();
		if( !isset($_SESSION['uid']) || $_SESSION['uid'] == "" ){
			return false;
		}
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`users` WHERE `uid` = '%s'", $_SESSION['uid']);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) { 
			$user = $row;
		}
		return $user;
	}
	
	function getUserInfoWithID($uid){
		$user = array();
		$sql = sprintf("SELECT * FROM `db882_faqtest`.`users` WHERE `uid` = '%s'", $uid);
		$result = mysql_query($sql);
		if($result === FALSE) { 
		    die(mysql_error()); // TODO: better error handling
		}
		while ($row = mysql_fetch_array($result)) { 
			$user = $row;
		}
		return $user;
	}
	
	function checkUID($email, $code){
		$uid = "-1";
		if($code != ""){
			$sql = sprintf("SELECT * FROM `db882_faqtest`.`users` WHERE `email` = '%s' && `reset_code` = '%s'", $email, $code);
			$result = mysql_query($sql);
			if($result === FALSE) { 
			    die(mysql_error()); // TODO: better error handling
			}
			while ($row = mysql_fetch_array($result)) { 
				$uid = $row['uid'];
			}
		}
		return $uid;
	}

	// Encrypt Function
	function encrypt($encrypt){
		return base64_encode($encrypt);
	}
	// Decrypt Function
	function decrypt($decrypt){
		return base64_decode($decrypt);
	}
	
	function generateRandomString($length = 10) {
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
    	$randomString = '';
	    for ($i = 0; $i < $length; $i++) {
    	    $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
    	return $randomString;
	}
?>