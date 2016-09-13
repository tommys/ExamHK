<?php
	include("function.php");
	db_connect();
	if(!checkUser()){
		redirect("home.php");
	}
// 	echo "<pre>";
// 	var_dump($_POST);
// 	echo "</pre>";
// 	echo "seessssion".$_SESSION['uid'];
	// insert answer
	foreach ($_POST as $key=>$val){
		if (strpos($key, 'question_') !== false) {
			// get post qid
			$pid = str_replace('question_', '', $key);
			
			$auid = 0;
			$sql = sprintf("SELECT count(`db882_faqtest`.`users_answer`.`answer`) as `cnt` 
				FROM `db882_faqtest`.`users_answer` 
				WHERE  `db882_faqtest`.`users_answer`.`uid` = '%s' 
				AND `db882_faqtest`.`users_answer`.`qid` = '%s'", $_SESSION['uid'], $pid);
			$result = mysql_query($sql);
			if($result === FALSE) { 
			    die(mysql_error()); // TODO: better error handling
			}
			while ($row = mysql_fetch_array($result)) {
				$auid = $row['cnt'];
			}
		
			$sql = sprintf("INSERT INTO `db882_faqtest`.`users_answer` (`uaid`, `uid`, `qid`, `answer`, `created_date`, `updated_date`) 
				VALUES ('%s', '%s', '%s', '%s', '%s', NULL);", $auid, $_SESSION['uid'], $pid, $val, date('Y-m-d H:i:s'));
			$result = mysql_query($sql);
			if($result === FALSE) { 
			    die(mysql_error()); // TODO: better error handling
			}
		}
	}
	
	redirect('test.php?id='.encrypt($_POST['fid']));
?>