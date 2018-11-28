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

class JAK_user
{
	private $data;
	private $jakvar = 0;
	private $useridarray;
	private $username = '';
	private $userid = '';
	
	public function __construct($row)
	{
		/*
		/	The constructor
		*/
		
		$this->data = $row;
	}
	
	function jakSuperadminaccess($jakvar)
	{
		$useridarray = explode(',', JAK_SUPERADMIN);
		// check if userid exist in db.php
		if (in_array($jakvar, $useridarray)) {
			return true;
		} else {
			return false;
		}
	
	}
	
	function getVar($jakvar)
	{
		
		// Setting up an alias, so we don't have to write $this->data every time:
		$d = $this->data;
		
		return $d[$jakvar];
		
	}
}
?>
