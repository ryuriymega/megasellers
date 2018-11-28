<?php

/* Create custom exception classes */
class ConnectException extends Exception {}
class QueryException extends Exception {}

class jak_mysql extends mysqli
{

	private $host;
	private $username;
	private $passwd;
	private $dbname;
	private $dbport;
	
	function __construct($host, $username, $passwd, $dbname, $dbport)
	{
		parent::__construct($host, $username, $passwd, $dbname, $dbport);

	    /* Throw an error if the connection fails */ 
		if(mysqli_connect_error())
		{
			//throw new ConnectException(mysqli_connect_error(), mysqli_connect_errno());
			$this->jak_throw_error(mysqli_connect_error(), mysqli_connect_errno());
		} 
	}
	
	public function queryRow($query)
	{
		$result = parent::query($query);
		$jakdata = mysqli_fetch_array($result, MYSQL_ASSOC);
		return $jakdata;
	}
	
	public function query($query)
	{
		$result = parent::query($query); 
	  if(mysqli_error($this))
		{
			// throw new QueryException(mysqli_error($this), mysqli_errno($this));
			$this->jak_throw_error("<b>MySQL Query fail:</b> $query");
		}
		
		return $result;
	}
	
	public function jak_last_id()
	{
		return $this->insert_id;
	}
	
	public function jak_close()
	{
		if (!@mysqli_close($this)) {
			$this->jak_throw_error("<b>MySQL Close failed</b>");
		}
	}
	
	public function jak_throw_error($msg='') {
		?>
			<table align="center" border="1" cellspacing="0" style="background:white;color:black;width:80%;">
			<tr><th colspan=2>DB Error</th></tr>
			<tr><td align="right" valign="top">Message:</td><td><?php echo $msg; ?></td></tr>
			<?php if(strlen($this->error)>0) echo '<tr><td align="right" valign="top" nowrap>MySQL Error:</td><td>'.$this->error.'</td></tr>'; ?>
			<tr><td align="right">Date:</td><td><?php echo date("l, F j, Y \a\\t g:i:s A"); ?></td></tr>
			<tr><td align="right">Script:</td><td><a href="<?php echo @$_SERVER['REQUEST_URI']; ?>"><?php echo @$_SERVER['REQUEST_URI']; ?></a></td></tr>
			<?php if(strlen(@$_SERVER['HTTP_REFERER'])>0) echo '<tr><td align="right">Referer:</td><td><a href="'.@$_SERVER['HTTP_REFERER'].'">'.@$_SERVER['HTTP_REFERER'].'</a></td></tr>'; ?>
			</table>
		<?php
		exit;
	}
}
?>
