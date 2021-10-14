<?php

include_once("inc/mysql_connect.php");

$shopify = $_GET;
// echo 'ok';
//echo print_r($shopify);

$sql = "SELECT * FROM  shops WHERE shop_url= '".$shopify['shop'] . "' LIMIT 1";
$check = mysqli_query($conn,$sql);

if(mysqli_num_rows($check) < 1){
    
   header("Location: https://ventureby.com/shopify_popup_app/install.php?shop=".$_GET['shop'] );
   exit();
}

// header("Location: install.php?shop=".$shopify['shop']);
// header("Location: https://ventureby.com/shopify_popup_app/install.php?shop=".$_GET['shop'] );

?>