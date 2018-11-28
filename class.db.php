<?php

/* Create custom exception classes */
class ConnectException extends Exception {}
class QueryException extends Exception {}

class mysqli_mysql extends mysqli
{
	private $host_address;
	private $user;
	private $password;
	private $db_name;
	private $db_port;
	
	function __construct($host_address, $user, $password, $db_name, $db_port)
	{
		parent::__construct($host_address, $user, $password, $db_name, $db_port);

	    //work with errors exceptions
		if(mysqli_connect_error())
		{
			$this->mysqli_throw_error(mysqli_connect_error(), mysqli_connect_errno());
		} 
	}
	
	public function queryRow($query)
	{
		$result = parent::query($query);
		$query_data = mysqli_fetch_array($result, MYSQL_ASSOC);
		return $query_data;
	}
	
	public function query($query)
	{
		$result = parent::query($query); 
	  if(mysqli_error($this))
		{
			//if error exception
			$this->mysqli_throw_error("Error exec. Query:".$query);
		}
		
		return $result;
	}
	
	public function mysqli_last_id()
	{
		return $this->insert_id;
	}
	
	public function mysqli_close()
	{
		if (!@mysqli_close($this)) {
			$this->mysqli_throw_error("Error when Close sql");
		}
	}
	
	public function mysqli_throw_error($msg='') {
		?>
			Error Exception
			<br>Message:<br><?php echo $msg; ?>
			<?php if(strlen($this->error)>0) echo '<br><strong>=query exec. error:</strong>'.$this->error; ?>
			<br>request url: <?php echo @$_SERVER['REQUEST_URI']; ?><br>
			<?php if(strlen(@$_SERVER['HTTP_REFERER'])>0) echo '<br>http referer : <br>'.@$_SERVER['HTTP_REFERER']; ?>
			<br>
		<?php
		exit;
	}
	
	public function save_msg_to_log($log_table,$iswork,$msg,$time){
			//first check a count of records in the table
			 $query="SELECT * FROM `".$log_table."`";
			 $result=$this->query($query);
			 //and remove all if there more than 1000 records
			 if(mysqli_num_rows($result)>1000){
				$query="DELETE FROM `$log_table`";
				$result=$this->query($query);
			  }
			///
				
			 $query="INSERT INTO `$log_table`(`iswork`,`event_time`,`event_msg`) ".
			 "VALUES(".$this->real_escape_string($iswork).",".
			 $this->real_escape_string($time).",\"".
			 $this->real_escape_string($msg)."\")";
			 
			 $result=$this->query($query);
			 $logid=$this->mysqli_last_id();
			  
			 $query="UPDATE `datas_latest` SET logid=\"".$logid."\" WHERE name=\"".$log_table."\"";
			 $result=$this->query($query);
	}
	
	public function get_status($log_table){
			$status="can_to_work";
			
			$query="SELECT * FROM `datas_latest` WHERE name=\"".$log_table."\"";
			$result=$this->query($query);
			 
			 if(mysqli_num_rows($result)>0){
			 while($row = $result->fetch_array()){
				   $logid=$row['logid'];
				 }
				  
				 $query="SELECT * FROM ".$log_table." WHERE id=".$logid;
				 $result=$this->query($query);
				 if(mysqli_num_rows($result)>0){
				 while($row = $result->fetch_array()){
					   $iswork=$row['iswork'];
					   $event_time=getdate($row['event_time']);
					   $event_msg=$row['event_msg'];
				  }
				 }else{		
						return "can_to_work";
				 }
			 }else{
					echo "record for \"".$log_table."\" not found in the table `datas_latest`";
					exit;
			 }
			 
			 $today=getdate();
			 $diff=(date('U',mktime($today[hours],$today[minutes],0,$today[mon],$today[mday],$today[year]))-date('U',mktime($event_time[hours],$event_time[minutes],0,$event_time[mon],$event_time[mday],$event_time[year])))/60;
			 if(($iswork==1)AND($diff<100)){
				   return "working_now";
			 }else{
				   return "can_to_work";
			 }
	}
	
	public function lastId()
	{
		return $this->insert_id;
	}

}
?>
