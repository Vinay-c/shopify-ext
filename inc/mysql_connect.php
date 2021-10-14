<?php

$host = "localhost";
$username = "ventuwy2_shopify_popup_app";
$password ="Brudev123#";

$database = "ventuwy2_shopify_popup_app";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection Error: " . mysqli_connect_error());
}
?>