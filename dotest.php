<?php
	include("function.php");
	db_connect();
	if(!checkUser()){
		redirect("index.php");
	}
	$getid = decrypt($_GET['id']);
	$test = getTest($getid);
	$questions = getQuestions($getid);
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Test - <?php echo $test['name'];?></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	
</head>
<body>

	<div class="content">
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
			<img src="uploads/<?php echo $question['fid'];?>/<?php echo $question['qid'];?>/<?php echo $question['image'];?>" class="answer_img"/>
		</div>
		<?php } ?>
		<?php if($question['type']=="open"){
			$answer = getAnswers($question['qid']);
		?>
				<input type="text" name="question_<?php echo $question['qid'];?>" value="<?php echo $userAns[$question['qid']];?>" <?php echo (isset($userAns[$question['qid']])?"disabled":"" );?>/>
				<?php if(false && count($userAns) > 0 && $answer[0]['is_correct'] == "1"){ ?>
				(Correct Answer: <?php echo $answer[0]['answer'];?>)
				<?php }?>
		<?php }else if($question['type']=="option"){ 
		
			$answers = getAnswers($question['qid']);
			if($question['is_shuffle'] == "1"){
				shuffle($answers);
			}
			foreach($answers as $answer){
		?>
				<div>
					<input type="radio" name="question_<?php echo $question['qid'];?>" id="question_<?php echo $question['qid'];?>_<?php echo $answer['answerid'];?>" value="<?php echo $answer['answerid'];?>" <?php echo (isset($userAns[$question['qid']])?"disabled":"" );?> <?php echo (isset($userAns[$question['qid']]) && $userAns[$question['qid']] == $answer['answer'])?"checked":"";?>/>
					<label for="question_<?php echo $question['qid'];?>_<?php echo $answer['answerid'];?>"><?php echo $answer['answer'];?></label>
					<?php if( $answer['image'] != "" ){?>
					<div>
						<img src="uploads/<?php echo $question['fid'];?>/<?php echo $question['qid'];?>/<?php echo $answer['image'];?>" class="answer_img" />
					</div>
					<?php } ?>
					<?php if(false && count($userAns) > 0 && $answer['is_correct'] == "1"){ ?>
						<span class="correct-ans">(Correct Answer)</span>
					<?php } ?>
				</div>
		<?php
			}
		?>
		<?php } ?>
		<hr/>
		<?php $totalScore = $totalScore + $question['score']; ?>
	<?php } ?>
	</div>
	<input type="hidden" name="fid" value="<?php echo $getid;?>" />
	<input type="submit" vallue="Submit" />
	</form>
	<?php }?>

	<p><a href="mytest.php">Back</a></p>
	</div>
</body>
</html>