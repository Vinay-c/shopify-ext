<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = "9ebd12de6540c2dc7709de7c35107241";
$scopes = "read_orders,read_script_tags, write_script_tags, read_products, read_content, write_content";
$redirect_uri = "https://ventureby.com/shopify_popup_app/generate_token.php";


// Build install/approval URL to redirect to
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();