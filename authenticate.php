<?php
$lock_page = true;
include_once "rfclass/check_login.php";
include_once "lib_THEsite.php";
require_once 'class.db.php';
require_once 'config.php';
include_once("lib_ebay,php");
/*
	 $API_APP_NAME='YSSSSSSSSSSSSSSSSS';
	 $API_DEV_NAME='SSSSSSSSSSSSSSSSSSS';
	 $API_CERT_NAME='SSSSSSSSSSSSS89';
	 //$eBayAuthToken=;
	 $EbayAppRuName="SSSSSSSSSSSSSSSSpeg";
	 $sandbox='0';
	 

//////////////////// HEADER OF XML FILE FOR UPLOADING TO EBAY
          $headers = array (
          //Regulates versioning of the XML interface for the API
          "X-EBAY-API-COMPATIBILITY-LEVEL:709",
   
          //set the keys
          "X-EBAY-API-DEV-NAME:$API_DEV_NAME",
          "X-EBAY-API-APP-NAME:$API_APP_NAME",
          "X-EBAY-API-CERT-NAME:$API_CERT_NAME",
   
         //the name of the call we are requesting
          "X-EBAY-API-SITEID:0",
   
         //SiteID must also be set in the Request's XML
         //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
         //SiteID Indicates the eBay site to associate the call with
         "X-EBAY-API-CALL-NAME:GetSessionID",
         );
    
////////////////////BODY OF XML FILE FOR UPLOADING TO EBAY			
		$data ='<?xml version="1.0" encoding="utf-8"?>
				<GetSessionIDRequest xmlns="urn:ebay:apis:eBLBaseComponents">
				  <RuName>'.$EbayAppRuName.'</RuName>
				</GetSessionIDRequest>';

		 $xmlData=makeEbayCall($sandbox,$headers,$data);
		 if ($xmlData === false) {
			echo "Failed loading XML: ";
			foreach(libxml_get_errors() as $error) {
				echo "<br>", $error->message;
			}
			exit;
		} else {
			//print_r($xmlData);
			$SessionID=$xmlData->SessionID;
		}

echo $SessionID;

/////////NOW CONFIRM IDENTITY
//ONLY IF WAS SUCCESS OF REQUEST
if(stristr(print_r($xmlData,true),"Success")!==false){
	//////////////////// HEADER OF XML FILE FOR UPLOADING TO EBAY
          $ConfirmIDentityHeaders = array (
          //Regulates versioning of the XML interface for the API
          "X-EBAY-API-COMPATIBILITY-LEVEL:709",
   
          //set the keys
          "X-EBAY-API-DEV-NAME:$API_DEV_NAME",
          "X-EBAY-API-APP-NAME:$API_APP_NAME",
          "X-EBAY-API-CERT-NAME:$API_CERT_NAME",
   
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
			print_r($xmlData);
			//$userID=$xmlData->SessionID;
		}
}
 * 
 */
?>
