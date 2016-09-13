<?php
	include("function.php");
	
	// logout success
	$_SESSION['uname'] = "";
	$_SESSION['upw'] = "";
	$_SESSION['fbid'] = "";
	$_SESSION['uid'] = "";
	unset($_SESSION['uname']);
	unset($_SESSION['upw']);
	unset($_SESSION['fbid']);
	unset($_SESSION['uid']);
		
	// redirect
	redirect("index.php");
?>