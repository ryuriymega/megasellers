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

$endDate=$_POST['endDate'];
$startDate=$_POST['startDate'];

//die("startDate:$startDate \n endDate:$endDate");

//checkAndCreateRequiredTables($userID);

    ////get necessary IDs 
    $query="SELECT * FROM `user` WHERE id=".$mysqlidb->real_escape_string($userID);
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
     }
     if($eBayAuthToken==""){
         echo "Not Found Your eBayUserID! <br>You should Authorize Below!";
         exit;
     }
//////////////////// HEADER OF XML FILE FOR UPLOADING TO EBAY
    $headers = array (
        //Regulates versioning of the XML interface for the API
        "X-EBAY-API-COMPATIBILITY-LEVEL:817",

        //set the keys
        "X-EBAY-API-DEV-NAME:".API_DEV_NAME,
        "X-EBAY-API-APP-NAME:".API_APP_NAME,
        "X-EBAY-API-CERT-NAME:".API_CERT_NAME,

       //the name of the call we are requesting
        "X-EBAY-API-SITEID:0",

       //SiteID must also be set in the Request's XML
       //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
       //SiteID Indicates the eBay site to associate the call with
       "X-EBAY-API-CALL-NAME:GetSellerList",
   );

$PageNumber=1;

	/*header("Content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<Items>\n";
	*/ 
	
while($PageNumber!=-1){
		$data = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
		<GetSellerListRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">
		  <RequesterCredentials>
			<eBayAuthToken>$eBayAuthToken</eBayAuthToken>
		  </RequesterCredentials>
		  <DetailLevel>ReturnAll</DetailLevel>
		  <IncludeVariations>true</IncludeVariations>
		  <ErrorLanguage>en_US</ErrorLanguage>
		  <WarningLevel>High</WarningLevel>".
		  "<StartTimeFrom>$startDate</StartTimeFrom>
		  <StartTimeTo>$endDate</StartTimeTo>".
		  "<IncludeWatchCount>true</IncludeWatchCount> 
		  <Pagination> 
			<EntriesPerPage>200</EntriesPerPage>
			<PageNumber>$PageNumber</PageNumber>
		  </Pagination> 
		</GetSellerListRequest>";


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
		 //header("Content-type: text/xml");
		 //echo $response;
		 $xmldata=simplexml_load_string($response);
		 
		 if((string)$xmldata->Ack=="Success"){
			 
			 $TotalNumberOfPages=(string)$xmldata->PaginationResult->TotalNumberOfPages;
			 //echo "<font color=\"green\">TotalNumberOfPages $TotalNumberOfPages<br>";
			 $PageNumber=(string)$xmldata->PageNumber;
			 if($TotalNumberOfPages==$PageNumber){
				//echo "PageNumber(<h1>LAST PAGE</h1>) =$PageNumber <br></font>";
				$PageNumber=-1;
			 }else{
				//echo "PageNumber =$PageNumber <br></font>";
				$PageNumber++;
			}
			 
			 
			  foreach($xmldata->ItemArray->Item as $Item){
				  $SKU="";
				  $SKU=$Item->SKU;
				  $ebayID=$Item->ItemID;
				  $title=$Item->Title;
				  $img=$Item->PictureDetails->PictureURL;
				  $Country=$Item->Country;
				  $Currency=$Item->Currency;
				  $PostalCode=$Item->PostalCode;
				  $PaymentMethods=$Item->PaymentMethods;
				  $PayPalEmailAddress=$Item->PayPalEmailAddress;
				  $CategoryID=$Item->PrimaryCategory->CategoryID;
				  $Quantity=$Item->Quantity;
				  $StartPrice=$Item->StartPrice;
				  $ShippingType=$Item->ShippingDetails->ShippingType;
				  $ShippingService=$Item->ShippingDetails->ShippingServiceOptions->ShippingService;
				  $ShippingServiceCost=$Item->ShippingDetails->ShippingServiceOptions->ShippingServiceCost;
				  //ShippingServiceAdditionalCost 
				  //by default from seller profile
				  //$ShippingServiceAdditionalCost
				  $BuyItNowPrice=$Item->BuyItNowPrice;
				  $ListingDuration=$Item->ListingDuration;
				  $ListingType=$Item->ListingType;
				  
				  //to see if it was sold
				  $QuantitySold=$Item->SellingStatus->QuantitySold;
				  
				  $ListingStatus=$Item->SellingStatus->ListingStatus;
				  if($QuantitySold>0){
					$ListingStatus="Sold";  
				  }
				  

				  $Description=$Item->Description;
				  
				  /*echo "<br><font color=\"green\">$SKU</font><br>";
				  echo "id=$ebayID<br>title=$title<br>";
				  echo "<img src=\"$img\"><br>";
				  echo "$Description<br>";
				  echo "$Country<br>$Currency<br>postalCode=$PostalCode<br>$PaymentMethods<br>";
				  echo "$PayPalEmailAddress<br>catID=$CategoryID<br>$Quantity<br>$StartPrice<br>";
				  echo "$ShippingType<br>$ShippingService<br>$ShippingServiceCost<br>";
				  echo "$ShippingServiceAdditionalCost<br>$BuyItNowPrice<br>$ListingDuration<br>$ListingType<br>$ListingStatus";
				  echo "<br>______________________________________________________________________________<br>";
				  
					echo "<Item>\n";
					echo "<ListingStatus><![CDATA[$ListingStatus]]></ListingStatus>";
					echo "<ebayID><![CDATA[$ebayID]]></ebayID>";
					echo "<sku><![CDATA[".$SKU."]]></sku>";
					echo "<image><![CDATA[".$img."]]></image>";
					echo "<Country><![CDATA[".$Country."]]></Country>";
					echo "<Currency><![CDATA[".$Currency."]]></Currency>";
					echo "<Description><![CDATA[".$Description."]]></Description>";
					echo "<PostalCode><![CDATA[".$PostalCode."]]></PostalCode>";
					echo "<PaymentMethods><![CDATA[".$PaymentMethods."]]></PaymentMethods>";
					echo "<PayPalEmailAddress><![CDATA[".$PayPalEmailAddress."]]></PayPalEmailAddress>";
					echo "<CategoryID><![CDATA[".$CategoryID."]]></CategoryID>";
					echo "<Quantity><![CDATA[".$Quantity."]]></Quantity>";
					echo "<StartPrice><![CDATA[".$StartPrice."]]></StartPrice>";
					echo "<ShippingType><![CDATA[".$ShippingType."]]></ShippingType>";
					echo "<ShippingService><![CDATA[".$ShippingService."]]></ShippingService>";
					echo "<ShippingServiceCost><![CDATA[".$ShippingServiceCost."]]></ShippingServiceCost>";
					echo "<ShippingServiceAdditionalCost><![CDATA[".$ShippingServiceAdditionalCost."]]></ShippingServiceAdditionalCost>";
					echo "<BuyItNowPrice><![CDATA[".$BuyItNowPrice."]]></BuyItNowPrice>";
					echo "<ListingDuration><![CDATA[".$ListingDuration."]]></ListingDuration>";
					echo "<ListingType><![CDATA[".$ListingType."]]></ListingType>";
					echo "<Title><![CDATA[".$title."]]></Title>";
					echo "<QuantitySold><![CDATA[".$QuantitySold."]]></QuantitySold>";
					echo "<Template><![CDATA[]]></Template>";
					echo "</Item>\n";*/
					
					$querySEL="SELECT * FROM ebay_table_tmpl_$userID WHERE `ebayID`=\"$ebayID\"";
					$resultSEL=$mysqlidb->query($querySEL);
					if(mysqli_num_rows($resultSEL)==0){///////if no then insert new items there
						$queryINS="INSERT INTO `ebay_table_tmpl_$userID`("
					   ."`ebayID`,`sku`, `title`, `img`, "
						."`country`, `currency`, `postalcode`, `paymentmethods`, `PayPalEmailAddress`, "
						."`categoryID`, `quantity`, `price`, "
						."`ShippingType`, `ShippingService`, `ShippingServiceCost`,ShippingServiceAdditionalCost,BuyItNowPrice,"
						."`ListingDuration`,`ListingType`,`Description`,"
						."`status`, `statusMessage`,`Template`,`ListingStatus`)"
						." VALUES(\"".$mysqlidb->real_escape_string($ebayID)."\",\"".$mysqlidb->real_escape_string($SKU)."\",\"".$mysqlidb->real_escape_string($title)."\","
						."\"".$mysqlidb->real_escape_string($img)."\",\"".$mysqlidb->real_escape_string($Country)."\","
						."\"".$mysqlidb->real_escape_string($Currency)."\",\"".$mysqlidb->real_escape_string($PostalCode)."\","
						."\"".$mysqlidb->real_escape_string($PaymentMethods)."\",\"".$mysqlidb->real_escape_string($PayPalEmailAddress)."\","
						."\"".$mysqlidb->real_escape_string($CategoryID)."\",\"".$mysqlidb->real_escape_string($Quantity)."\","
						."\"".$mysqlidb->real_escape_string($StartPrice)."\",\"".$mysqlidb->real_escape_string($ShippingType)."\","
						."\"".$mysqlidb->real_escape_string($ShippingService)."\",\"".$mysqlidb->real_escape_string($ShippingServiceCost)."\","
						."\"".$mysqlidb->real_escape_string($ShippingServiceAdditionalCost)."\","
						."\"".$mysqlidb->real_escape_string($BuyItNowPrice)."\","
						."\"".$mysqlidb->real_escape_string($ListingDuration)."\",\"".$mysqlidb->real_escape_string($ListingType)."\","
						."\"".$mysqlidb->real_escape_string($Description)."\",\"synchronized from ebay"
						."\",\"synchronized from ebay\",\"No\",\"".$mysqlidb->real_escape_string($ListingStatus)."\")";
						$resultINS=$mysqlidb->query($queryINS);
					}else{//////else just update it				
						$queryUPD="UPDATE ebay_table_tmpl_$userID SET `sku`=\"".$mysqlidb->real_escape_string($SKU)."\",".
						"`title`=\"".$mysqlidb->real_escape_string($title)."\",".
						"`img`=\"".$mysqlidb->real_escape_string($img)."\",".
						"`country`=\"".$mysqlidb->real_escape_string($Country)."\",".
						"`currency`=\"".$mysqlidb->real_escape_string($Currency)."\",".
						"`postalcode`=\"".$mysqlidb->real_escape_string($PostalCode)."\",".
						"`paymentmethods`=\"".$mysqlidb->real_escape_string($PaymentMethods)."\",".
						"`PayPalEmailAddress`=\"".$mysqlidb->real_escape_string($PayPalEmailAddress)."\",".
						"`categoryID`=\"".$mysqlidb->real_escape_string($CategoryID)."\",".
						"`quantity`=\"".$mysqlidb->real_escape_string($Quantity)."\",".
						"`price`=\"".$mysqlidb->real_escape_string($StartPrice)."\",".
						"`ShippingType`=\"".$mysqlidb->real_escape_string($ShippingType)."\",".
						"`ShippingService`=\"".$mysqlidb->real_escape_string($ShippingService)."\",".
						"`ShippingServiceCost`=\"".$mysqlidb->real_escape_string($ShippingServiceCost)."\",".
						"ShippingServiceAdditionalCost=\"".$mysqlidb->real_escape_string($ShippingServiceAdditionalCost)."\",".
						"BuyItNowPrice=\"".$mysqlidb->real_escape_string($BuyItNowPrice)."\",".
						"`ListingDuration`=\"".$mysqlidb->real_escape_string($ListingDuration)."\",".
						"`ListingType`=\"".$mysqlidb->real_escape_string($ListingType)."\",".
						"`Description`=\"".$mysqlidb->real_escape_string($Description)."\",".
						"`statusMessage`=\"synchronized from ebay\",".
						"`Template`=\"No\",".
						"ListingStatus=\"".$mysqlidb->real_escape_string($ListingStatus)."\"".
						" WHERE `ebayID`=\"$ebayID\"";
						$resultUPD=$mysqlidb->query($queryUPD);
					}
				  
			  }
		 }else{
				die("error detected, response=$response");
			  }
	//echo "</Items>\n";
}
 
echo "Items synchronized - Success!";
?>
