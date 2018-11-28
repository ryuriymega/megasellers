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

// Database connection and setup
define('DB_HOST', 'SSSSSSSSSSSSSSSSSSSSSSS'); // Database host ## Datenbank Server
define('DB_PORT', 3306); // Enter the database port for your mysql server
define('DB_USER', 'SSSSSSSSSSSSSSSSSSSSSSS'); // Database user ## Datenbank Benutzername
define('DB_PASS', 'SSSSSSSSSSSSSSSSSSSSSSS'); // Database password ## Datenbank Passwort
define('DB_NAME', 'SSSSSSSSSSSSSSSSSSSSSSS'); // Database name ## Datenbank Name
define('DB_PREFIX', ''); // Database prefix use (a-z) and (_)

// Define a unique key for your site, don't change after, or people can't login anymore for example: 3l2kLOk2so*+DasD34!
define('DB_PASS_SALT', 'SSSSSSSSSSSSSSSSSSSSSSS');

// Define your site url, for example: http://www.jakcms.com
define('FULL_SITE_DOMAIN', 'http://megasellers.ru');

// Define cookie path and lifetime
define('JAK_COOKIE_PATH', '/var/www/');  // Available in the whole domain
define('JAK_COOKIE_TIME', 60*60*24*30); // 30 days by default

// MySQLi or MySQL
define('JAK_MYSQL_CONNECTION', 1); // Use 1 for MySQLi or 2 for

// Main language
define('JAK_MAIN_LANG', 'en'); // Define the standard language, make sure the file exists in the rflang directory (e.g. en.php)

// Main Settings
define('JAK_MY_SITE_NAME', 'http://megasellers.ru'); // Define a site name
define('JAK_EMAIL_ADDRESS', 'yuriymega@yahoo.com'); // Enter your email address (e.g. youremail@domain.com)

// Change only after you created the first administrator
define('JAK_CONFIRM_EMAIL', 0); // Use 1 for yes and 0 for no
define('JAK_CONFIRM_MANUALY', 0); // Use 1 for yes and 0 for no
define('JAK_REGISTER_ON', 1); // Use 1 for yes and 0 for no

// Important Stuff
define('JAK_SUPERADMIN', '1'); // Undeletable and SuperADMIN User, more user seperate with comma. e.g. 1,4,5,6 (userid)

/* ------------ Do not Change ------------- */

define('APP_PATH', dirname(__file__) . DIRECTORY_SEPARATOR);
?>
