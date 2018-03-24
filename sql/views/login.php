<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Classy Login form Widget Flat Responsive Widget Template :: w3layouts</title>
<script src="<?php echo app_webpath(); ?>login/js/jquery.min.js"></script>
<!-- Custom Theme files -->
<link href="<?php echo app_webpath(); ?>login/css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- for-mobile-apps -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="keywords" content="Classy Login form Responsive, Login form web template, Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- //for-mobile-apps -->
<!--Google Fonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
<!--header start here-->
<div class="header">
		<div class="header-main">
		       <h1><?php __("welcome_web_comunity") ?></h1>
		      <div id="syserror"></div>
			<div class="header-bottom">
				<div class="header-right w3agile">
					
					<div class="header-left-bottom agileinfo">
						
					 <form id="form-login" action="#" method="post">
						<input type="text"  value="User name" name="username" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User name';}"/>
					<input id="sysp" type="password"  value="Password" name="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'password';}"/>
						<div class="remember">
			             <span class="checkbox1">
							   <label class="checkbox">
							   <input id="cmdPass" onclick="setStatusPass()" type="checkbox"><i> </i><?php __("show_my_password") ?></label>
						 </span>
						 <div class="forgot">
						 	<h6><a href="#"><?php __("forgot_password") ?></a></h6>
						 </div>

						<div class="clear"></div>
					  </div>
					   
						<input type="button" onclick="auth__login()" value="Login">
					</form>	
					<div class="header-left-top">
						<div class="sign-up"> <h2>or</h2> </div>
					
					</div>
					<div class="header-social wthree">
							<a href="#" class="face"><h5>Facebook</h5></a>
							<a href="#" class="twitt"><h5>Twitter</h5></a>
						</div>
						
				</div>
				</div>
			  
			</div>
			<script type="text/javascript">
			function setStatusPass(){
				document.getElementById('sysp').type = 'text';
				$('#cmdPass').attr('onclick','hidePass()');
			}
			function hidePass(){
				document.getElementById('sysp').type = 'password';
				$('#cmdPass').attr('onclick','setStatusPass()');
			}
			function error_message(msg){
				$('#syserror').html('<div style="background: #fe4554;opacity: 0.5;margin: 3%;padding:3%"><p style="margin-left: 30%;" id="response_message"> '+msg+' </p> </div>');
			}
			//Ajax system auth login
			function auth__login(){
			$.ajax({
				url:'<?php echo app_weburl()."action/logged" ?>',
				dataType:"json",
				data:$('#form-login').serialize(),
				type:'POST',
				error : function(obj,status){
					alert(status);
					//$('#response_message').html('<?php __("have_error_network"); ?>');
					error_message("have_error_network");	
				},
				success : function(response){
					switch(response.code){
						case 'user_unknow':
						case 'password_wrong':

							error_message(response.msg);
						break;

						case 'login_success':
							window.location ='<?php app_weburl()."app"; ?>';
						case 1:
						break;
					}
					
				}
			});}  //end function auth ajax
			</script>
		</div>
</div>
<!--header end here-->
<div class="copyright">
	<p>© 2016 Classy Login Form. All rights reserved | Design by  <a href="http://w3layouts.com/" target="_blank">  W3layouts </a></p>
</div>
<!--footer end here-->
</body>
</html>