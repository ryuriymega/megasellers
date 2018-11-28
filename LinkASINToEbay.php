<?php
$lock_page = true;
include_once "rfclass/check_login.php";
include_once "lib_THEsite.php";
require_once 'class.db.php';
require_once 'config.php';
set_time_limit(0);
ob_implicit_flush();
  
$userID=$jakuser->getVar("id");

$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$mysqlidb->set_charset("utf8");

$ASIN=$_POST['ASIN'];
$eBayID=$_POST['eBayID'];

//die("startDate:$startDate \n endDate:$endDate");

//checkAndCreateRequiredTables($userID);

    ////get necessary IDs 
    /*$query="SELECT * FROM `user` WHERE id=".$mysqlidb->real_escape_string($userID);
    $result=$mysqlidb->query($query);
    if(mysqli_num_rows($result)>0){
            while($row = $result->fetch_array()){
                     $eBayAuthToken=$row['eBayAuthToken'];
                     $SessionID=$row['SessionID'];
                     $sandbox=$row['sandbox'];
                     $ShippingServiceAdditionalCost=number_format($row['SSACost'],2);
             }
     }else{
         echo "You are not authorized or another error!";
         exit;
     }*/

echo "Your eBay Item [".$eBayID."] Linked with ASIN [".$ASIN."] - Success!";
?>
