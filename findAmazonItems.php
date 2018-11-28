<?php
$lock_page = true;
include_once "rfclass/check_login.php";
include_once "lib_THEsite.php";
require_once 'class.db.php';
require_once 'config.php';
error_reporting(E_ERROR);
set_time_limit(0);
include_once 'AmazonECS.class.php';

$mysqlidb = new mysqli_mysql(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
$mysqlidb->set_charset("utf8");

$locationFind='com';

    ////get necessary IDs 
  /*
    $query="SELECT * FROM `amazon_sellers` WHERE sellerName=\"".mysql_real_escape_string($sellerName)."\"";
    $result=mysql_query($query,$dblink);
    if(!$result)
    {
            echo "error in sql query!";
            exit;
    }
    if(mysql_num_rows($result)>0)
     {
            while($row=mysql_fetch_assoc($result))
             {
                     $PA_API_KEY=$row['PA_API_KEY'];
                     $PA_API_SECRET_KEY=$row['PA_API_SECRET_KEY'];
                     $ASSOCIATE_TAG=$row['ASSOCIATE_TAG'];
                            if($row['countryToSell']=="USA"){
                                            $locationFind='com';
                                    }
                            if($row['countryToSell']=="UK"){
                                            $locationFind='co.uk';
                                    }
                            if($row['countryToSell']=="DE"){
                                            $locationFind='de';
                                    }
                            if($row['countryToSell']=="FR"){
                                            $locationFind='fr';
                                    }
                            if($row['countryToSell']=="JP"){
                                            $locationFind='co.jp';
                                    }
                            if($row['countryToSell']=="CN"){
                                            $locationFind='cn';
                                    }
                            if($row['countryToSell']=="CA"){
                                            $locationFind='ca';
                                    }
                            if($row['countryToSell']=="IT"){
                                            $locationFind='it';
                                    }
                            if($row['countryToSell']=="ES"){
                                            $locationFind='es';
                                    }
             }
     }else{echo "required info. of the seller not found!check your DB!";exit;}*/

    // get a new object with your API Key and secret key. Lang is optional.
    // if you leave lang blank it will be US.
    //$possibleLocations = array('de', 'com', 'co.uk', 'ca', 'fr', 'co.jp', 'it', 'cn', 'es');
    $amazonEcs = new AmazonECS(AWS_API_KEY, AWS_API_SECRET_KEY, $locationFind, AWS_ASSOCIATE_TAG);

    // If you are at min version 1.3.3 you can enable the requestdelay.
    // This is usefull to get rid of the api requestlimit.
    // It depends on your current associate status and it is disabled by default.
     //$amazonEcs->requestDelay(true);

    // for the new version of the wsdl its required to provide a associate Tag
    // @see https://affiliate-program.amazon.com/gp/advertising/api/detail/api-changes.html?ie=UTF8&pf_rd_t=501&ref_=amb_link_83957571_2&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=&pf_rd_s=assoc-center-1&pf_rd_r=&pf_rd_i=assoc-api-detail-2-v2
    // you can set it with the setter function or as the fourth paramameter of ther constructor above
    $amazonEcs->associateTag(AWS_ASSOCIATE_TAG);

    // changing the category to DVD and the response to only images and looking for some matrix stuff.
    //$response = $amazonEcs->category('DVD')->responseGroup('Large')->search("Matrix Revolutions");
    //var_dump($response);

    // from now on you want to have pure arrays as response
$amazonEcs->returnType(AmazonECS::RETURN_TYPE_ARRAY);

$category=$_GET['category'];
$minPrice=$_GET['minPrice'];
$maxPrice=$_GET['maxPrice'];
$sort=$_GET['sort'];
$keywords=$_GET['Keywords'];
$Title=$_GET['Title'];
$category=$_GET['Category'];

header("Content-type: text/json");


$returnData='{
                    "data": [';

if(
  ($category=="")
   OR
  ($keywords=="")
 ){
    $itemData=
      json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("").',
    '.json_encode("");
    $returnData=$returnData.'[
                                '.$itemData.'
                            ]';
    $returnData=$returnData.
                "]
           }";

    die($returnData);
}
    
    
    $amazonFoundPageNumber=htmlspecialchars($_COOKIE["amazonFoundPageNumber"]);
   
   $allItems=0;
   //$CountOfPages=$response['Items']['TotalPages'];
	   for($i=$amazonFoundPageNumber;$i<($amazonFoundPageNumber+5);$i++){
               
		   if($Title!=""){
				$options['Title']=$Title;
			}
			
			if($minPrice!=""){
				$options['MinimumPrice']=$minPrice;
			}
			
			if($maxPrice!=""){
				$options['MaximumPrice'] = $maxPrice;
			}
			
			if($sort!=""){
				$options['Sort']= $sort;
			}
		   
		if(($Title!="")
			OR
			($minPrice!="")
			OR
			($maxPrice!="")
			OR
			($sort!="")
		   ){
				$response = $amazonEcs->category($category)->optionalParameters($options)->responseGroup('Offers,Images,SalesRank,ItemAttributes')->page($i)->search($keywords);
			}else{
				$response = $amazonEcs->category($category)->responseGroup('Offers,Images,SalesRank,ItemAttributes')->page($i)->search($keywords);
			}
                        
		//parse results from all other pages
		   //echo "$i. page:<br>";
		   $countOfItem=0;
		   foreach($response['Items']['Item'] as $item){
			$title=$item['ItemAttributes']['Title'];
			$UPC=$item['ItemAttributes']['UPC'];
			$ASIN=$item['ASIN'];
			$SalesRank=$item['SalesRank'];
			$LowestNewPrice=$item['OfferSummary']['LowestNewPrice']['FormattedPrice'];
                        //$TotalNew=  print_r($item,true);
                        
                        $IsEligibleForPrime=$item['Offers']['Offer']['OfferListing']['IsEligibleForPrime'];
                        
			$image=$item['LargeImage']['URL'];
			$brand=$item['ItemAttributes']['Brand'];
                        
                        $ProductTypeName=$item['ItemAttributes']['ProductTypeName'];
                        
                        $Height='_'.$item['ItemAttributes'].['ItemDimensions']['Height']['_'].'_'.$item['ItemAttributes']['ItemDimensions']['Height']['Units'];
                        $Length='_'.$item['ItemAttributes']['ItemDimensions']['Length']['_'].'_'.$item['ItemAttributes']['ItemDimensions']['Length']['Units'];
                        $Weight='_'.$item['ItemAttributes']['ItemDimensions']['Weight']['_'].'_'.$item['ItemAttributes']['ItemDimensions']['Weight']['Units'];
                        $Width='_'.$item['ItemAttributes']['ItemDimensions']['Width']['_'].'_'.$item['ItemAttributes']['ItemDimensions']['Width']['Units'];
                        
                        
                        
                        
			$manufacturer=$item['ItemAttributes']['Manufacturer'];
			
			$title=str_replace("\"","",$title);
			$title=preg_replace("{\s+}si"," ",$title);
			
                        if($LowestNewPrice=="null"){$LowestNewPrice=" ";}
                        if($TotalNew=="null"){$TotalNew=" ";}
				/*echo "<Item>\n";
				echo "<itemASIN><![CDATA[$ASIN]]></itemASIN>";
				echo "<title><![CDATA[".$title."]]></title>";
				echo "<SalesRank><![CDATA[$SalesRank]]></SalesRank>";
				echo "<LowestNewPrice><![CDATA[$LowestNewPrice]]></LowestNewPrice>";
				echo "<image><![CDATA[$image]]></image>";
				echo "<brand><![CDATA[$brand]]></brand>";
				echo "<manufacturer><![CDATA[$manufacturer]]></manufacturer>";
				echo "</Item>\n";*/
                                
                                $ListOnEbayButton='<div class="button" style="background-color:#caf8f3;" onclick="'
                                        . 'ListOnEBay('.
                                        '\''.$ASIN.'\','.
                                        '\''.$title.'\','.
                                        '\''.$image.'\','.
                                        '\''.$brand.'\','.
                                        '\''.$manufacturer.'\''.
                                        ');'
                                        . '">List_On_eBay</div>';
                                
                                $itemData=
                                    json_encode($IsEligibleForPrime).','.
                                    //json_encode(print_r($item,true)).','.
                                    json_encode($LowestNewPrice).','.
                                    json_encode($ASIN).','.
                                    json_encode('<img src='.$image.' style="width:150px;height:150px;">').','.
                                    json_encode($SalesRank).','.
                                    json_encode('<div class="button" style="background-color:#caf8f3;" onclick="window.open(\'http://amzn.com/'.$ASIN.'\',\'_blank\');">_Url_Amazon</div>').','.
                                    json_encode($ListOnEbayButton).','.
                                    json_encode('<div class="button" style="background-color:#caf8f3;" onclick="linkToEbayID(\''.$ASIN.'\');">Link_To_eBayID</div>').','.
                                    json_encode($title).','.
                                    json_encode($ProductTypeName).','.
                                    json_encode($brand).','.
                                    json_encode($manufacturer).','.
                                    json_encode($Height).','.
                                    json_encode($Length).','.
                                    json_encode($Weight).','.
                                    json_encode($Width);
			   $countOfItem++;
                           $allItems++;
                                   
                           if($allItems>1){
                                $returnData=$returnData.',[
                                        '.$itemData.'
                                    ]';
                           }else{
                               $returnData=$returnData.'[
                                        '.$itemData.'
                                    ]';
                           }                           
		   }
		   //sleep(1);
		  }

setcookie("amazonFoundPageNumber", $amazonFoundPageNumber, time()+(60*60*24*30));
        
$returnData=$returnData.
            "]
       }";
    
echo $returnData;
?>
