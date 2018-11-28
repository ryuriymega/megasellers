<?php

define('FACEBOOK_SDK_V4_SRC_DIR', '/var/www/src/Facebook/');
require __DIR__ . '/autoload.php';

	// Make sure to load the Facebook SDK for PHP via composer or manually

	use Facebook\FacebookSession;
	// add other classes you plan to use, e.g.:
	 use Facebook\FacebookRequest;
	 use Facebook\GraphUser;
	 use Facebook\FacebookRequestException;
	 use Facebook\FacebookRedirectLoginHelper;

// start session
session_start();
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
	checkFacebookAccount();
} else {
	///////////////////////////////////////
	unset($_SESSION['rfUserid']);
	///create page with notification about already logged in
	die('<!DOCTYPE HTML><!--HTML5 UPhtml5up.net | @n33coFree for '.
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

function checkFacebookAccount(){

	// init app with app id and secret
	FacebookSession::setDefaultApplication('785296094902670','a2cb444a520c1255131150b0fc977940');

	// Add `use Facebook\FacebookRedirectLoginHelper;` to top of file
	$helper = new FacebookRedirectLoginHelper('http://megasellers.ru/loginFacebook.php');

	try {
	  $session = $helper->getSessionFromRedirect();
	} catch(FacebookRequestException $ex) {
	  // When Facebook returns an error
	  echo("\nFacebook returns error \n".$ex);
	} catch(\Exception $ex) {
	  // When validation fails or other local issues
	  echo("validation fails or other local issues".$ex);
	}

	// see if we have a session
	if ( isset( $session ) ) {
	  // graph api request for user data
	  $request = new FacebookRequest( $session, 'GET', '/me' );
	  $response = $request->execute();

	  // get response
	  // Get the base class GraphObject from the response
		$object = $response->getGraphObject();

	  // print data
	  echo '<pre>' . print_r( $object, 1 ) . '</pre>';
		
		if(preg_match("{\[id\] \=\> ([0-9]+)\s+}siu",print_r( $object, 1 ),$arrParms)){
			$id=$arrParms[1];
		}else{
			die('preg error : <pre>' . print_r( $object, 1 ) . '</pre>');
		}
		
		$first_name=$object->getProperty('first_name');
		$last_name=$object->getProperty('last_name');	
		$email=$object->getProperty('email');
		$pass=randomPassword();
		
		if($object->getProperty('email')==""){
				die('<!DOCTYPE HTML><!--HTML5 UPhtml5up.net | @n33coFree for '.
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
									'No emails found in your facebook profile, please check it'.
							'</div>
						</div>
					</div>
				</div>'
				);
			}else{
				/*echo "email found -> ".$email."<br>";
				echo "first_name -> ".$first_name."<br>";
				echo "last_name -> ".$last_name."<br>";
				echo "pass -> ".$pass."<br>";*/
				require_once 'class.db.php';
				$jakdb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
				$jakdb->set_charset("utf8");
                                
				checkIfUserInDB($object->getProperty('id'),$first_name,$last_name,$email,$pass,$jakdb,$jakuserlogin);
			}
	  
	} else {
	  // show login url
            /*header("Location: ".$helper->getLoginUrl(array(
			'scope'         => 'email',
			'redirect_uri'  => $site_url,
			)),true);*/
            die('<!DOCTYPE HTML><!--HTML5 UPhtml5up.net | @n33coFree for '.
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
									'No emails found in your facebook profile, please check it'.
							'</div>
						</div>
					</div>
				</div>'
				);
	}
}
?>
