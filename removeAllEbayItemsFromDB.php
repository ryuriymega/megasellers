<?php
    $lock_page = true;
    include_once "rfclass/check_login.php";
    include_once "lib_THEsite.php";
    $userID=$jakuser->getVar("id");
    header("Content-type: text/json");
    
    removeAllEbayItemsFromDB($userID);
    echo "All items removed from your table in a DataBase. You can load your data from ebay by pressing a button -> 'Synchronize Ebay Items'";
?>