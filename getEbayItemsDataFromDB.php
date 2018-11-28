<?php
    $lock_page = true;
    include_once "rfclass/check_login.php";
    include_once "lib_THEsite.php";
    $userID=$jakuser->getVar("id");
    header("Content-type: text/json");
    
    echo getTableEbayItemsData($userID);
?>