<?php
	include("function.php");
	if(!checkAdmin()){
		redirect("login.php");
	}
	db_connect();
	$userid = $_GET['uid'];
	$user = getUserInfoWithID($userid);
	$tests = getAllAvailableTest();
	$page = "users";
	$cats = getAllTestCategory();
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
			$('.delete_user').click(function(){
				if(confirm("Are you sure to delete this user?")){
					// post to delete this test.
					$userid = $(this).attr('id');
					$userid = $userid.replace("delete_", "");
					$.ajax({
						type: "POST",
				        url: "action-deleteuser.php",
				        data: {user_id: $userid},
				        dataType: "json",
				        success: function( data ) {
			            	window.location = "users.php";
          				}
					});
				}
			});
			$('.reset_pw').click(function(){
					// post to delete this test.
				$userid = $(this).attr('id');
				$userid = $userid.replace("resetpassword_", "");
				$.ajax({
					type: "POST",
				    url: "action-resendemail.php",
				    data: {user_id: $userid, email: "<?php echo $user['email'];?>"},
				    dataType: "json",
				    success: function( data ) {
				    	alert("Reset and sent a new password to <?php echo $user['email'];?>");
			        	window.location.reload();
          			}
				});
			});
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
  						$('.form-status p').html("Updated Successfully");
  						$('.form-status').slideDown();
  						
  						setTimeout(function(){
  							$('.form-status').slideUp();
  						}, 2000);
  					},
				});
			});
			$("#category").change(function(){
				// form submit
				$.ajax({
  					type: "POST",
  					url: $("#form-changecat").attr("action"),
 					data: $("#form-changecat").serialize(),
  					success: function(){
  						$('.form-status p').html("Updated Successfully");
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
				<div class="tabs">
					<div id="tab-1" class="tab">
						<div class="text-section">
							<h1><?php echo $user['name'];?></h1>
							<p><?php echo $user['email'];?></p>
						</div>
						<div class="form-status"><p></p></div>
						<p class="btn-back"><a href="users.php">Back</a></p>
						<div class="block-users">
							<table class="table-users" border="1" >
								<tr class="odd">
									<td>ID</td>
									<td><?php echo $user['uid'];?></td>
								</tr>
								<tr class="even">
									<td>Name</td>
									<td><?php echo $user['name'];?></td>
								</tr>
								<tr class="odd">
									<td>E-mail</td>
									<td><?php echo $user['email'];?></td>
								</tr>
								<tr class="even">
									<td>Status</td>
									<td>						
									<form id="form-available" action="action-user-available.php">
										<div class="switch-wrapper">
											<input type="hidden" name="uid" value="<?php echo $user['uid'];?>" />
											<input id="switch_available" name="switch_available" type="checkbox" value="1" <?php echo ($user['is_available']=='1'?"checked":"");?>>
										</div>
									</form>
									</td>
								</tr>
								<tr class="even">
									<td>Category</td>
									<td>
									<form id="form-changecat" action="action-user-changecat.php">
										<input type="hidden" name="uid" value="<?php echo $user['uid'];?>" />
										<select name="category" id="category">
											<?php foreach($cats as $cat){ ?>
											<option value="<?php echo $cat['forms_cat'];?>" <?php echo ($cat['forms_cat']==$user['cat']?'selected="selected"':'');?>><?php echo $cat['name'];?></option>
											<?php } ?>
										</select>
									</form>
									</td>
								</tr>
								<tr class="odd">
									<td>Created Date</td>
									<td><?php echo $user['created_date'];?></td>
								</tr>
								<tr class="even">
									<td>Update Date</td>
									<td><?php echo $user['updated_date'];?></td>
								</tr>
								<tr class="odd">
									<td>Action</td>
									<td>
										<a class="delete_user" id="delete_<?php echo $user['uid'];?>"><img src="images/Delete-48.png" width="18" /></a>
									</td> 
								</tr>
								<tr class="even">
									<td>Reset Password</td>
									<td>
										<a class="reset_pw" id="resetpassword_<?php echo $user['uid'];?>">Resend</a>
									</td> 
								</tr>
							</table>
						</div>
						
						<div class="tests">
							<h1>Tests</h1>
								<table>
									<tr>
										<td>id</td>
										<td>Name</td>
										<td>Score</td>
										<td>Action</td>
									</tr>
							<?php
								foreach($tests as $test){
									$score = getUserScoreWithUID($test['formid'], $userid);
							?>
									<tr>
										<td><?php echo $test['formid'];?></td>
										<td><?php echo $test['name'];?></td>
										<td><?php echo ($score>=0?$score:"Not finished yet");?></td>
										<td>
										<a href="user-test.php?uid=<?php echo $userid;?>&fid=<?php echo $test['formid'];?>"><img src="images/Search-48.png" width="18" /></a>
										</td>
									</tr>
							<?php
								}
							?>
								</table>
						</div>
						<p class="btn-back"><a href="users.php">Back</a></p>
					</div>
				</div>
			</div>
		</div>
		<?php include("sidebar.php");?>
	</div>
</body>
</html>