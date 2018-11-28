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

// Redirect to something...
function jak_redirect($url, $code = 302)
{
    header('Location: '.$url, true, $code);
    exit();
}

// Get a secure mysql input
function smartsql($value)
{
	global $jakdb;
	if (get_magic_quotes_gpc()) {
	$value = stripslashes($value);
	}
    if (!is_int($value)) {
        $value = $jakdb->real_escape_string($value);
    }
    return $value;
}

// Check if userid can have access to the forum, blog, gallery etc.
function jak_get_access($userid)
{
	// Get userid's from the config.php file
	$admin_userid = explode(',', JAK_SUPERADMIN);
	
	if (in_array($userid, $admin_userid)) {
		return true;
	}
}

// Check if row exist with custom field
function jak_field_not_exist($check, $field)
{
		global $jakdb;
		$result = $jakdb->query('SELECT id FROM '.DB_PREFIX.'user WHERE LOWER('.$field.') = "'.smartsql($check).'" LIMIT 1');
        if ($jakdb->affected_rows > 0) {
        return true;
}
}

// Check if row exist
function jak_row_exist($id)
{
		global $jakdb;
		$result = $jakdb->query('SELECT id FROM '.DB_PREFIX.'user WHERE id = "'.smartsql($id).'" LIMIT 1');
        if ($jakdb->affected_rows > 0) {
        return true;
}
}

// Get total from a table
function jak_get_total($table, $jakvar1)
{
	if (!empty($jakvar1)) {
		$sqlwhere = ' WHERE access <= 1';
	} else {
		$sqlwhere = '';
	}
		global $jakdb;
		$result = $jakdb->query('SELECT COUNT(*) as totalAll FROM '.$table.$sqlwhere.'');
		$row = $result->fetch_assoc();
		
		return $row['totalAll'];
}

// Get all user out the database limited with the paginator
function jak_admin_search($jakvar, $table) 
{
	$jakdata = '';
	global $jakdb;
    $result = $jakdb->query('SELECT * FROM '.$table.' WHERE access <= 1 AND (id like "%'.$jakvar.'%" OR username like "%'.$jakvar.'%" OR email like "%'.$jakvar.'%") ORDER BY id ASC LIMIT 20');
     while ($row = $result->fetch_assoc()) {
            // collect each record into $_data
            $jakdata[] = $row;
        }
        
    return $jakdata;
}

// Check if user exist and it is possible to delete ## (config.php)
function jak_user_exist_deletable($jakvar)
{
	global $jakdb;
	$useridarray = explode(',', JAK_SUPERADMIN);
	// check if userid is protected in the config.php
	if (in_array($jakvar, $useridarray)) {
	       return false;
	} else {
		$result = $jakdb->query('SELECT id FROM '.DB_PREFIX.'user WHERE id = "'.smartsql($jakvar).'" LIMIT 1');
	    if ($jakdb->affected_rows > 0) return true;
	}
}

// Password generator
function jak_password_creator($length = 8)
{
	return substr(md5(rand().rand()), 0, $length);
}

// Current Page URL
function selfURL(){
    if(!isset($_SERVER['REQUEST_URI'])){
        $serverrequri = $_SERVER['PHP_SELF'];
    }else{
        $serverrequri =    $_SERVER['REQUEST_URI'];
    }
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;   
}
function strleft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}
?>
