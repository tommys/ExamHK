
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="js/jquery-1.7.2.min.js"><\/script>');</script>
	
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="js/jquery.main.js"></script>
	<link media="all" rel="stylesheet" type="text/css" href="css/style.css">
	
	<style>
		input {
			outline: 0;
		}
		#mainContent {
		    position: absolute;
		    top: 50%;
		    left: 50%;
		    margin-top: -67px;
		    margin-left: -67px;
   			height:100vh;
			width: 100%;
			background: #FFF;
		}
		#coverUpper {
		    position: absolute;
		    top: 0px;
		    left: 0px;
   			height:100vh;
			width: 100%;
			background-image:
			    linear-gradient(-30deg, transparent 50%, #1e202c  0);
		}
		#coverLower {
		    position: absolute;
		    top: 0px;
		    left: 0px;
   			height:100vh;
			width: 100%;
			background-image:
			    linear-gradient(-30deg, #d8dce0 50%, transparent 0);
		}
		#loginBlock {
    		position: absolute;
		    top: 50%;
		    left: 50%;
		    margin-top: -300px;
		    margin-left: -385px; 
    		height: 599px;
    		width: 770px;
			background: #FFF;
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			-o-border-radius: 10px;
			border-radius: 10px;
		    overflow: hidden;
    		box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.5);
		}
		#loginForm {
			float: left;
			text-align: center;
    		width: 286px;
		}
		#registerForm {
			float: right; 
			text-align: center;
    		width: 286px;
		}
		
		#loginForm h1, #registerForm h1{
			margin-top: 40px;
		    margin-bottom: 60px;
		    line-height: 40px;
		}
		.textInput {
			background: transparent;
			border: 0px;
			border-bottom: 1px solid #CCC;
			margin-bottom: 50px;
			width: 200px;
		    font-size: 18px;
		}
		#btnLogin {
			background: #4cc3e9;
			width: 200px;
			height: 40px;
			border: 0px;
			color: #FFF;
		    margin-bottom: 30px;
    		font-size: 16px;
		}
		#btnRegister {
			background: #4cc3e9;
			width: 200px;
			height: 40px;
			border: 0px;
			color: #FFF;
		    margin-bottom: 30px;
    		font-size: 16px;
		}
		#btnGoToRegister {
			background: #38abbe;
			width: 286px;
			height: 50px;
			border: 0px;
			color: #FFF;
    		position: absolute;
    		bottom: 0px;
    		left: 0px;
    		font-size: 16px;
		}
		#btnGoToLogin {
			background: #38abbe;
			width: 286px;
			height: 50px;
			border: 0px;
			color: #FFF;
    		position: absolute;
    		bottom: 0px;
    		right: 0px;
    		font-size: 16px;
		}
		#loginImg {
			position: absolute;
		    right: 0px;
		    top: 0px;
		}
	</style>
	<script>
		$(document).ready(function(){
			$("#btnLogin").click(function(){
				$("#loginBlock").hide("fast", function(){
					$("#coverUpper").animate({
//     					opacity: 0.25,
    					top: "-="+ $( "#coverUpper" ).height(),
  					}, 1000, function() {
  						// finished
					});
					$("#coverLower").animate({
//     					opacity: 0.25,
    					top: "+="+ $( "#coverLower" ).height(),
  					}, 1000, function() {
  						// finished
					});
				});
			});
			
			$("#btnGoToRegister").click(function(){
				$("#loginImg").animate({ 
    				right: "286px",
  				}, 600, function() {
  					// finished
  					$("#registerForm").fadeIn();
  					$("#loginForm").fadeOut();
				});
			});
			
			$("#btnGoToLogin").click(function(){
				$("#loginImg").animate({ 
    				right: "0px",
  				}, 600, function() {
  					// finished
  					$("#registerForm").fadeOut();
  					$("#loginForm").fadeIn();
				});
			});
		});
	</script>
</head>
<body>
	<div id="mainContent">
		<img src="img/loading.gif" />
	</div>
	<div id="coverUpper">
	</div>
	<div id="coverLower">
	</div>
	<div id="loginBlock">
		<div id="loginForm">
			<h1>MEMBER LOGIN</h1><br/>
			<input class="textInput" type="text" placeholder="EMAIL" /><br/>
			<input class="textInput" type="text" placeholder="PASSWORD" /><br/>
			<input id="btnLogin" type="button" value="LOGIN" /><br/>
			<a href="#">FORGOT YOUR PASSWORD</a><br/>
			<input id="btnGoToRegister" type="button" value="REGISTER" /><br/>
		</div>
		<div id="registerForm" style="display: none">
			<h1>MEMBER REGISTRATION</h1><br/>
			<input class="textInput" type="text" placeholder="EMAIL" /><br/>
			<input class="textInput" type="text" placeholder="PASSWORD" /><br/>
			<input id="btnRegister" type="button" value="REGISTER" /><br/>
			<input id="btnGoToLogin" type="button" value="LOGIN" /><br/>
		</div>
		<div id="loginImg">
			<img src="img/img-login.png" />
		</div>
	</div>
</body>
</html>