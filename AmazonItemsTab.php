<?php
$lock_page = true;
include_once "rfclass/check_login.php";
include_once "lib_THEsite.php";
require_once 'class.db.php';
require_once 'config.php';
include_once("lib_ebay.php");

$userID=$jakuser->getVar("id");

$Title=htmlspecialchars($_COOKIE["Title"]);
$Keywords=htmlspecialchars($_COOKIE["Keywords"]);
$maxPrice=htmlspecialchars($_COOKIE["maxPrice"]);
$minPrice=htmlspecialchars($_COOKIE["minPrice"]);

//set current amazon found page
setcookie("amazonFoundPageNumber", "1", time()+(60*60*24*30));

//$eBayAuthToken=getUserTokenFromDB($userID);
$eBayUserID=geteBayUserIDFromDB($userID);
if($eBayUserID!=""){
    $ebayUserInfo=
    '<div style="border:1px solid #6F6F27;width:400px;padding:50px;padding-bottom:20px;margin-bottom:40px;">
        <p style="font-weight:900;">Your eBayUserID : <font color="green">'.$eBayUserID.'</font></p>
    </div>';
}else{
    $ebayUserInfo=
    '<div style="border:1px solid #6F6F27;width:400px;padding:50px;padding-bottom:20px;margin-bottom:40px;">
        <p style="font-weight:900;">Not Found Your eBayUserID <p style="color:red;font-weight:900;">You should Authorize Below</p></p>
    </div>';
}
$SessionID=getSessionID($userID);
//save SessionID into coockie
setcookie("EbaySessionID", $SessionID, time()+(60*60*24*30));
$url="https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&runame=Yuriy_Sviridov-YuriySvi-2e0f-4-qotgqpeg&SessID=".$SessionID;
?>
<div>
    <div style="width:100%;">        
        <div style="width: 100px;margin-bottom: 50px;">
            <div style="margin-bottom: 50px;">
                Category 
                <select id="Category" style="width: 300px;">
                    <option>Electronics</option>
                    <option>WirelessAccessories</option>
                </select>
            </div>
            <div style="margin-bottom: 50px;">
                Keywords <input style="width: 500px;" value="<?php echo $Keywords;?>" id="Keywords" type="text">
            </div>
            <div style="margin-bottom: 50px;">
                Title <input style="width: 500px;" value="<?php echo $Title;?>" id="Title" type="text">
            </div>
            <div style="margin-bottom: 50px;">
                minPrice <input style="width: 500px;" value="<?php echo $minPrice;?>" id="minPrice" type="text">
            </div>
            <div style="margin-bottom: 50px;">
                maxPrice <input style="width: 500px;" value="<?php echo $maxPrice;?>" id="maxPrice" type="text">
            </div>
            <div style="margin-bottom: 50px;">
                sort
                <select id="sort" style="width: 300px;">
                    <option>
                        salesrank
                    </option>
                    <option>
                        psrank
                    </option>
                    <option>
                        titlerank
                    </option>
                    <option>
                        -titlerank
                    </option>
                </select>
            </div>
            <div style="margin-bottom: 50px;">
                <a class="button" onclick="searchAmazonItems();" style="margin-top:50px;">Search Items on Amazon</a>
            </div>
            <div style="margin-bottom: 50px;">
                <span id="amazonFoundPageNumber">Current find page : 1</span>
            </div>
            <div style="margin-bottom: 50px;">
                <a class="button" onclick="loadMoreAmazonItems();" style="margin-top:50px;">Load More Results From Amazon</a>
            </div>
        </div>
    </div>
</div>

<table id="amazonTable" class="responsive" cellspacing="0" width="80%">
    <thead>
            <tr>
                <th>IsEligibleForPrime</th>
                <th>LowestPrice</th>
                <th>ASIN</th>
                <th>img</th>
                <th>SalesRank</th>                
                <th>ShowOnAmazon</th>
                <th>ListOnEBay</th>
                <th>LinkToEBayID</th>
                <th>title</th>
                <th>ProductTypeName</th>
                <th>brand</th>
                <th>manufacturer</th>
                <th>Height</th>
                <th>Length</th>
                <th>Weight</th>
                <th>Width</th>
            </tr>
        </thead>
</table>

<div style="margin-top:150px;">
    <?php echo $ebayUserInfo;?>
    <h3>If you got error with ebay, probably you need to do next 2 things : 1.Authenticate and 2.Authorize</h3>
    <p>use a buttons below for authentication on ebay site and agree with requirements after this use button 2. for Authorize</p>
    <p id="authEbay" >After these actions you can use your Dashboard</p>
    <a href="<?php echo $url;?>" class="button big" target="_blank">1. Auth. On Ebay</a>
    <a href="AuthenticateCookieSessId.php" class="button big" target="_self">2. Auth. Token</a>
    <p>Vestibulum ultrices risus velit, sit amet blandit massa auctor sit amet. Sed eu lectus sem. Phasellus in odio at ipsum porttitor mollis id vel diam. Praesent sit amet posuere risus, eu faucibus lectus. Vivamus ex ligula, tempus pulvinar ipsum in, auctor porta quam. Proin nec dui cursus, posuere dui eget interdum. Fusce lectus magna, sagittis at facilisis vitae, pellentesque at etiam. Quisque posuere leo quis sem commodo, vel scelerisque nisi scelerisque. Suspendisse id quam vel tortor tincidunt suscipit. Nullam auctor orci eu dolor consectetur, interdum ullamcorper ante tincidunt. Mauris felis nec felis elementum varius.</p>

    <hr />

    <h4>Feugiat aliquam</h4>
    <p>Nam sapien ante, varius in pulvinar vitae, rhoncus id massa. Donec varius ex in mauris ornare, eget euismod urna egestas. Etiam lacinia tempor ipsum, sodales porttitor justo. Aliquam dolor quam, semper in tortor eu, volutpat efficitur quam. Fusce nec fermentum nisl. Aenean erat diam, tempus aliquet erat.</p>

    <p>Etiam iaculis nulla ipsum, et pharetra libero rhoncus ut. Phasellus rutrum cursus velit, eget condimentum nunc blandit vel. In at pulvinar lectus. Morbi diam ante, vulputate et imperdiet eget, fermentum non dolor. Ut eleifend sagittis tincidunt. Sed viverra commodo mi, ac rhoncus justo. Duis neque ligula, elementum ut enim vel, posuere finibus justo. Vivamus facilisis maximus nibh quis pulvinar. Quisque hendrerit in ipsum id tellus facilisis fermentum. Proin mauris dui, at vestibulum sit amet, auctor bibendum neque.</p>
</div>


<script type="text/javascript" src="src/DataTables/datatables.min.js"></script>
<script>
    var table;
    $(document).ready(function() {
        
        table = $('#amazonTable').DataTable( {
            responsive: true,
            "bProcessing": true,
            "oLanguage": {            
                        "sSearch": "",
                        "sLoadingRecords": "Please wait - loading...",
                        "sProcessing": "<img src='images/preloader.gif'/>"
            },
            "ajax": 'findAmazonItems.php'
        });
    });
                    
    function searchAmazonItems(){
        setupCoockie("amazonFoundPageNumber","1");
        setupCoockie("Title",document.getElementById("Title").value);
        setupCoockie("Keywords",document.getElementById("Keywords").value);
        setupCoockie("minPrice",document.getElementById("minPrice").value);
        setupCoockie("maxPrice",document.getElementById("maxPrice").value);
        
        table.ajax.url('findAmazonItems.php?'+
                            'Title='+document.getElementById("Title").value+
                            '&Category='+document.getElementById("Category").value+
                            '&minPrice='+document.getElementById("minPrice").value+
                            '&maxPrice='+document.getElementById("maxPrice").value+
                            '&sort='+document.getElementById("sort").value+
                            '&Keywords='+document.getElementById("Keywords").value
                ).load(fnLoadAmazonTable,true);
    }
    
    function loadMoreAmazonItems(){       
        table.ajax.url('loadMoreItems.php?'+
                            'Title='+document.getElementById("Title").value+
                            '&Category='+document.getElementById("Category").value+
                            '&minPrice='+document.getElementById("minPrice").value+
                            '&maxPrice='+document.getElementById("maxPrice").value+
                            '&sort='+document.getElementById("sort").value+
                            '&Keywords='+document.getElementById("Keywords").value
                ).load(fnLoadAmazonTable,true);
    }
    
    function fnLoadAmazonTable(){
        table.responsive.recalc();
    }
    
    function setupCoockie(paramName,value){
            //variables for coockies
            var d = new Date(),
                    exdays=30;//how mnay days for coockie
                    d.setTime(d.getTime() + (exdays*24*60*60*1000));
                    var expires = "expires="+d.toUTCString();

            //setup coockie for viewType
                    document.cookie = paramName + "=" + value + "; " + expires;
    }
                        
    function showCustomAlert(msgShow){
        document.getElementById("inline_example").innerHTML=msgShow;
        document.getElementById("error").click();
    }
    
    function linkToEbayID(ASIN){
        window.alert(ASIN);
    }
    
    function ListOnEBay(ASIN,TITLE,IMAGE_URL,BRAND,MANUFACTURER){
        showCustomAlert(
                    //'<div style="margin-bottom:20px;">ASIN='+ASIN+'</div>'+
                    '<div style="margin-bottom:20px;">'+
                        '<form name="ASINImprtFrm">'+
                            //'ASIN : '+
                            //'<input style="color: black;margin-bottom:20px;width:100%;" value="" name="current_ASIN" type="edit">'+
                            //'<div onclick="ASINImprtFrm[1].isAutomateReprice.click();" style="cursor: pointer;">'+
                                //'Is Automate Reprice <input id="isAutomateReprice" name="isAutomateReprice" type="checkbox">'+
                            //'</div>'+
                            //
                            //sku
                            'SKU : '+
                            '<input style="color: black;margin-bottom:20px;width:100%;" value="imt'+ASIN+'E24P" name="current_SKU" type="edit">'+
                            
                            //title
                            'TITLE : '+
                            '<textarea style="margin-bottom:20px;width:100%;" name="current_TITLE">'+TITLE+'</textarea>'+
                            
                            //Brand
                            'Brand : '+
                            '<input style="color: black;margin-bottom:20px;width:100%;" value="'+BRAND+'" name="current_BRAND" type="edit">'+
                            
                            //manufacturer
                            'manufacturer : '+
                            '<input style="color: black;margin-bottom:20px;width:100%;" value="'+MANUFACTURER+'" name="current_MANUFACTURER" type="edit">'+
                            
                            //image
                            '<img src="'+IMAGE_URL+'" name="current_IMG" style="width:300px;height:300px;margin-left:500px;margin-top:-100%;">'+
                        '</form>'+
                       '</div>'+
                    '<div class="button" style="margin-bottom:20px;" onclick="window.alert(\'1\');">List</div>'
                );
    }
    
    function showCustomAlert(msgShow){
        document.getElementById("inline_example").innerHTML=msgShow;
        document.getElementById("notifyWindow").click();
    }
</script>