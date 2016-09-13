<?php
	include("function.php");
	if(!checkAdmin()){
		redirect("login.php");
	}
	db_connect();
	$page = "test";
	$tests = getAllTest();
	$cats = getAllTestCategory();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link media="all" rel="stylesheet" type="text/css" href="css/all.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="css/ie.css" /><![endif]-->
	
	<script>
		$(document).ready(function(){
			$('.delete_test').click(function(){
				if(confirm("Are you sure to delete this test?")){
					// post to delete this test.
					$testid = $(this).attr('id');
					$testid = $testid.replace("delete_", "");
					$.ajax({
						type: "POST",
				        url: "action-deletetest.php",
				        data: {test_id: $testid},
				        dataType: "json",
				        success: function( data ) {
			            	window.location.reload();
          				}
					});
				}
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
							<h1>Tests</h1>
							<p>This is a quick overview of some features</p>
						</div>
						<div class="block-users">
							<div class="control-test">
								<a href="add-test.php" >Add Test</a>
							</div>
							<table class="table-users" border="1" >
								<tr>
									<th>ID</th>
									<th>Category</th>
									<th>Name</th>
									<th>Number of Questions</th>
									<th>status</th>
									<th>Created Date</th>
									<th>Update Date</th>
									<th>Action</th>
								</tr>
								<?php
									$i = 0;
									foreach($tests as $test){
								?>
								<tr class="<?php echo ($i%2==0)?"odd":"even";?>">
									<td><?php echo $test['formid'];?></td>
									<td><?php echo $cats[$test['cat']]['name'];?></td>
									<td><a href="<?php echo $link_home."/test.php?id=".encrypt($test['formid']);?>" target="_blank"><?php echo $test['name'];?></a></td>
									<td><?php echo getQuestionsCount($test['formid']);?></td>
									<td><?php echo $test['is_available']=='1'?"Enabled":"Disabled";?></td>
									<td><?php echo $test['created_date'];?></td>
									<td><?php echo $test['updated_date'];?></td>
									<td>
										<a href="<?php echo $link_admin."/test.php?id=".($test['formid']);?>"><img src="images/Search-48.png" width="18" /></a>
										<a class="delete_test" id="delete_<?php echo $test['formid'];?>"><img src="images/Delete-48.png" width="18" /></a>
									</td> 
								</tr>
								<?php
										$i ++;
									}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include("sidebar.php");?>
	</div>
</body>
</html>