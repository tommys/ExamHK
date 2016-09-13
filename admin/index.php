<?php
	include("function.php");
	if(!checkAdmin()){
		redirect("login.php");
	}
	db_connect();
	$users = getUsers(5, true);
	$tests = getAllTest();
	
	$page = "index";
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>AdminPanel</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/all.css" />
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
						<article>
							<div class="text-section">
								<h1>Dashboard</h1>
								<p>This is a quick overview of some features</p>
							</div>
							<!-- 
<ul class="states">
								<li class="error">Error : This is an error placed text message.</li>
								<li class="warning">Warning: This is a warning placed text message.</li>
								<li class="succes">Succes : This is a succes placed text message.</li>
							</ul>
 -->
						</article>
						<div class="block-users">
							<h2><a href="users.php">USERS</a></h2>
							<table class="table-users" border="1" >
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>E-mail</th>
									<th>Created Date</th>
									<th>Update Date</th>
									<th>Action</th>
								</tr>
								<?php
									$i = 0;
									foreach($users as $user){
								?>
								<tr class="<?php echo ($i%2==0)?"odd":"even";?>">
									<td><?php echo $user['uid'];?></td>
									<td><?php echo $user['name'];?></td>
									<td><?php echo $user['email'];?></td>
									<td><?php echo $user['created_date'];?></td>
									<td><?php echo $user['updated_date'];?></td>
									<td>
										<img src="images/Search-48.png" width="18" />
									</td> 
								</tr>
								<?php
										$i ++;
									}
								?>
							</table>
						</div>
						<div class="block-test">
							<h2><a href="test.php">TESTS</a></h2>
							<table class="table-test" border="1" >
								<tr>
									<th>ID</th>
									<th>Test Name</th>
									<th>Number of Questions</th>
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
									<td><a href="<?php echo $link_home."/test.php?id=".encrypt($test['formid']);?>"><?php echo $test['name'];?></a></td>
									<td><?php echo getQuestionsCount($test['formid']);?></td>
									<td><?php echo $test['created_date'];?></td>
									<td><?php echo $test['updated_date'];?></td>
									<td>
										<a href="<?php echo $link_admin."/test.php?id=".($test['formid']);?>"><img src="images/Search-48.png" width="18" /></a>
									</td> 
								</tr>
								<?php
										$i ++;
									}
								?>
							</table>
							<input type="button" value="Add Test" onclick="window.location='add-test.php'" />
						</div> 
					</div>
				</div>
			</div>
		</div>
		<?php include("sidebar.php");?>
	</div>
</body>
</html>