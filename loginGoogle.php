<?php 
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
include_once "templates/base.php";
session_start();

require_once realpath(dirname(__FILE__) . '/src/Google/autoload.php');




// First we need the config.php file
include_once 'rfclass/config.php';
// Get the jak DB class
if (JAK_MYSQL_CONNECTION == 1) {
	require_once 'class.db.php';
} else {
	require_once 'class.dbn.php';
}
// MySQLi connection
$jakdb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$jakdb->set_charset("utf8");

// Get the user class
include_once 'rfclass/class.userlogin.php';
// Include all important files
include_once 'rfclass/functions.php';
include_once 'rfclass/class.user.php';
include_once "lib_THEsite.php";

// Check if user is logged in
$jakuserlogin = new JAK_userlogin();
$jakuserrow = $jakuserlogin->jakCheckLogged();
$jakuser = new JAK_user($jakuserrow);
if ($jakuser) {
	$_SESSION['rfUserid'] = $jakuser->getVar("id");	
	checkGoogleAccount();
} else {
	///////////////////////////////////////
	unset($_SESSION['rfUserid']);
	///create page with notification about already logged in
	die('<!DOCTYPE HTML><!--by HTML5 UPhtml5up.net | @n33coFree for '.
	'personal and commercial use under the CCA 3.0 license (html5up.net/license)--><html>'.
	getHTMLHead().'<body class="homepage" onLoad="checkResolution();">'.
	'<script>		
		function checkResolution() {
						wndWidth=$("body").width();
						if(wndWidth<1200){
							document.getElementById("NAV3").id="NAV3_1000";
							document.getElementById("nav").id="nav_1000";
						}
					}
		</script>'.
	'<!-- Header Wrapper -->'.getHTMLHeader(false,$jakuser).
	'<!-- Main Wrapper -->
			<div id="main-wrapper">
				<div class="wrapper style3">
					<div class="inner">
						<div class="container">'.
						'You already logged in.'.
				'</div>
			</div>
		</div>
	</div>'
	);
	///////////////////////////////////////
	/////DETECTED USER ALREADY LOGGED IN///
	///////////////////////////////////////
}
	
function checkGoogleAccount(){
	/************************************************
	  ATTENTION: Fill in these values! Make sure
	  the redirect URI is to this page, e.g:
	  http://localhost:8080/user-example.php
	 ************************************************/
	 $client_id = 'SSSSSSSSSSSSSSSSSSSSSSS';
	 $client_secret = 'SSSSSSSSSSSSSSSSSSSSSSS';
	 $redirect_uri = 'http://megasellers.ru/loginGoogle.php';

	/************************************************
	  Make an API request on behalf of a user. In
	  this case we need to have a valid OAuth 2.0
	  token for the user, so we need to send them
	  through a login flow. To do this we need some
	  information from our API console project.
	 ************************************************/
	$client = new Google_Client();
	$client->setClientId($client_id);
	$client->setClientSecret($client_secret);
	$client->setRedirectUri($redirect_uri);        
	//$client->addScope("https://www.googleapis.com/auth/urlshortener");
	$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email',
							 'https://www.googleapis.com/auth/userinfo.profile',
							 'https://www.googleapis.com/auth/plus.me'));
	/************************************************
	  When we create the service here, we pass the
	  client to it. The client then queries the service
	  for the required scopes, and uses that when
	  generating the authentication URL later.
	 ************************************************/
	$service = new Google_Service_Plus($client);
        
	/************************************************
	  If we're logging out we just need to clear our
	  local access token in this case
	 ************************************************/
	if (isset($_REQUEST['logout'])) {
	  unset($_SESSION['access_token']);
	}

	/************************************************
	  If we have a code back from the OAuth 2.0 flow,
	  we need to exchange that with the authenticate()
	  function. We store the resultant access token
	  bundle in the session, and redirect to ourself.
	 ************************************************/
	if (isset($_GET['code'])) {
	  $client->authenticate($_GET['code']);
	  $_SESSION['access_token'] = $client->getAccessToken();
	  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	}

	/************************************************
	  If we have an access token, we can make
	  requests, else we generate an authentication URL.
	 ************************************************/
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	  $client->setAccessToken($_SESSION['access_token']);
	} else {
	  $authUrl = $client->createAuthUrl();
	}
        
	if (isset($authUrl)) {
	  //echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
	  header("Location: ".$authUrl,true);          
	} else {
	  $userProfile = $service->people->get('me');
	  $emails = $userProfile->getEmails();	  
          $first_name=$userProfile['name']['givenName'];
	  $last_name=$userProfile['name']['familyName'];
	  $gPlusID=$userProfile['id'];
	  $email=$emails[0]->value;
	  
	  /*print_r($emails);
	  echo '<br>'.
	  $first_name.
	  '<br>'.
	  $last_name.
	  '<br>'.
	  $gPlusID.
	  '<br>'.
	  $email.
	  '<br>';
          exit;*/
	  
	  $pass=randomPassword();
          
	  if($email==""){
					die('<!DOCTYPE HTML><!--by HTML5 UPhtml5up.net | @n33coFree for '.
					'personal and commercial use under the CCA 3.0 license (html5up.net/license)--><html>'.
					getHTMLHead().'<body class="homepage" onLoad="checkResolution();">'.
					'<script>		
						function checkResolution() {
										wndWidth=$("body").width();
										if(wndWidth<1200){
											document.getElementById("NAV3").id="NAV3_1000";
											document.getElementById("nav").id="nav_1000";
										}
									}
						</script>'.
					'<!-- Header Wrapper -->'.getHTMLHeader(false,$jakuser).
					'<!-- Main Wrapper -->
							<div id="main-wrapper">
								<div class="wrapper style3">
									<div class="inner">
										<div class="container">'.
										'No emails found in your google profile, please check it'.
								'</div>
							</div>
						</div>
					</div>'
					);
				}else{
					require_once 'class.db.php';
					$jakdb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
					$jakdb->set_charset("utf8");
					
					checkIfUserInDB($gPlusID,$first_name,$last_name,$email,$pass,$jakdb,$jakuserlogin);
				}
	}
}
 ?>
