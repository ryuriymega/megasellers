<?php
function makeEbayCall($sandbox,$headers,$data){
//initialise a CURL session
		 $connection = curl_init();
		 //set the server we are using (could be Sandbox or Production server)
		 if($sandbox=="1"){curl_setopt($connection, CURLOPT_URL, "https://api.sandbox.ebay.com/ws/api.dll");}
		 else{curl_setopt($connection, CURLOPT_URL, "https://api.ebay.com/ws/api.dll");}

		 //stop CURL from verifying the peer's certificate
		 curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
		 curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);

		 //set the headers using the array of headers
		 curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);

		 //set method as POST
		 curl_setopt($connection, CURLOPT_POST, 1);
		 curl_setopt($connection, CURLOPT_TIMEOUT, 1000);
		 curl_setopt($connection, CURLOPT_CONNECTTIMEOUT, 250);
		 curl_setopt($connection, CURLOPT_POSTFIELDS, $data);

		 //set it to return the transfer as a string from curl_exec
		  curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);

		 //curl_multi_info_read($connection);
		 //Send the Request
		 $response = curl_exec($connection);
		 //close the connection
		 curl_close($connection);

		$xmlData=simplexml_load_string($response);
		return $xmlData;
}

function getSessionID($userID){
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
         
         //////////////////// HEADER OF XML FILE FOR UPLOADING TO EBAY
          $headers = array (
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
         "X-EBAY-API-CALL-NAME:GetSessionID",
         );
          
         ////////////////////BODY OF XML FILE FOR UPLOADING TO EBAY			
		$data ='<?xml version="1.0" encoding="utf-8"?>
				<GetSessionIDRequest xmlns="urn:ebay:apis:eBLBaseComponents">
				  <RuName>'.EbayAppRuName.'</RuName>
				</GetSessionIDRequest>';

		 $xmlData=makeEbayCall($sandbox,$headers,$data);
		 if ($xmlData === false) {
			echo "Failed loading XML: ";
			foreach(libxml_get_errors() as $error) {
				echo "<br>", $error->message;
			}
			$SessionID="#";
		} else {
			//print_r($xmlData);
			$SessionID=$xmlData->SessionID;
		}
         
         return $SessionID;
}
?>
