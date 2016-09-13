<?php
	include("function.php");
	db_connect();
	if(!checkAdmin()){
		redirect("login.php");
	}
	$users = getUsers(null, true);
	
	$testscat = getTestCategory();
	
	$page = "test";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Test</title>
	<link media="all" rel="stylesheet" type="text/css" href="css/all.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
	
	<script>
		$(document).ready(function(){
			$question_id = 1;
			$multiple_question_html = $(".form-multiple-ans").html();
			$("#add-question").click(function(){
				$formQuestion = $("#form-question").html();
				$formQuestion = $formQuestion.replace(/questionid/g, $question_id);
				$("#form-questions").append($formQuestion);
				$question_id++;
			});
			
			$multiple_ans = 1;
			// submit question
			$("#submit-question").click(function(){
				// form validation
			
				// form submit
				$("#add-test-form").submit();
				
// 				$.ajax({
//   					type: "POST",
//   					dataType: 'text',  // what to expect back from the PHP script, if anything
//         	        cache: false,
//     	            contentType: false,
// 	                processData: false,
//   					url: $("#add-test-form").attr("action"),
//  					data: $("#add-test-form").serialize(),
//   					success: function(){
//   						$("#form-question").slideUp();
// 						$(".form-multiple-ans-block").html($multiple_question_html);
// 						
// 						// return question id & name
// 						$qid = 1;
// 						$qname = "Question: "+$("#q_name").val();
// 						
// 						$("#form-questions").append('<input type="hidden" name="q_id[]" value="'+$qid+'" />'+ $qname + '<br/>');
// 						
// 						$("#add-question").show();
// 						
// 						// reset value
// 						$("#q_name").val("");
// 						$("#q_answer").val("");
// 						$("#q_type").val("open");
// 						$(".form-single").show();
// 						$(".form-multiple").hide();
// 						multiple_ans = 1;
//   					},
// 				});
			
			});
			
			
			$(".q_type").live( "change", function() {
				console.log($(this).val());
				if($(this).val() == "option"){
					$(this).parent().parent().find(".form-single").hide();
					$(this).parent().parent().find(".form-multiple").show();
				}else if($(this).val() == "open"){
					$(this).parent().parent().find(".form-single").show();
					$(this).parent().parent().find(".form-multiple").hide();
				}
			});
			
			$(".add-multiple-ans").live( "click", function(){
			
				$multiple_ans = $(this).parent().find(".form-multiple-ans-block").find(".form-multiple-ans").length;
				$multipleHtml = $(this).parent().find(".form-multiple-ans-block").find(".form-multiple-ans").html();
				$multipleHtml = $multipleHtml.replace(/checked/g, '');
				$multipleHtml = $multipleHtml.replace(/value="0"/g, 'value="'+$multiple_ans+'"');
				
				$(this).parent().find(".form-multiple-ans-block").append('<div class="form-multiple-ans">'+$multipleHtml+'</div>');
			}); 
		});
	</script>
</head>
<body>
	<div id="wrapper">
		<div id="content">
			<div class="c1">
				<?php include("controls.php");?>
				<div class="tabs">
					<div id="tab-1" class="tab">
						<div class="text-section">
							<h1>Add Tests</h1>
							<p>This is a quick overview of some features</p>
						</div>
						<div class="block-users">
							<div class="form-test">
								<form action="action-addtest.php" id="add-test-form" method="POST" enctype="multipart/form-data">
									<div class="input-block">Test Name: <input type="text" name="name" /></div>
									<div class="input-block">
										Category: 
										<select name="category">
											<?php foreach($testscat as $cat){ ?>
												<option value="<?php echo $cat['forms_cat'];?>"><?php echo $cat['name'];?></option>
											<?php }?>
										</select>
									</div>
									<div id="form-questions">
									</div>
									<div class="input-block">
										<input type="button" id="add-question" value="Add Question"/>
									</div>
									<hr/>
									<div class="input-block"><input type="submit" value="Submit"/></div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("sidebar.php");?>
	</div>
	
	<div style="display:none">
		<div id="form-question">
			<div class="question">
				<div>
					<div class="form-question-name fl">Question Name: </div><input type="text" name="q_name_questionid" class="q_name" />
				</div>
				<div>
					<div class="form-question-type fl">Question Type: </div><select type="text" name="q_type_questionid" class="q_type" ><option value="open">Open Question</option><option value="option">Options Question</option></select>
				</div>
				<div>
					<div class="form-question-name fl">Image: </div><input type="file" name="q_image_questionid" class="q_image" />
				</div>
				<div>
					<div class="form-question-ans">Answer(s): </div>
					<div class="form-single">
						<input type="text" name="q_answer_questionid" />
					</div>
					<div class="form-multiple" style="display: none;">
						<div class="form-multiple-ans-block">
							<div class="form-multiple-ans">
								<input type="radio" name="q_answer_correct_questionid" class="q_answer_correct" value="0" checked/>
								<input type="text" name="q_multi_answer_questionid[]" />
								Image: <input type="file" name="q_multi_answer_img_questionid[]"/>
							</div>
						</div>
						<input type="button" class="add-multiple-ans" value="Add More Answer"/>
						<br/>
						<label><input type="checkbox" class="" name="q_shuffle_questionid" checked="checked"/> Shuffle</label>
					</div>
				</div>
				<div>
					<div class="form-question-type fl">Score: </div><input type="text" name="q_score_questionid" class="q_score" value="10" />
				</div>
			</div>
		</div>
	</div>
</body>
</html>