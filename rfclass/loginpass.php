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

// Errors in Array
$errors = array();

// Login user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (isset($_POST['loginRF'])) {

	    $username = smartsql($_POST['username']);
	    $userpass = smartsql($_POST['password']);
	    
	    // Check Human Verification
	    if ($_POST['human'] == '' || md5($_POST['human']) != $_SESSION['JAK_HUMAN_IMAGE']) {
	    	$errors['e1'] = $langvar["error_captcha"];   
	    }
	    
	    if (count($errors) != 0) {
	    	$errors['e'] = $langvar["error_login"];
	    	$errorlo = $errors;
	    } else {
	    
		    // Security for user agend and remote addr
		    $valid_agent = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
		    $valid_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
		    
		    // Write the log file each time someone tries to login before
		    $jakuserlogin->jakWriteloginlog($username, $_SERVER['REQUEST_URI'], $valid_ip, $valid_agent, 0);
		    	     
		    $user_check = $jakuserlogin->jakCheckuserdata($username, $userpass);
		    if ($user_check == true) {
		
		        // Now login in the user
		        $jakuserlogin->jakLogin($user_check, $userpass, $_POST['lcookies']);
		        
		        // Write the log file each time someone login after to show success
		        $jakuserlogin->jakWriteloginlog($username, '', $valid_ip, '', 1);

				////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////
				////REDIRECT///////////////
				jak_redirect(FULL_SITE_DOMAIN.'/dashboard.php');
				////////////////////////////////////////////////////////////////////////////////
				////////////////////////////////////////////////////////////////////////////////
				
		
		   } else {
		   
		        $errors['e'] = $langvar["error_login"];
		        $errorlo = $errors;
		        
		   }
	   
	   }
   
 	}
 
 	// Forgot password
 	if (isset($_POST['forgotRF'])) {
 	
 		// Check Human Verification
 		if ($_POST['human'] == '' || md5($_POST['human']) != $_SESSION['JAK_HUMAN_IMAGE']) {
 			$errors['e1'] = $langvar["error_captcha"];   
 		} else {
 
	 	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || !jak_field_not_exist(strtolower($_POST['email']), 'email')) {
	 	    $errors['e'] = $langvar["error_email2"];
	 	}
	 	
	 	}
	 	
	 	// transform user email
	     $femail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	     $fwhen = time();
	 	
	 	// Check if this user exist
	    $user_check = $jakuserlogin->jakForgotpassword($femail, $fwhen);
	     
	    if (count($errors) == 0 && !$user_check) {
	    	$errors['e'] = $langvar["error_notexist"];
	    }
	     
	     if (count($errors) == 0) {
	         	$mail = new PHPMailer(); // defaults to using php "mail()"
	         	$mail->SetFrom(JAK_EMAIL_ADDRESS);
	         	$mail->AddAddress($femail);
	         	$mail->Subject = $langvar["recover"];
	         	$mail->Body = $langvar["recover1"].FULL_SITE_DOMAIN.'/loginForm.php?page=recover&code='.$fwhen;
	         	
	         	if ($mail->Send()) {
	         		jak_redirect(FULL_SITE_DOMAIN.'/loginForm.php?page=successf');  	
	         	}
	 
	     } else {
	         $errorfp = $errors;
	     }
	}
	
	// Set new password
	if (isset($_POST['newpasswordRF'])) {
		
		// Check Human Verification
		if ($_POST['human'] == '' || md5($_POST['human']) != $_SESSION['JAK_HUMAN_IMAGE']) {
			$errors['e2'] = $langvar["error_captcha"];   
		} else {
	 	
	 	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || !jak_field_not_exist(strtolower($_POST['email']), 'email')) {
	 	    $errors['e'] = $langvar["error_email2"];
	 	}
	 	
	 	// Check the password
	 	if (strlen($_POST['password']) <= '5') {
	 		$errors['e1'] = $langvar["error_pass"];
	 	}
	 	
	 	if ($_POST['password'] != $_POST['confirm_password']) {
	 		$errors['e1'] = $langvar["error_pass1"];
	 	}
	 	
	 	}
	 	
	 	// transform user email
	    $femail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	    $fwhen = time();
	 	
	     
	    if (count($errors) == 0) {
	    
	    	// The new password encrypt with hash_hmac
	    	$passcrypt = hash_hmac('sha256', $_POST['password'], DB_PASS_SALT);
	    		
	    	$result2 = $jakdb->query('UPDATE '.DB_PREFIX.'user SET password = "'.$passcrypt.'", forgot = 0 WHERE email = "'.smartsql($femail).'"');
	    	
	    	$result = $jakdb->query('SELECT username FROM '.DB_PREFIX.'user WHERE email = "'.smartsql($femail).'" LIMIT 1');
	    	$row = $result->fetch_assoc();
	    	
	    	if (!$result) {
	    		jak_redirect(FULL_SITE_DOMAIN);
	    	} else {
	    		$jakuserlogin->jakLogin($row['username'], $_POST['password'], 0);
	    	    jak_redirect(FULL_SITE_DOMAIN.'/loginForm.php');
	    	    
	    	}
	    
	    } else {
	    	$errorrp = $errors;
	    }
	}
	
	// Register Form
	if (isset($_POST['registerRF']) && JAK_REGISTER_ON) {
	
		// Check Human Verification
		if ($_POST['human'] == '' || md5($_POST['human']) != $_SESSION['JAK_HUMAN_IMAGE']) {
			$errors['e3'] = $langvar["error_captcha"];   
		} else {
			
	    
	    if (!preg_match('/^([a-zA-Z0-9\-_])+$/', $_POST['username'])) {
	    	$errors['e'] = $langvar["error_user"];
	    }
	    
	    if (jak_field_not_exist(strtolower($_POST['username']), 'username')) {
	        $errors['e'] = $langvar["error_user1"];
	    }
	    
	    // Check email if it is double - error
	    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	        $errors['e1'] = $langvar["error_email"];
	    }
	    
	    if (jak_field_not_exist(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), 'email')) {
	        	$errors['e1'] = $langvar["error_email1"];
	    }
	    
	    // Check the password
	    if (strlen($_POST['password']) <= '5') {
	    	$errors['e2'] = $langvar["error_pass"];
	    }
	    
	    if ($_POST['password'] != $_POST['confirm_password']) {
	    	$errors['e2'] = $langvar["error_pass1"];
	    }
	    
	    }
	   	
	   	if (count($errors) == 0) {
	   		    
	   		$safeusername = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	   		$safeemail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	   		
	   		// Now check what we have setup in config.php
	   		$uaccess = 1 + JAK_CONFIRM_EMAIL + JAK_CONFIRM_MANUALY;
	   		
	   		$getuniquecode = 0;
	   		
	   		// Get the access
	   		if ($uaccess > 1) {
	   			$getuniquecode = time();
	   		}
	   	
	   		// First the query
	   		$result = $jakdb->query('INSERT INTO '.DB_PREFIX.'user SET '.
	   		'first_name = "'.smartsql($_POST['first_name']).'",'.
	   		'last_name = "'.smartsql($_POST['last_name']).'",'.
	   		'username = "'.smartsql($safeusername).'",'.
	   		'email = "'.smartsql($safeemail).'",'.
	   		'password = "'.hash_hmac('sha256', $_POST['password'], DB_PASS_SALT).'",'.
	   		'access = '.$uaccess.','.
	   		'activatenr = "'.$getuniquecode.'",'.
	   		'time = NOW()');
	   		
	   		$uid = $jakdb->jak_last_id();
	   		
	   		if ($uaccess == 2 || $uaccess == 3) {
	   		
	   			$confirmlink = '<a href="'.FULL_SITE_DOMAIN.'/loginForm.php?page=activate&uid='.$uid.'&code='.$getuniquecode.'&access='.$uaccess.'&uname='.$safeusername.'">'.FULL_SITE_DOMAIN.'/loginForm.php?page=activate&uid='.$uid.'&code='.$getuniquecode.'&access='.$uaccess.'&uname='.$safeusername.'</a>';
	   			
	   			if ($uaccess == 2) { $linkmessage = $langvar["welcomeusr_activate"].$confirmlink; }
	   			if ($uaccess == 3) { $linkmessage = $langvar["welcomeusr_activate_admin"].$confirmlink; }
	   			
	   			$mail = new PHPMailer(); // defaults to using php "mail()"
	   			$body = str_ireplace("[\]", '', $linkmessage);
	   			$mail->SetFrom(JAK_EMAIL_ADDRESS);
	   			$mail->AddAddress($safeemail, $safeusername);
	   			$mail->Subject = JAK_MY_SITE_NAME.' - '.$langvar['registered'];
	   			$mail->MsgHTML($body);
	   			$mail->Send(); // Send email without any warnings
	   		
	   		} else {
	   		
	   			$mail = new PHPMailer(); // defaults to using php "mail()"
	   			$body = str_ireplace("[\]", '', $langvar["welcomeusr"]);
	   			$mail->SetFrom(JAK_EMAIL_ADDRESS);
	   			$mail->AddAddress($safeemail, $safeusername);
	   			$mail->Subject = JAK_MY_SITE_NAME.' - '.$langvar['registered'];
	   			$mail->MsgHTML($body);
	   			$mail->Send(); // Send email without any warnings
	   			
	   		}
	   		
	   		jak_redirect(FULL_SITE_DOMAIN.'/loginForm.php?page=successr');
	   	} else {
	   		$errorfr = $errors;
	   	}
   	}
   	
   		// Change Data, only if we logged in
   		if (isset($_POST['changeRF']) && is_numeric($_SESSION['rfUserid']) && $_SESSION['username'] == $_POST['usr_hidden']) {
   		
   			// Check Human Verification
   			if ($_POST['human'] == '' || md5($_POST['human']) != $_SESSION['JAK_HUMAN_IMAGE']) {
   				$errors['e3'] = $langvar["error_captcha"];   
   			} else {
   		    
   		    if (!preg_match('/^([a-zA-Z0-9\-_])+$/', $_POST['username'])) {
   		    	$errors['e'] = $langvar["error_user"];
   		    }
   		    
   		    if ($_SESSION['username'] != $_POST['usr_hidden'] && jak_field_not_exist(strtolower($_POST['username']), 'username')) {
   		        $errors['e'] = $langvar["error_user1"];
   		    }
   		    
   		    // Check email if it is double - error
   		    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
   		        $errors['e1'] = $langvar["error_email"];
   		    }
   		    
   		    if ($_POST['email'] != $_POST['uemail_hidden'] && jak_field_not_exist(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL), 'email')) {
   		        	$errors['e1'] = $langvar["error_email1"];
   		    }
   		    
   		    // Check if old password has been entered and if so check if it is correct
   		    $passold = smartsql($_POST['passold']);
   		    
   		    if (!empty($passold)) {
   		    
	   		    $user_check = $jakuserlogin->jakCheckuserdata($_SESSION['username'], $passold);
	   		    
	   		    if (!$user_check) {
	   		    	$errors['e4'] = $langvar["error_oldpass"];
	   		    }
	   		    
	   		    if (strlen($_POST['password']) <= '5') {
	   		    	$errors['e2'] = $langvar["error_pass"];
	   		    }
	   		    
	   		    if ($_POST['password'] != $_POST['confirm_password']) {
	   		    	$errors['e2'] = $langvar["error_pass1"];
	   		    }
	   		    
	   		}
	   		
	   		}
   		   	
   		   	if (count($errors) == 0 && $_SESSION['rfUserid'] == $_POST['uid']) {
   		   	
   		   		// empty var
   		   		$password = '';
   		   	
   		   		$safeusername = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
   		   		$safeemail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   		   		
   		   		if (!empty($passold) && !empty($_POST['password']))  {
   		   			$password = 'password = "'.hash_hmac('sha256', $_POST['password'], DB_PASS_SALT).'",';
   		   		}
   		   	
   		   		// First the query
   		   		$result = $jakdb->query('UPDATE '.DB_PREFIX.'user SET 
   		   		username = "'.smartsql($safeusername).'",
   		   		'.$password.'
   		   		email = "'.smartsql($safeemail).'"
   		   		WHERE id = "'.$_SESSION['rfUserid'].'"');
   		   		
   		   		jak_redirect(FULL_SITE_DOMAIN.'/loginForm.php?page=successc');
   		   	} else {
   		   		$errorfr = $errors;
   		   	}
   	   	}
}
?>
