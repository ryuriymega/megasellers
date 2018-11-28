<?php

/*======================================================================*\
|| #################################################################### ||
|| # Register/Login Form by JAKWEB                                    # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright 2012 JAKWEB All Rights Reserved.                       # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| #   ---------------- JAKWEB IS NOT FREE SOFTWARE ---------------   # ||
|| #       http://www.jakweb.ch | http://www.jakweb.ch/license        # ||
|| #################################################################### ||
\*======================================================================*/

/* ---------------> Leave this as it is!!! <--------------- */

// Start the session
session_start();

// First we need the config.php file
include_once 'rfclass/config.php';

// Get the jak DB class
if (JAK_MYSQL_CONNECTION == 1) {
	require_once 'rfclass/class.db.php';
} else {
	require_once 'rfclass/class.dbn.php';
}

// MySQLi connection
$jakdb = new jak_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$jakdb->set_charset("utf8");

// Get the user class
include_once 'rfclass/class.userlogin.php';
// Include all important files
include_once 'rfclass/functions.php';
include_once 'rfclass/class.user.php';

// Check if user is logged in
$jakuserlogin = new JAK_userlogin();
$jakuserrow = $jakuserlogin->jakCheckLogged();
$jakuser = new JAK_user($jakuserrow);
if ($jakuser) {
	$_SESSION['rfUserid'] = $jakuser->getVar("id");
} else {
	unset($_SESSION['rfUserid']);
}

if (is_numeric($_SESSION['rfUserid'])) {
	
	// Update last activity from this user
	$jakuserlogin->jakUpdatelastactivity($_SESSION['rfUserid']);

}

include_once 'rfclass/class.postmail.php';
include_once 'rflang/'.JAK_MAIN_LANG.'.php';

// Reset vars
$errorlo = '';
$errorfp = '';
$errorfr = '';

// Now the user want to logout, but only if everything goes the right way
if (isset($_GET['page']) && $_GET['page'] == 'logout') {
	if (is_numeric($_SESSION['rfUserid'])) {
    	$jakuserlogin->jakLogout($_SESSION['rfUserid']);
        jak_redirect(FULL_SITE_DOMAIN);
    } else {
     	jak_redirect(FULL_SITE_DOMAIN);
    }
}

// Someone tries to register but register is turned off
if (!JAK_REGISTER_ON && isset($_GET['page']) && $_GET['page'] == 'register') {
	jak_redirect(FULL_SITE_DOMAIN.'/loginForm.php');
}

// Finally we include the login, register, forgot and change post
include_once 'rfclass/loginpass.php';

// Activate the user account
if (isset($_GET['page']) && $_GET['page'] == 'activate' && is_numeric($_GET['uid']) && is_numeric($_GET['code']) && is_numeric($_GET['access'])) {

// Check if everything is ok
if (jak_row_exist($_GET['uid']) && jak_field_not_exist($_GET['code'], 'activatenr')) {

	$result = $jakdb->query('SELECT id, username, email, access FROM '.DB_PREFIX.'user WHERE id = "'.smartsql($_GET['uid']).'" AND activatenr = "'.smartsql($_GET['code']).'"');
	$row = $result->fetch_assoc();
	
	if ($result) {
	
		$uaccess = $row['access'];
		
		
		// If no activation necessary the user get's logged in
		if ($uaccess == 2) {
		
			$nidhash = JAK_userlogin::generateRandID();	
			
			$result = $jakdb->query('UPDATE '.DB_PREFIX.'user SET session = "'.smartsql(session_id()).'", idhash = "'.smartsql($nidhash).'", lastactivity = NOW(), access = access - 1, activatenr = 0 WHERE id = "'.smartsql($row['id']).'" AND email = "'.$row['email'].'"');
			
			$_SESSION['username'] = $row['username'];
			$_SESSION['idhash'] = $nidhash;
			
		} elseif ($uaccess == 3) {
		
			$result = $jakdb->query('UPDATE '.DB_PREFIX.'user SET lastactivity = NOW(), access = access - 1, activatenr = 0 WHERE id = "'.smartsql($row['id']).'" AND email = "'.$row['email'].'"');
			
			$mail = new PHPMailer(); // defaults to using php "mail()"
			$body = str_ireplace("[\]", '', $langvar["welcomeusr_activated"]);
			$mail->SetFrom(JAK_EMAIL_ADDRESS);
			$mail->AddAddress($row['email'], $row['username']);
			$mail->Subject = JAK_MY_SITE_NAME.' - '.$langvar['registered'];
			$mail->MsgHTML($body);
			$mail->Send(); // Send email without any warnings
			
			$userlink = FULL_SITE_DOMAIN.'/rfadmin/';
			
			$admail = new PHPMailer();
			$adbody = str_ireplace("[\]", '', $langvar["email_verified"].$userlink);
			$admail->SetFrom(JAK_EMAIL_ADDRESS);
			$admail->AddAddress(JAK_EMAIL_ADDRESS);
			$admail->Subject = JAK_MY_SITE_NAME.' - '.$langvar['registeredae'];
			$admail->MsgHTML($adbody);
			$admail->Send(); // Send email without any warnings
		
		}
		
		jak_redirect(FULL_SITE_DOMAIN.'/loginForm.php?page=successv');
	}
	
	} else {
		jak_redirect(FULL_SITE_DOMAIN);
	}
}

/* -------------> Let's start with the login/register and forgot password form <-------------- */

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login/Register and Forgot Password</title>

                
	<meta charset="utf-8">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="rfcss/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster:regular,italic,bold,bolditalic" type="text/css" />	
	<script src="assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="rfjs/functions.js"></script>
</head>
<body>

		<?php 
		
 if (isset($_GET['page']) && ($_GET['page'] == 'successl' || $_GET['page'] == 'successc' || $_GET['page'] == 'successr' || $_GET['page'] == 'successf' || $_GET['page'] == 'successv')) { ?>

<div class="status-ok"><?php if ($_GET['page'] == 'successl') { echo $langvar["success_logout"]; } elseif ($_GET['page'] == 'successr') { echo $langvar["success_register"]; } elseif ($_GET['page'] == 'successc') { echo $langvar["success_change"]; } elseif ($_GET['page'] == 'successf') { echo $langvar["success_forgot"]; } elseif ($_GET['page'] == 'successv') { echo $langvar["success_verified"]; } ?></div>

<?php } ?>


<div class="content-login">

<?php if (isset($_GET['page']) && $_GET['page'] == 'recover' && is_numeric($_GET['code']) && $jakuserlogin->jakForgotactive($_GET['code'])) { ?>

<h1><?php echo $langvar["recover"];?></h1>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<label for="email"><?php echo $langvar["email"];?><?php if (isset($errorrp['e']) && $errorrp['e']) echo ' <span>'.$errorrp['e'].'</span>';?></label>
	<input type="text" name="email" id="email" value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email'];?>" placeholder="<?php echo $langvar["email"];?>" />
	<label for="password"><?php echo $langvar["newpassword"];?><?php if (isset($errorrp['e1']) && $errorrp['e1']) echo ' <span>'.$errorrp['e1'].'</span>';?></label>
	<input type="password" name="password" id="password" value="" placeholder="<?php echo $langvar["newpassword"];?>" />
	<label for="confirm_password"><?php echo $langvar["password_confirm"];?><?php if (isset($errorrp['e1']) && $errorrp['e1']) echo ' <span>'.$errorrp['e1'].'</span>';?></label>
	<input type="password" name="confirm_password" id="confirm_password" value="" placeholder="<?php echo $langvar["password_confirm"];?>" />
	
	<label><?php echo $langvar["captcha"];?></label>
	<div class="captcha_wrapper">
		<img src="rfclass/recaptcha/jak.human.php" alt="captcha" class="captcha" />
		<img src="rfcss/img/refresh.png" alt="captcha_refresh" class="captcha_refresh" title="<?php echo $langvar["captcha_refresh"];?>" />
	</div>
	<label class="required" for="human"><?php echo $langvar["string"];?><?php if (isset($errorrp['e2']) && $errorrp['e2']) echo ' <span>'.$errorrp['e2'].'</span>';?></label>
	<input type="text" name="human" id="human" title="human" class="captcha" placeholder="<?php echo $langvar["string"];?>" value="" />
	
	<p><button type="submit" name="newpasswordRF" class="button"><?php echo $langvar["set_password"];?></button></p>
	
</form>

<div class="logo-left"><img src="rfcss/img/logo_forgot.png" alt="forgot" /></div>

<?php } else { if (!$jakuserrow) { ?>

<?php /////////////////////////////////////////////////////////////////////////////////////// LOGIN FORM ////////////////////////?>
<?php /////////////////////////////////////////////////////////////////////////////////////// LOGIN FORM ////////////////////////?>
<?php /////////////////////////////////////////////////////////////////////////////////////// LOGIN FORM ////////////////////////?>
<?php /////////////////////////////////////////////////////////////////////////////////////// LOGIN FORM ////////////////////////?>
<?php /////////////////////////////////////////////////////////////////////////////////////// LOGIN FORM ////////////////////////?>

<div id="loginF">
<h1><?php echo $langvar["login"];?></h1>

<form id="login_form" class="jak_form" method="post" action="loginForm.php" target='_parent'>
	
	<label for="username"><?php echo $langvar["username"];?><?php if (isset($errorlo['e']) && $errorlo['e']) echo ' <span>'.$errorlo['e'].'</span>';?></label>
	<input type="text" name="username" id="username" value="<?php if (isset($_REQUEST['username'])) echo $_REQUEST['username'];?>" placeholder="<?php echo $langvar["username_email"];?>" />
	
	<label for="password"><?php echo $langvar["password"];?><?php if (isset($errorlo['e']) && $errorlo['e']) echo ' <span>'.$errorlo['e'].'</span>';?> 
	
	<a class="lost-pwd"><span style="cursor:pointer;color:purple;font-size:13px;">Forgot your password?</span></a></label>
	
	<input type="password" name="password" id="password" value="" placeholder="<?php echo $langvar["password"];?>" />
	<label><?php echo $langvar["captcha"];?></label>
	<div class="captcha_wrapper">
		<img src="rfclass/recaptcha/jak.human.php" alt="captcha" class="captcha" />
		<img src="rfcss/img/refresh.png" alt="captcha_refresh" class="captcha_refresh" title="<?php echo $langvar["captcha_refresh"];?>" />
	</div>
	<label class="required" for="human"><?php echo $langvar["string"];?><?php if (isset($errorlo['e1']) && $errorlo['e1']) echo ' <span>'.$errorlo['e1'].'</span>';?></label>
	<input type="text" name="human" id="human" title="human" class="captcha" placeholder="<?php echo $langvar["string"];?>" value="" />
	
	<label><?php echo $langvar["cookies"];?></label>
	<?php echo $langvar["yes"];?> <input type="radio" name="lcookies" value="1" checked="checked" /> <?php echo $langvar["no"];?> <input type="radio" name="lcookies" value="0" />

<p><button type="submit" name="loginRF" class="button"><?php echo $langvar["login"];?></button></p>
</form>

    <div class="buttons" style="margin-top:30px;">
	<?php if (JAK_REGISTER_ON) { ?>
		
		<div style="margin-bottom:10px;"><strong>Don't have account?</strong></div>
		<div class="rf-reg" title="<?php echo $langvar["register"];?>" style="padding-left:50px;padding-top:10px;padding-bottom:10px;margin:25px;width:200px;font-weight:900;">Create New Account</div>
	<?php } ?>
	<?php /*<a class="lost-pwd" title="<?php echo $langvar["forgot"];?>" href="#"><img src="rfcss/img/logo_forgot_s.png" alt="forgot" /></a>*/?>
</div>

<div class="logo-left"><img src="rfcss/img/logo_login.png" alt="login" /></div>
<div style="margin-bottom:10px;"><strong>or Log In with</strong></div>
		<div style="width:350px;">
			<?php //<img src="rfcss/img/loginFacebook.png" alt="login facebook" class="loginBtn" onClick="window.open('loginFacebook.php','_parent');">?>
			<?php //<img src="rfcss/img/loginGoogle.png" alt="login google" class="loginBtn" onClick="window.open('loginGoogle.php','_parent');">?>
                        <?php //<a onClick="window.open('loginFacebook.php','_parent');" class="button">Facebook</a>?>
                        <a onClick="window.alert('not ready yet ...');" class="button">Facebook</a>
                        <a onClick="window.open('loginGoogle.php','_parent');" class="button">Google</a>
		</div>
</div>
<?php ///////////////////////////////////////////////////////////////////////////////////////END OF LOGIN FORM ////////////////////////?>
<?php ///////////////////////////////////////////////////////////////////////////////////////END OF LOGIN FORM ////////////////////////?>
<?php ///////////////////////////////////////////////////////////////////////////////////////END OF LOGIN FORM ////////////////////////?>
<?php ///////////////////////////////////////////////////////////////////////////////////////END OF LOGIN FORM ////////////////////////?>
<?php ///////////////////////////////////////////////////////////////////////////////////////END OF LOGIN FORM ////////////////////////?>


<div id="forgotP">
<h1><?php echo $langvar["forgot"];?></h1>
<form action="loginForm.php?page=forgot_password" method="post">

	<label for="email"><?php echo $langvar["email"];?><?php if (isset($errorfp['e']) && $errorfp['e']) echo ' <span>'.$errorfp['e'].'</span>';?></label>
	<input type="text" name="email" id="email" class="inputbig" value="" placeholder="<?php echo $langvar["email"];?>" />
	
	<label><?php echo $langvar["captcha"];?></label>
	<div class="captcha_wrapper">
		<img src="rfclass/recaptcha/jak.human.php" alt="captcha" class="captcha" />
		<img src="rfcss/img/refresh.png" alt="captcha_refresh" class="captcha_refresh" title="<?php echo $langvar["captcha_refresh"];?>" />
	</div>
	<label class="required" for="human"><?php echo $langvar["string"];?><?php if (isset($errorfp['e1']) && $errorfp['e1']) echo ' <span>'.$errorfp['e1'].'</span>';?></label>
	<input type="text" name="human" id="human" title="human" class="captcha" placeholder="<?php echo $langvar["string"];?>" />
	
<p><button type="submit" name="forgotRF" class="button"><?php echo $langvar["send"];?></button></p>
</form>

<div class="buttons" style="margin-top:30px;">
	<a class="rf-login" title="<?php echo $langvar["login"];?>" href="#"><img src="rfcss/img/logo_login_s.png" alt="login" /></a>
	<?php if (JAK_REGISTER_ON) { ?>
		<div style="margin-bottom:10px;"><strong>Don't have account?</strong></div>
		<div class="rf-reg" title="<?php echo $langvar["register"];?>" style="padding-left:50px;padding-top:10px;padding-bottom:10px;margin:25px;width:200px;font-weight:900;">Create New Account</div>
	<?php } ?>
</div>

<div class="logo-left"><img src="rfcss/img/logo_forgot.png" alt="forgot" /></div>

</div>

<?php if (JAK_REGISTER_ON) { ?>
<?php ///////CREATE ACCOUNT///////////////////////////////////////////////////////////////////////////////////////////////?>
<?php ///////CREATE ACCOUNT///////////////////////////////////////////////////////////////////////////////////////////////?>
<?php ///////CREATE ACCOUNT///////////////////////////////////////////////////////////////////////////////////////////////?>
<div id="registerF">
<h1><?php echo $langvar["register"];?></h1>
<form action="loginForm.php?page=register" method="post">
	
	<label for="first_name"><?php echo $langvar["first_name"];?><?php if (isset($errorfr['e']) && $errorfr['e']) echo ' <span>'.$errorfr['e'].'</span>';?></label>
	<input type="text" name="first_name" id="first_name" value="<?php if (isset($_REQUEST['first_name'])) echo $_REQUEST['first_name'];?>" placeholder="<?php echo $langvar["first_name"];?>" />
	
	<label for="last_name"><?php echo $langvar["last_name"];?><?php if (isset($errorfr['e']) && $errorfr['e']) echo ' <span>'.$errorfr['e'].'</span>';?></label>
	<input type="text" name="last_name" id="last_name" value="<?php if (isset($_REQUEST['last_name'])) echo $_REQUEST['last_name'];?>" placeholder="<?php echo $langvar["last_name"];?>" />
	
	<label for="username"><?php echo $langvar["username"];?><?php if (isset($errorfr['e']) && $errorfr['e']) echo ' <span>'.$errorfr['e'].'</span>';?></label>
	<input type="text" name="username" id="username" value="<?php if (isset($_REQUEST['username'])) echo $_REQUEST['username'];?>" placeholder="<?php echo $langvar["username"];?>" />
	
	<label for="email"><?php echo $langvar["email"];?><?php if (isset($errorfr['e1']) && $errorfr['e1']) echo ' <span>'.$errorfr['e1'].'</span>';?></label>
	<input type="text" name="email" id="email" value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email'];?>" placeholder="<?php echo $langvar["email"];?>" />
	
	<label for="check_password"><?php echo $langvar["password"];?><?php if (isset($errorfr['e2']) && $errorfr['e2']) echo ' <span>'.$errorfr['e2'].'</span>';?></label>
	<input type="password" name="password" id="check_password" value="" placeholder="<?php echo $langvar["password"];?>" />
	
	<label for="confirm_password"><?php echo $langvar["password_confirm"];?><?php if (isset($errorfr['e2']) && $errorfr['e2']) echo ' <span>'.$errorfr['e2'].'</span>';?></label>
	<input type="password" name="confirm_password" id="confirm_password" value="" placeholder="<?php echo $langvar["password_confirm"];?>" />
	
	<label><?php echo $langvar["password_indicator"];?></label>
	<div id="jak_pstrength" class="pstrength"></div>
	
	<label><?php echo $langvar["captcha"];?></label>
	<div class="captcha_wrapper">
		<img src="rfclass/recaptcha/jak.human.php" alt="captcha" class="captcha" />
		<img src="rfcss/img/refresh.png" alt="captcha_refresh" class="captcha_refresh" title="<?php echo $langvar["captcha_refresh"];?>" />
	</div>
	<label class="required" for="human"><?php echo $langvar["string"];?><?php if (isset($errorfr['e3']) && $errorfr['e3']) echo ' <span>'.$errorfr['e3'].'</span>';?></label>
	<input type="text" name="human" id="human" title="human" class="captcha" placeholder="<?php echo $langvar["string"];?>" />
	
<p><button type="submit" name="registerRF" class="button"><?php echo $langvar["register_send"];?></button></p>
<div class="logo-left"><img src="rfcss/img/logo_login.png" alt="login" /></div>
<div style="margin-bottom:10px;"><strong>or Register with</strong></div>
		<div style="width:350px;">
                        <?php //<a onClick="window.open('loginFacebook.php','_parent');" class="button">Facebook</a>?>
                        <a onClick="window.alert('not ready yet ...');" class="button">Facebook</a>
                        <a onClick="window.open('loginGoogle.php','_parent');" class="button">Google</a>
		</div>
</form>
<?php ///////END OF CREATE ACCOUNT///////////////////////////////////////////////////////////////////////////////////////////////?>
<?php ///////END OF CREATE ACCOUNT///////////////////////////////////////////////////////////////////////////////////////////////?>
<?php ///////END OF CREATE ACCOUNT///////////////////////////////////////////////////////////////////////////////////////////////?>

<div class="buttons" style="margin-top:30px;">
	<a class="rf-login" href="#" title="<?php echo $langvar["login"];?>"><img src="rfcss/img/logo_login_s.png" alt="login" /></a>
	<a class="lost-pwd" href="#" title="<?php echo $langvar["forgot"];?>"><img src="rfcss/img/logo_forgot_s.png" alt="forgot" /></a>
</div>

<div class="logo-left"><img src="rfcss/img/logo_register.png" alt="forgot" /></div>

</div>

<?php } } else { ?>

<?php ///////ALREADY LOGIN///////////////////////////////////////////////////////////////////////////////////////////////?>
<?php ///////ALREADY LOGIN///////////////////////////////////////////////////////////////////////////////////////////////?>
<?php ///////ALREADY LOGIN///////////////////////////////////////////////////////////////////////////////////////////////?>
<h1><?php echo $langvar["welcome"].$jakuser->getVar("username");?></h1>

<a class="logout" href="loginForm.php?page=logout" title="<?php echo $langvar["logout"];?>"><img src="rfcss/img/logout.png" alt="logout" /></a>

<form action="loginForm.php" method="post">
	
	<label for="first_name"><?php echo $langvar["first_name"];?><?php if (isset($errorfr['e']) && $errorfr['e']) echo ' <span>'.$errorfr['e'].'</span>';?></label>
	<input type="text" name="first_name" id="first_name" value="<?php echo $jakuser->getVar("first_name");?>" placeholder="<?php echo $langvar["first_name"];?>" />
	<input type="hidden" name="first_name_hidden" value="<?php echo $jakuser->getVar("first_name");?>" />
	
	<label for="last_name"><?php echo $langvar["last_name"];?><?php if (isset($errorfr['e']) && $errorfr['e']) echo ' <span>'.$errorfr['e'].'</span>';?></label>
	<input type="text" name="last_name" id="last_name" value="<?php echo $jakuser->getVar("last_name");?>" placeholder="<?php echo $langvar["last_name"];?>" />
	<input type="hidden" name="last_name_hidden" value="<?php echo $jakuser->getVar("last_name");?>" />
	
	<label for="username"><?php echo $langvar["username"];?><?php if (isset($errorfr['e']) && $errorfr['e']) echo ' <span>'.$errorfr['e'].'</span>';?></label>
	<input type="text" name="username" id="username" value="<?php echo $jakuser->getVar("username");?>" placeholder="<?php echo $langvar["username"];?>" />
	<input type="hidden" name="usr_hidden" value="<?php echo $jakuser->getVar("username");?>" />
	
	<label for="email"><?php echo $langvar["email"];?><?php if (isset($errorfr['e1']) && $errorfr['e1']) echo ' <span>'.$errorfr['e1'].'</span>';?></label>
	<input type="text" name="email" id="email" value="<?php echo $jakuser->getVar("email");?>" placeholder="<?php echo $langvar["email"];?>" />
	<input type="hidden" name="uemail_hidden" value="<?php echo $jakuser->getVar("email");?>" />
	
	<label for="passold"><?php echo $langvar["oldpassword"];?><?php if (isset($errorfr['e4']) && $errorfr['e4']) echo ' <span>'.$errorfr['e4'].'</span>';?></label>
	<input type="password" name="passold" id="passold" value="" placeholder="<?php echo $langvar["oldpassword"];?>" />
	
	<label for="check_password"><?php echo $langvar["newpassword"];?><?php if (isset($errorfr['e2']) && $errorfr['e2']) echo ' <span>'.$errorfr['e2'].'</span>';?></label>
	<input type="password" name="password" id="check_password" value="" placeholder="<?php echo $langvar["newpassword"];?>" />
	
	<label for="confirm_password"><?php echo $langvar["password_confirm"];?><?php if (isset($errorfr['e2']) && $errorfr['e2']) echo ' <span>'.$errorfr['e2'].'</span>';?></label>
	<input type="password" name="confirm_password" id="confirm_password" value="" placeholder="<?php echo $langvar["password_confirm"];?>" />
	
	<label><?php echo $langvar["password_indicator"];?></label>
	<div id="jak_pstrength" class="pstrength"></div>
	
	<label><?php echo $langvar["captcha"];?></label>
	<div class="captcha_wrapper">
		<img src="rfclass/recaptcha/jak.human.php" alt="captcha" class="captcha" />
		<img src="rfcss/img/refresh.png" alt="captcha_refresh" class="captcha_refresh" title="<?php echo $langvar["captcha_refresh"];?>" />
	</div>
	<label class="required" for="human"><?php echo $langvar["string"];?><?php if (isset($errorfr['e3']) && $errorfr['e3']) echo ' <span>'.$errorfr['e3'].'</span>';?></label>
	<input type="text" name="human" id="human" title="human" class="captcha" placeholder="<?php echo $langvar["string"];?>" />
	
	<input type="hidden" name="uid" value="<?php echo $_SESSION['rfUserid'];?>" />
	
<p><button type="submit" name="changeRF" class="button"><?php echo $langvar["change"];?></button></p>
</form>
<?php ///////END OF ALREADY LOGIN///////////////////////////////////////////////////////////////////////////////////////////////?>
<?php ///////END OF ALREADY LOGIN///////////////////////////////////////////////////////////////////////////////////////////////?>
<?php ///////END OF ALREADY LOGIN///////////////////////////////////////////////////////////////////////////////////////////////?>
<?php } } ?>

</div>

<script type="text/javascript">

	$(document).ready(function() {
		
		<?php if ($errorlo) { ?>
			$("#forgotP, #registerF").hide();
			$("#loginF").show();
		<?php } if ($errorfp || (isset($_GET['page']) && $_GET['page'] == "forgot_password")) { ?>
			$("#loginF, #registerF").hide();
			$("#forgotP").show();
		<?php } if ($errorfr || (isset($_GET['page']) && $_GET['page'] == "register")) { ?>
			$("#forgotP, #loginF").hide();
			$("#registerF").show();
		<?php } if ($errorlo || $errorfp || $errorfr) { ?>
			$(".content-login").addClass("shake");
		<?php } ?>
			
	});

</script>
</body>
</html>
