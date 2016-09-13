<?php
	include("function.php");
	if(!checkAdmin()){
		redirect("login.php");
	}
	db_connect();
	$userid = $_GET['uid'];
	$user = getUserInfoWithID($userid);
	$getid = $_GET['fid'];
	$test = getTest($getid);
	$questions = getQuestions($getid);
	
	$userAns = getUserAnswerWithUID($getid, $userid);
	if(count($userAns) > 0){ 
		$score = getUserScoreWithUID($getid, $userid);
	}
	$totalScore = 0;
	foreach($questions as $question){
		$totalScore = $totalScore + $question['score']; 
	}
	$page = "users";
?>
<!DOCTYPE html>
<html>
<head>
	<link media="all" rel="stylesheet" type="text/css" href="css/all.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
</head>
<body>

	<div id="wrapper">
		<div id="content">
			<div class="c1">
				<?php include("controls.php");?>
				<div class="tabs">
					<div id="tab-1" class="tab">
						<div class="text-section">
							<h1><?php echo $user['name'];?></h1>
							<p><?php echo $user['email'];?></p>
							<p>
								Test name: <?php echo $test['name'];?>
							</p>
							<p>
								<?php if($userAns == false){ ?>
									<span class="final-score">Not finished yet</span>
								<?php }else{?>
									<span class="final-score"><?php echo $score;?>/<?php echo $totalScore;?></span>
								<?php }?>
							</p>
						</div>
						<p class="btn-back"><a href="user.php?uid=<?php echo $userid;?>">Back</a></p>
						<div class="user_test_content">
						<h1><?php echo $test['name'];?></h1>
						<hr/>
						<?php if($test['is_available']=="0"){ ?>
						<p>This is not available now.</p>
						<?php }else{ ?>
						<form action="action-submittest.php" method="POST" >
						<div>
						<?php foreach($questions as $question){ ?>
							<h2><?php echo $question['question'];?> <span class="score">(score: <?php echo $question['score'];?>)</span></h2>
							<?php if( $question['image'] != "" ){?>
							<div class="question-img">
								<img src="../uploads/<?php echo $question['fid'];?>/<?php echo $question['qid'];?>/<?php echo $question['image'];?>" class="answer_img"/>
							</div>
							<?php } ?>
							<?php if($question['type']=="open"){
								$answer = getAnswers($question['qid']);
							?>
							<input type="text" name="question_<?php echo $question['qid'];?>" value="<?php echo $userAns[$question['qid']];?>" <?php echo (isset($userAns[$question['qid']])?"disabled":"" );?>/>
							<?php if(count($userAns) > 0 && $answer[0]['is_correct'] == "1"){ ?>
								(Correct Answer: <?php echo $answer[0]['answer'];?>)
							<?php }?>
						<?php }else if($question['type']=="option"){ 
		
							$answers = getAnswers($question['qid']);
							foreach($answers as $answer){
						?>
							<div>
								<input type="radio" name="question_<?php echo $question['qid'];?>" id="question_<?php echo $question['qid'];?>_<?php echo $answer['answerid'];?>" value="<?php echo $answer['answerid'];?>" <?php echo (isset($userAns[$question['qid']])?"disabled":"" );?> <?php echo (isset($userAns[$question['qid']]) && $userAns[$question['qid']] == $answer['answer'])?"checked":"";?>/>
								<label for="question_<?php echo $question['qid'];?>_<?php echo $answer['answerid'];?>"><?php echo $answer['answer'];?></label>
								<?php if( $answer['image'] != "" ){?>
								<div>
									<img src="../uploads/<?php echo $question['fid'];?>/<?php echo $question['qid'];?>/<?php echo $answer['image'];?>" class="answer_img"/>
								</div>
							<?php } ?>
							<?php if(count($userAns) > 0 && $answer['is_correct'] == "1"){ ?>
								<span class="correct-ans">(Correct Answer)</span>
							<?php } ?>
						</div>
						<?php
							}
							?>
					<?php } ?>
						<hr/>
				<?php } ?>
				</div>
				<input type="hidden" name="fid" value="<?php echo $getid;?>" />
				<div class="score">
				<?php if($userAns == false){ ?>
					<span class="final-score">Not finished yet</span>
				<?php }else if(count($userAns) > 0){ ?>
					<div class="final-score"><?php echo $score;?>/<?php echo $totalScore;?></div>
				<?php } ?>
				</div>
				</form>
				<?php }?>

				</div>
	
	
				<p class="btn-back"><a href="user.php?uid=<?php echo $userid;?>">Back</a></p>
					</div>
				</div>
			</div>
		</div>
		<?php include("sidebar.php");?>
	</div>
</body>
</html>