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

class JAK_userlogin
{

	protected $name = '', $email = '', $pass = '', $time = '';
	var $username;     //Username given on sign-up
	
	public function __construct() {
	        $this->username = '';
	    }
	   
	function jakChecklogged(){
	
	      /* Check if user has been remembered */
	      if(isset($_COOKIE['geckoName']) && isset($_COOKIE['geckoId'])){
	         $_SESSION['username'] = $_COOKIE['geckoName'];
	         $_SESSION['idhash'] = $_COOKIE['geckoId'];
	      }
	
	      /* Username and idhash have been set */
	      if(isset($_SESSION['username']) && isset($_SESSION['idhash']) && $_SESSION['username'] != $this->username) {
	         /* Confirm that username and userid are valid */
	         if(!JAK_userlogin::jakConfirmidhash($_SESSION['username'], $_SESSION['idhash'])) {
	            /* Variables are incorrect, user not logged in */
	            unset($_SESSION['username']);
	            unset($_SESSION['idhash']);
	            
	            return false;
	         }
	         
	         // Return the user data
	         return JAK_userlogin::jakUserinfo($_SESSION['username']);
	      }
	      /* User not logged in */
	      else{
	         return false;
	      }
	   }
	
	public static function jakCheckuserdata($username, $pass)
	{
	
		// The new password encrypt with hash_hmac
		$passcrypt = hash_hmac('sha256', $pass, DB_PASS_SALT);
		
		if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
		
			if (!preg_match('/^([a-zA-Z0-9\-_])+$/', $username)) {
				return false;
			}
			
		}
	
		global $jakdb;
		$result = $jakdb->query('SELECT id, username FROM '.DB_PREFIX.'user WHERE (LOWER(username) = "'.strtolower($username).'" OR email = "'.strtolower($username).'") AND password = "'.$passcrypt.'" AND access = 1');
		if ($jakdb->affected_rows > 0) {
			$row = $result->fetch_assoc();
			return $row['username'];
		} else {
			return false;
		}
			
	}

	public static function jakCheckuserdataMYFUNCCHECKcryptData($username, $passcrypt)
	{	
		global $jakdb;
		$result = $jakdb->query('SELECT id, username FROM '.DB_PREFIX.'user WHERE (LOWER(username) = "'.strtolower($username).'" OR email = "'.strtolower($username).'") AND password = "'.$passcrypt.'" AND access = 1');
		if ($jakdb->affected_rows > 0) {
			$row = $result->fetch_assoc();
			return $row['username'];
		} else {
			return false;
		}
			
	}
	
	public static function jakLogin($name, $pass, $remember)
	{
		
		// The new password encrypt with hash_hmac
		$passcrypt = hash_hmac('sha256', $pass, DB_PASS_SALT);
	
		global $jakdb;
		
		// Generate new idhash
		$nidhash = JAK_userlogin::generateRandID();
		
		// Set session in database
		$result = $jakdb->query('UPDATE '.DB_PREFIX.'user SET session = "'.smartsql(session_id()).'", idhash = "'.smartsql($nidhash).'", forgot = IF (forgot != 0, 0, 0), lastactivity = NOW() WHERE username = "'.$name.'" AND password = "'.$passcrypt.'"');
		
		$_SESSION['username'] = $name;
		$_SESSION['idhash'] = $nidhash;
		
		// Check if cookies are set previous (wrongly) and delete
		if (isset($_COOKIE['geckoName']) || isset($_COOKIE['geckoId'])) {
			setcookie("geckoName", "", time() - JAK_COOKIE_TIME, JAK_COOKIE_PATH);
			setcookie("geckoId",   "", time() - JAK_COOKIE_TIME, JAK_COOKIE_PATH);
		}
		
		// Now check if remember is selected and set cookies new...
		if ($remember) {
			setcookie("geckoName", $name, time() + JAK_COOKIE_TIME, JAK_COOKIE_PATH, "", false, true);
			setcookie("geckoId",   $nidhash, time() + JAK_COOKIE_TIME, JAK_COOKIE_PATH, "", false, true);
		}
		
	}
	
	public static function jakLoginMYFUNCCHECKcryptData($name, $passcrypt, $remember)
	{	
		global $jakdb;
		
		// Generate new idhash
		$nidhash = JAK_userlogin::generateRandID();
		
		// Set session in database
		$result = $jakdb->query('UPDATE '.DB_PREFIX.'user SET session = "'.smartsql(session_id()).'", idhash = "'.smartsql($nidhash).'", forgot = IF (forgot != 0, 0, 0), lastactivity = NOW() WHERE username = "'.$name.'" AND password = "'.$passcrypt.'"');
		
		$_SESSION['username'] = $name;
		$_SESSION['idhash'] = $nidhash;
		
		// Check if cookies are set previous (wrongly) and delete
		if (isset($_COOKIE['geckoName']) || isset($_COOKIE['geckoId'])) {
			setcookie("geckoName", "", time() - JAK_COOKIE_TIME, JAK_COOKIE_PATH);
			setcookie("geckoId",   "", time() - JAK_COOKIE_TIME, JAK_COOKIE_PATH);
		}
		
		// Now check if remember is selected and set cookies new...
		if ($remember) {
			setcookie("geckoName", $name, time() + JAK_COOKIE_TIME, JAK_COOKIE_PATH, "", false, true);
			setcookie("geckoId",   $nidhash, time() + JAK_COOKIE_TIME, JAK_COOKIE_PATH, "", false, true);
		}
		
	}
	
	public static function jakConfirmidhash($username, $idhash)
	{
	
		global $jakdb;
		
		if (isset($username)) {
		
		    $result = $jakdb->queryRow('SELECT idhash FROM '.DB_PREFIX.'user WHERE LOWER(username) = "'.smartsql(strtolower($username)).'" AND access = 1');
		    
		    if ($jakdb->affected_rows < 1) {
		    
		    	return false;
		        
		    } else {
		    
		    	$result['idhash'] = stripslashes($result['idhash']);
		    	$idhash = stripslashes($idhash);
		    			    	
		    	/* Validate that userid is correct */
		    	if(!is_null($result['idhash']) && $idhash == $result['idhash']) {
		    		
		    		return true; //Success! Username and idhash confirmed
		    		
		    	} else {
		    		return false; //Indicates idhash invalid
		    	}
		    
		    }
		} else {
			return false;
		}
			
	}
	
	public static function jakUserinfo($username)
	{
	
			global $jakdb;
			$result = $jakdb->queryRow('SELECT * FROM '.DB_PREFIX.'user WHERE LOWER(username) = "'.smartsql(strtolower($username)).'" AND access = 1');
			if (!$result || $jakdb->affected_rows < 1) {
			   return NULL;
			} else {
				return $result;
			}
			
	}
	
	public static function jakUpdatelastactivity($userid)
	{
	
			global $jakdb;
			$jakdb->query('UPDATE '.DB_PREFIX.'user SET lastactivity = NOW() WHERE id = "'.smartsql($userid).'"');
			
	}
	
	public static function jakForgotpassword($email, $time)
	{
	
			global $jakdb;
			$jakdb->query('SELECT id FROM '.DB_PREFIX.'user WHERE email="'.smartsql($email).'" AND access = 1 LIMIT 1');
			if ($jakdb->affected_rows > 0) {
				if ($time != 0) {
				$jakdb->query('UPDATE '.DB_PREFIX.'user SET forgot = "'.smartsql($time).'" WHERE email="'.smartsql($email).'"');
				}
			    return true;
			} else {
			    return false;
			}
			
	}
	
	public static function jakForgotactive($forgotid)
	{
	
			global $jakdb;
			$jakdb->query('SELECT id FROM '.DB_PREFIX.'user WHERE forgot = "'.smartsql($forgotid).'" AND access = 1 LIMIT 1');
			if ($jakdb->affected_rows > 0) {
			    return true;
			} else
			    return false;
			
	}
	
	public static function jakWriteloginlog($username, $url, $ip, $agent, $success)
	{
	
			global $jakdb;
			if ($success == 1) {
			
				$jakdb->query('UPDATE '.DB_PREFIX.'loginlog SET access = 1 WHERE ip = "'.smartsql($ip).'" AND time = NOW()');
			} else {
			
				$jakdb->query('INSERT INTO '.DB_PREFIX.'loginlog SET username = "'.smartsql($username).'", fromwhere = "'.smartsql($url).'", ip = "'.smartsql($ip).'", usragent = "'.smartsql($agent).'", time = NOW(), access = 0');
			}
			
	}
	
	public static function jakLogout($userid)
	{
	
			global $jakdb;
			
			// Delete cookies from this page
			if (isset($_COOKIE['geckoName']) || isset($_COOKIE['geckoId'])) {
				setcookie('geckoName', "", time() - JAK_COOKIE_TIME, JAK_COOKIE_PATH);
				setcookie('geckoId', "", time() - JAK_COOKIE_TIME, JAK_COOKIE_PATH);
			}
			
			// Update Database to session NULL
			$jakdb->query('UPDATE '.DB_PREFIX.'user SET session = NULL, idhash = NULL WHERE id = "'.$userid.'"');
			
			// Unset the main sessions
			unset($_SESSION['username']);
			unset($_SESSION['idhash']);
			
			// Destroy session and generate new one for that user
			session_destroy();
			session_regenerate_id();
			
	}
	
	public static function generateRandStr($length){
	   $randstr = "";
	   for($i=0; $i<$length; $i++){
	      $randnum = mt_rand(0,61);
	      if($randnum < 10){
	         $randstr .= chr($randnum+48);
	      }else if($randnum < 36){
	         $randstr .= chr($randnum+55);
	      }else{
	         $randstr .= chr($randnum+61);
	      }
	   }
	   return $randstr;
	}
	
	public static function generateRandID(){
	   return md5(JAK_userlogin::generateRandStr(16));
	}
}
?>
