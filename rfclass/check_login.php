<?php
define('APP_PATH', dirname(__file__) . DIRECTORY_SEPARATOR);

// Start the session
session_start();

// First we need the config.php file
include_once 'rfclass/config.php';

include_once APP_PATH.'functions.php';

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
include_once APP_PATH.'class.userlogin.php';
// Include all important files
include_once APP_PATH.'class.user.php';

// Check if user is logged in
$jakuserlogin = new JAK_userlogin();
$jakuserrow = $jakuserlogin->jakCheckLogged();
$jakuser = new JAK_user($jakuserrow);

// Redirect if we lock the page
if ($lock_page && !$jakuserrow) jak_redirect('loginForm.php');

// Update if there is a logged user
if ($jakuser) {
	$_SESSION['rfUserid'] = $jakuser->getVar("id");
} else {
	unset($_SESSION['rfUserid']);
}

if (is_numeric($_SESSION['rfUserid'])) {
	
	// Update last activity from this user
	$jakuserlogin->jakUpdatelastactivity($_SESSION['rfUserid']);
	
}
?>
