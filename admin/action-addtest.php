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
	$sql = sprintf("INSERT INTO `db882_faqtest`.`forms` (`formid`, `cat`, `name`, `is_available`, `created_date`, `updated_date`) 
		VALUES (NULL, '%s','%s', '%s', '%s', NULL);", $_POST['category'], $_POST['name'], '1', date('Y-m-d H:i:s'));
	$result = mysql_query($sql);
	if($result === FALSE) { 
	    die(mysql_error()); // TODO: better error handling
	}
	
	// get test id
	$fid = mysql_insert_id();
// 	echo $link_home."/test.php?id=".encrypt($fid);
	
	$qidList = array();
	// for loop questions
	foreach ($_POST as $key=>$post){
		if (strpos($key, 'q_name_') !== false) {
			// get post qid
			$pid = str_replace('q_name_', '', $key);
		
			if($_POST['q_name_'.$pid] == ""){
				continue;
			}
		
			// get question content
			// open question 
			if($_POST['q_type_'.$pid] == 'open'){
				// insert open question
				$sql = sprintf("INSERT INTO `db882_faqtest`.`questions` (`qid`, `fid`, `question`, `image`, `type`, `is_shuffle`, `score`, `created_date`, `updated_date`, `order`) 
					VALUES (NULL, '%s', '%s', '', '%s', '', '%s', '%s', NULL, '0');", $fid, $_POST['q_name_'.$pid], $_POST['q_type_'.$pid], $_POST['q_score_'.$pid] , date('Y-m-d H:i:s'));
				$result = mysql_query($sql);
				if($result === FALSE) { 
				    die(mysql_error()); // TODO: better error handling
				}
				$qid = mysql_insert_id();
				
				// upload image if existed
				if(isset($_FILES['q_image_'.$pid])){
					$uploaddir = dirname(dirname(__FILE__));
					
					if (!file_exists($uploaddir . '/uploads/'.$fid.'/'.$qid.'/')) {
					    mkdir($uploaddir . '/uploads/'.$fid.'/'.$qid.'/', 0777, true);
					}
					$qimage = basename($_FILES['q_image_'.$pid]['name']);
					$uploadfile = $uploaddir . '/uploads/'.$fid.'/'.$qid.'/'. $qimage;
					move_uploaded_file($_FILES['q_image_'.$pid]['tmp_name'], $uploadfile);
					
					$sql = sprintf("UPDATE `db882_faqtest`.`questions` SET `image` = '%s' WHERE `qid` = '%s' ", $qimage ,$qid);
					$result = mysql_query($sql);
				}
				
				// insert open answer 
				$sql = sprintf("INSERT INTO `db882_faqtest`.`answers` (`answerid`, `qid`, `answer`, `image`, `is_correct`) 
					VALUES (NULL, '%s', '%s', '' , '1');", $qid, $_POST['q_answer_'.$pid]);
				$result = mysql_query($sql);
				if($result === FALSE) { 
				    die(mysql_error()); // TODO: better error handling
				}
			}else if($_POST['q_type_'.$pid] == 'option'){
				// multiple question
				// insert open question
				$sql = sprintf("INSERT INTO `db882_faqtest`.`questions` (`qid`, `fid`, `question`, `image`, `type`, `is_shuffle`, `score`, `created_date`, `updated_date`, `order`) 
					VALUES (NULL, '%s', '%s', '', '%s', '%s', '%s', '%s', NULL, '0');", $fid, $_POST['q_name_'.$pid], $_POST['q_type_'.$pid], (isset($_POST['q_shuffle_'.$pid])?"1":"0"), $_POST['q_score_'.$pid], date('Y-m-d H:i:s'));
				$result = mysql_query($sql);
				if($result === FALSE) { 
				    die(mysql_error()); // TODO: better error handling
				}
				$qid = mysql_insert_id();
				
				// upload image if existed
				if(isset($_FILES['q_image_'.$pid])){
					$uploaddir = dirname(dirname(__FILE__));
					
					if (!file_exists($uploaddir . '/uploads/'.$fid.'/'.$qid.'/')) {
					    mkdir($uploaddir . '/uploads/'.$fid.'/'.$qid.'/', 0777, true);
					}
					$qimage = basename($_FILES['q_image_'.$pid]['name']);
					$uploadfile = $uploaddir . '/uploads/'.$fid.'/'.$qid.'/'. $qimage;
					move_uploaded_file($_FILES['q_image_'.$pid]['tmp_name'], $uploadfile);
					
					$sql = sprintf("UPDATE `db882_faqtest`.`questions` SET `image` = '%s' WHERE `qid` = '%s' ", $qimage ,$qid);
					$result = mysql_query($sql);
				}
				
				$i = 0;
				foreach($_POST['q_multi_answer_'.$pid] as $key => $multi_val){
					if( trim($multi_val) != "" ){
						$sql = sprintf("INSERT INTO `db882_faqtest`.`answers` (`answerid`, `qid`, `answer`, `image`, `is_correct`) 
							VALUES (NULL, '%s', '%s', '', %d);", $qid, $multi_val, ($_POST['q_answer_correct_'.$pid] == $i?1:0));
						$result = mysql_query($sql);
						if($result === FALSE) { 
						    die(mysql_error()); // TODO: better error handling
						}
						$aid = mysql_insert_id();
						
						// upload image if existed
						if($_FILES['q_multi_answer_img_'.$pid]['name'][$key]){
							$uploaddir = dirname(dirname(__FILE__));
					
							if (!file_exists($uploaddir . '/uploads/'.$fid.'/'.$qid.'/')) {
							    mkdir($uploaddir . '/uploads/'.$fid.'/'.$qid.'/', 0777, true);
							}
							$aimage = basename($_FILES['q_multi_answer_img_'.$pid]['name'][$key]);
							$uploadfile = $uploaddir . '/uploads/'.$fid.'/'.$qid.'/'. $aimage;   
							move_uploaded_file($_FILES['q_multi_answer_img_'.$pid]['tmp_name'][$key], $uploadfile);
					
							$sql = sprintf("UPDATE `db882_faqtest`.`answers` SET `image` = '%s' WHERE `answerid` = '%s' ", $aimage ,$aid);
							$result = mysql_query($sql);
						}

						$i++;
					}
				}
			}
		}	
	}
	redirect('test.php?id='.$fid);
?>