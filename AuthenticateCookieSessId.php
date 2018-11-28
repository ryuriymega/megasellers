<?php
$lock_page = true;
include_once "rfclass/check_login.php";
include_once "lib_THEsite.php";
require_once 'class.db.php';
require_once 'config.php';
include_once("lib_ebay.php");


$userID=$jakuser->getVar("id");
$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$mysqlidb->set_charset("utf8");
////get necessary IDs
$query="SELECT * FROM `user` WHERE id=".$mysqlidb->real_escape_string($userID);
$result=$mysqlidb->query($query);
if(mysqli_num_rows($result)>0){
        while($row = $result->fetch_array()){
                 //$eBayAuthToken=$row['eBayAuthToken'];
                 $sandbox=$row['sandbox'];
                 //$ShippingServiceAdditionalCost=number_format($row['SSACost'],2);
         }
 }else{
     echo "1 query error!";
     exit;         
 }
         
$SessionID=htmlspecialchars($_COOKIE["EbaySessionID"]);
if($SessionID!="#"){
    //////////////////// HEADER OF XML FILE FOR UPLOADING TO EBAY
      $ConfirmIDentityHeaders = array (
      //Regulates versioning of the XML interface for the API
      "X-EBAY-API-COMPATIBILITY-LEVEL:709",

      //set the keys
      "X-EBAY-API-DEV-NAME:".API_DEV_NAME,
      "X-EBAY-API-APP-NAME:".API_APP_NAME,
      "X-EBAY-API-CERT-NAME:".API_CERT_NAME,

     //the name of the call we are requesting
      "X-EBAY-API-SITEID:0",

     //SiteID must also be set in the Request's XML
     //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
     //SiteID Indicates the eBay site to associate the call with
     "X-EBAY-API-CALL-NAME:ConfirmIdentity",
     );
    $data='<?xml version="1.0" encoding="utf-8"?>
    <ConfirmIdentityRequest xmlns="urn:ebay:apis:eBLBaseComponents">
      <SessionID>'.$SessionID.'</SessionID>
    </ConfirmIdentityRequest>';

    $xmlData=makeEbayCall($sandbox,$ConfirmIDentityHeaders,$data);
             if ($xmlData === false) {
                    echo "Failed loading XML: ";
                    foreach(libxml_get_errors() as $error) {
                            echo "<br>", $error->message;
                    }
                    exit;
            } else {
                //echo print_r($xmlData,true);
                    if($xmlData->Ack=="Failure"){
                        if(
                                ($xmlData->Errors->ShortMessage=="SessionID is expired.")
                                OR
                                ($xmlData->Errors->ShortMessage=="The end user has not completed Auth & Auth sign in flow.")){
                            echo "<h2>".$xmlData->Errors->ShortMessage." Please press button '1. AUTH. ON EBAY' here <a href='".FULL_SITE_DOMAIN."/dashboard.php#authEbay'>".FULL_SITE_DOMAIN."/dashboard.php#authEbay</a>, and follow an instructions</h2>";
                        }else{
                            echo "<h2>".$xmlData->Errors->ShortMessage."</h2>";
                        }
                    }else{
//*****if SUCCESS************
//***************************
//***************************
//***************************
//***************************
//***************************
        $ebayUserID=$xmlData->UserID;
        ////////////////////// HEADER OF XML FILE FOR UPLOADING TO EBAY
              $FetchTokenHeaders = array (
              //Regulates versioning of the XML interface for the API
              "X-EBAY-API-COMPATIBILITY-LEVEL:709",

              //set the keys
              "X-EBAY-API-DEV-NAME:".API_DEV_NAME,
              "X-EBAY-API-APP-NAME:".API_APP_NAME,
              "X-EBAY-API-CERT-NAME:".API_CERT_NAME,

             //the name of the call we are requesting
              "X-EBAY-API-SITEID:0",

             //SiteID must also be set in the Request's XML
             //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
             //SiteID Indicates the eBay site to associate the call with
             "X-EBAY-API-CALL-NAME:FetchToken",
             );
            $data='<?xml version="1.0" encoding="utf-8"?>
            <FetchTokenRequest xmlns="urn:ebay:apis:eBLBaseComponents">
              <SessionID>'.$SessionID.'</SessionID>
            </FetchTokenRequest>';

            $xmlData=makeEbayCall($sandbox,$FetchTokenHeaders,$data);
                     if ($xmlData === false) {
                            echo "Failed loading XML: ";
                            foreach(libxml_get_errors() as $error) {
                                    echo "<br>", $error->message;
                            }
                            exit;
                    } else {
                        //echo print_r($xmlData,true);
                        echo "<h2>You successufully authorized, userID = ".
                               $ebayUserID.
                               "<br>".
                               "Back to your dashboard : ".
                               "<div><a href='".FULL_SITE_DOMAIN."/dashboard.php'>".FULL_SITE_DOMAIN."/dashboard.php</a></div>".
                               "</h2>";
                        $userID=$jakuser->getVar("id");
                        saveUser_Token_SessionID_ebayID_ToDB($xmlData->eBayAuthToken,$ebayUserID,$SessionID,$userID);
                        checkAndCreateEBAYRequiredTables($userID);
                    }
//***************************
//***************************
//***************************
//***************************
                    }
            }
}else{
    echo "session Id not found, please press button 1. for begin";
}

?>
