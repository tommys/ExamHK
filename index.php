<?php
	include("function.php");
	db_connect();
	if(checkUser()){
		redirect("home.php");
	}
?>
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
	
	<script>
		$(document).ready(function(){
			<?php if(isset($_GET['l'])){ ?>
				$( ".form-alert" ).effect( "shake", {"distance": 5});
				$( ".form-success").fadeIn();
			<?php }?>
			<?php if(isset($_GET['s'])){ ?>
				$( ".form-alert" ).effect( "shake", {"distance": 5});
				$( ".form-success").fadeIn();
			<?php }?>
		});
	</script>
	
	<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }
  
  function userLogin()
    {
        FB.login(function(response) 
        {
           if (response.authResponse) 
           {
             console.log('Welcome!  Fetching your information.... ');
             var access_token = response.authResponse.accessToken;
             testAPI();
           } 
           else 
           {
             console.log('User cancelled login or did not fully authorize.');
           }
         });
    }   


  window.fbAsyncInit = function() {
  FB.init({
    appId      : '1749709318610315',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.5', // use graph api version 2.5
    status		: false
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.
/*
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
*/
  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me?fields=name,email', function(response) {
//       console.log('Successful login for: ' + response.name);
//       document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response.name + '!';

      console.log(response);
      console.log(response.id);
      console.log(response.name);
      console.log(response.email);
    
		$.ajax({
			type: "POST",
			url: "action-fb-login.php",
			data: {fbid: response.id, fbname: response.name, fbemail: response.email},
			dataType: "json",
			success: function( data ) {
				if(data.status == "true"){
					window.location.reload();
				}else {
// 					alert("error");
				}
			}
		});
    });
  }
</script>

</head>
<body>
	<div class="content-login" align="center">
		<div class="block-login fl">
		<form action="action-login.php" method="post" type="submit">
			<h1>Login</h1>
			<div class="form-input"><input type="text" placeholder="E-mail" name="email" /></div>
			<div class="form-input"><input type="password" placeholder="Password" name="password" /></div>
			<?php if(isset($_GET['l']) && ($_GET['l'] == "reset_pw" ||  $_GET['l'] == "reset_pw_success") ){ ?>
				<div class="form-success"><?php echo ${$_GET['l']} ?></div>
			<?php }else if(isset($_GET['l'])){ ?>
				<div class="form-alert"><?php echo ${$_GET['l']} ?></div>
			<?php }?>
			<div class="form-input">
				<input type="submit" name="btnLogin" id="btnLogin" value="Login" class="btn"/>
				<input type="button" name="btnForget" id="btnForget" value="Forget Password" class="btn" onclick="window.location='forget-pw.php'"/>
			</div>
			<hr/>
			<div class="facebook-login" style="display: none">
				<fb:login-button scope="public_profile,email" onlogin="userLogin();"></fb:login-button>
				<div id="status"></div>
			</div>
		</form>
		</div>
		<div class="v-separator fl"></div>
		<div class="block-register fl">
		<form action="action-register.php" method="post" type="submit">
			<h1>Register</h1>
			<div class="form-input"><input type="text" placeholder="E-mail" name="email" /></div>
			<div class="form-input"><input type="password" placeholder="Password" name="password" /></div>
			<?php if(isset($_GET['s']) && $_GET['s'] == "re_success" ){ ?>
				<div class="form-success"><?php echo ${$_GET['s']} ?></div>
			<?php }else if(isset($_GET['s'])){ ?>
				<div class="form-alert"><?php echo ${$_GET['s']} ?></div>
			<?php }?>
			<div class="form-input"><input type="submit" name="btnRegister" id="btnRegister" value="Register" class="btn"/></div>
		</form>
		</div>
		<div class="cb"> </div>
	</div>
</body>
</html>