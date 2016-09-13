<?php
	include("function.php");
	if(!checkAdmin()){
		redirect("login.php");
	}
	db_connect();
	$page = "testcats";
	$testscat = getAllTestCategory();
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
					$tid = $(this).attr('id');
					$tid = $tid.replace("delete_", "");
					$.ajax({
						type: "POST",
				        url: "action-deletetestcat.php",
				        data: {tid: $tid},
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
							<h1>Tests Category</h1>
							<p>This is a quick overview of some features</p>
						</div>
						<div class="block-users">
							<div class="control-test">
								<a href="add-testcat.php" >Add Test Category</a>
							</div>
							<table class="table-users" border="1" >
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Category</th>
									<th>Created Date</th>
									<th>Update Date</th>
								</tr>
								<?php
									$i = 0;
									foreach($testscat as $test){
								?>
								<tr class="<?php echo ($i%2==0)?"odd":"even";?>">
									<td><?php echo $test['forms_cat'];?></td>
									<td><?php echo $test['name'];?></td>
									<td><?php echo ($test['is_available']=='1'?"Enabled":"Disabled");?></td>
									<td><?php echo $test['created_date'];?></td>
									<td><?php echo $test['updated_date'];?></td>
									<td>
										<a class="delete_test" id="delete_<?php echo $test['forms_cat'];?>"><img src="images/Delete-48.png" width="18" /></a>
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