<?php
$lock_page = true;
include_once "rfclass/check_login.php";
include_once "lib_THEsite.php";
require_once 'class.db.php';
require_once 'config.php';
include_once("lib_ebay.php");

$userID=$jakuser->getVar("id");

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
    <a class="button" onclick="synchronizeEbayItems();">Synchronize eBay Items</a>
    <div style="width:100%;">

        <div style="width:300px;float:left;margin-right:50px;">
            From date : 
            <input type="text" name="filterFromDate" id="filterFromDate1" value="">
        </div>
        <div style="width:300px;float:left;margin-right:50px;">
            To date : 
            <input type="text" name="filterToDate" id="filterToDate1" value="">
        </div>
        <div style="width:300px;float:left;margin-top:19px;">
            <select id="FilterBylastTime1" onchange="getSetsOfDates('1');">
            <option>last 7 days</option>
            <option>last 14 days</option>
            <option>last 30 days</option>
            <option>All</option>
            </select>
        </div>
        <div style="margin-left:1px;width:50px;float:left;margin-top:33px;">
            <input type="button" value="X" onclick="cleanDates('1');">
        </div>

        <div style="width: 100px;margin-bottom: 50px;">
            <a class="button" onclick="loadEbayItems();" style="margin-top:50px;">Load Items from DB</a>
            <a class="button" onclick="RemoveAllItemsFromDB();">Remove All Items from DB</a>
        </div>
    </div>
</div>

<table id="example" class="display responsive nowrap" cellspacing="0" width="80%">
    <thead>
            <tr>
                <th>price</th>
                <th>currency</th>
                <th>img</th>
                <th>LinkToAmazon</th>
                <th>title</th>
                <th>sku</th>
                <th>ebayID</th>
                <th>BuyItNowPrice</th>
                <th>ListingStatus</th>
                <th>ListingDuration</th>
                <th>categoryID</th>
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
        
        table = $('#example').DataTable( {
            responsive: true,
            "bProcessing": true,
            "oLanguage": {            
                        "sSearch": "",
                        "sLoadingRecords": "Please wait - loading...",
                        "sProcessing": "<img src='images/preloader.gif'/>"
            },
            "ajax": 'getEbayItemsDataFromDB.php'
        } );
    } );
    
    function cleanDates(addToID){
            document.getElementById("filterFromDate"+addToID).value="";
            document.getElementById("filterToDate"+addToID).value="";
    }

    function getSetsOfDates(addToID){
            var filterOption=document.getElementById("FilterBylastTime"+addToID).options[document.getElementById("FilterBylastTime"+addToID).selectedIndex].value;
            var toDate = new Date(),today = new Date();
            today.setDate(today.getDate() + 2);
            if(filterOption!="All"){
                    if(filterOption=="last 14 days"){
                                    toDate.setDate(toDate.getDate() - 14);
                    }
                    if(filterOption=="last 30 days"){
                                    toDate.setDate(toDate.getDate() - 30);
                    }
                    if(filterOption=="last 60 days"){
                                    toDate.setDate(toDate.getDate() - 60);
                    }
                    
                    var monthNum=(toDate.getMonth()+1);
                    var dayNum=(toDate.getDate()+1);
                    var todayDayNum=(today.getDate()+1);
                    var todayMonthNum=(today.getMonth()+1);
                    if(monthNum<10){
                        monthNum="0"+monthNum;
                    }
                    if(dayNum<10){
                        dayNum="0"+dayNum;
                    }
                    
                    if(todayMonthNum<10){
                        todayMonthNum="0"+todayMonthNum;
                    }
                    if(todayDayNum<10){
                        todayDayNum="0"+todayDayNum;
                    }
                    
                    document.getElementById("filterFromDate"+addToID).value=toDate.getFullYear()+"-"+monthNum+"-"+dayNum;
                    document.getElementById("filterToDate"+addToID).value=today.getFullYear()+"-"+todayMonthNum+"-"+todayDayNum;
            }else{
                    document.getElementById("filterFromDate"+addToID).value="";
                    document.getElementById("filterToDate"+addToID).value="";
            }   
    }

    function synchronizeEbayItems(){
        if(
                (document.getElementById("filterFromDate1").value=="")
                ||
                (document.getElementById("filterToDate1").value=="")){
                    showCustomAlert("enter 'from date' and 'to date' values!");
                }else{
        
                    if (window.XMLHttpRequest)
                      {// code for IE7+, Firefox, Chrome, Opera, Safari
                            xmlhttp=new XMLHttpRequest();
                      }
                    else
                      {// code for IE6, IE5
                            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                      }
                     xmlhttp.onreadystatechange=function(){
                            if(xmlhttp.readyState==4 && xmlhttp.status==200){
                                    ///return response when loaded
                                    var responseStr=xmlhttp.responseText;
                                    var n = responseStr.indexOf("Input data is invalid.");
                                    if(n==-1){
                                        showCustomAlert(responseStr);
                                    }else{
                                        showCustomAlert(
                                                "Please check 'from date' and 'to date' values<br>Must be like this : 2015-09-27<br>make sure there are 0(for example 09)<br>Full Response Text :"
                                                +responseStr);
                                    }
                            }
                     }
                    ///execute script
                    xmlhttp.open("POST","SnchronizeEbayItems.php",true);
                    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    xmlhttp.send(
                                "endDate="+document.getElementById("filterToDate1").value+"T12:00:00Z"+
                                "&startDate="+document.getElementById("filterFromDate1").value+"T12:00:00Z"
                            );
                }
    }
    
    function loadEbayItems(){
       table.ajax.reload(fnLoadEbayTable);
    }
    
    function fnLoadEbayTable(){
        table.responsive.recalc();
    }
    
    function RemoveAllItemsFromDB(){
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
         xmlhttp.onreadystatechange=function(){
                if(xmlhttp.readyState==4 && xmlhttp.status==200){
                        ///return response when loaded
                        var responseStr=xmlhttp.responseText;
                        showCustomAlert(responseStr);
                                    
                }
         }
        ///execute script
        xmlhttp.open("POST","removeAllEbayItemsFromDB.php",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send();
    }
    
    function showCustomAlert(msgShow){
                        document.getElementById("inline_example").innerHTML=msgShow;
                        document.getElementById("notifyWindow").click();
                    }
                    
    function linkToASINWnd(ebayID){
        showCustomAlert(
                    '<div style="margin-bottom:20px;">ebayID='+ebayID+'</div>'+
                    '<div style="margin-bottom:20px;">'+
                        'ASIN : '+
                        '<form name="ASINFrm">'+
                            '<input style="color: black;margin-bottom:20px;" value="" name="current_ASIN" type="edit">'+
                            '<div onclick="ASINFrm[1].isAutomateReprice.click();" style="cursor: pointer;">'+
                                'Is Automate Reprice <input id="isAutomateReprice" name="isAutomateReprice" type="checkbox">'+
                            '</div>'+
                        '</form>'+
                       '</div>'+
                    '<div class="button" style="margin-bottom:20px;" onclick="linkToASIN('+ebayID+',ASINFrm[1].current_ASIN.value,ASINFrm[1].isAutomateReprice.checked);">Apply</div>'
                );
    }
    
    function linkToASIN(ebayID,ASIN,isAutomateReprice){
        window.alert(
                "ebayID="+ebayID+
                " ASIN="+ASIN+
                " isAutomateReprice="+isAutomateReprice);
    }
</script>
