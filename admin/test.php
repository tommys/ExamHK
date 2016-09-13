<?php
	include("function.php");
	if(!checkAdmin()){
		redirect("login.php");
	}
	db_connect();
	$page = "test";
	$getid = $_GET['id'];
	$test = getTest($getid);
	$questions = getQuestions($getid);
	
	$userAns = getUserAnswer($getid);
	if(count($userAns) > 0){ 
		$score = getUserScore($getid);
	}
	$totalScore = 0;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link media="all" rel="stylesheet" type="text/css" href="css/all.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    
    
	<script type="text/javascript" src="js/jquery.switchButton.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/jquery.switchButton.css">
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
	
	<script>
		$(document).ready(function(){
			$("input[type=checkbox]").switchButton({
				on_label: 'Enable',
				off_label: 'Disable'
			});
			$("#switch_available").change(function(){
				// form submit
				$.ajax({
  					type: "POST",
  					url: $("#form-available").attr("action"),
 					data: $("#form-available").serialize(),
  					success: function(){
  						$('.form-status').slideDown();
  						
  						setTimeout(function(){
  							$('.form-status').slideUp();
  						}, 2000);
  					},
				});
			});
		});
	</script>
</head>
<body>

	<div id="wrapper">
		<div id="content">
			<div class="c1">
				<?php include("controls.php");?>
				<div class="form-status">
					<p>Updated.</p>
				</div>
				<div class="question-content"> 
				<h1><?php echo $test['name'];?></h1>
				<hr/>
				<?php foreach($questions as $question){ ?>
				<h2><?php echo $question['question'];?> <span class="score">(score: <?php echo $question['score'];?>)</span></h2>
				<?php if( $question['image'] != "" ){?>
				<div class="question-img">
					<img src="../uploads/<?php echo $question['fid'];?>/<?php echo $question['qid'];?>/<?php echo $question['image'];?>" class="answer_img" />
				</div>
				<?php } ?>
				<?php if($question['type']=="open"){
					$answer = getAnswers($question['qid']);
				?>
					<input type="text" name="question_<?php echo $question['qid'];?>" value="<?php echo $userAns[$question['qid']];?>" <?php echo (isset($userAns[$question['qid']])?"disabled":"" );?>/>
					(Correct Answer: <?php echo $answer[0]['answer'];?>)
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
							<img src="../uploads/<?php echo $question['fid'];?>/<?php echo $question['qid'];?>/<?php echo $answer['image'];?>" class="answer_img" />
						</div>
						<?php } ?>
						<?php if($answer['is_correct'] == "1"){ ?>
							<span class="correctAns">(Correct Answer)</span>
						<?php } ?>
					</div>
				<?php
					}
				?>
				<div>Is Shuffle: <?php echo ($question['is_shuffle']=="1"?"YES":"NO");?></div>
				<?php } ?>
				<hr/>
				<?php } ?>
				
				<form id="form-available" action="action-available.php">
					<div class="switch-wrapper">
						<input type="hidden" name="test_id" value="<?php echo $test['formid'];?>" />
						<input id="switch_available" name="switch_available" type="checkbox" value="1" <?php echo ($test['is_available']=='1'?"checked":"");?>>
					</div>
				</form>
				</div>
			</div>
		</div>
		<?php include("sidebar.php");?>
	</div>
</body>
</html>