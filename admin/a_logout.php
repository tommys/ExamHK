<?php
	include("function.php");
	
	// logout success
	unset($_SESSION['auser']);
	unset($_SESSION['apw']);
		
	// redirect
	redirect("login.php");
?>