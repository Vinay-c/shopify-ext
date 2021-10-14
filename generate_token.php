<?php

// Get our helper functions
require_once("inc/functions.php");
require_once("inc/mysql_connect.php");

// Set variables for our request
$api_key = "9ebd12de6540c2dc7709de7c35107241";
$shared_secret = "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";
$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically

$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {

	// Set variables for our request
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);

	// Generate access token URL
	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

	// Configure curl client and execute request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
	$result = curl_exec($ch);
	curl_close($ch);

	// Store the access token
	$result = json_decode($result, true);
	$access_token = $result['access_token'];

	// Show the access token (don't do this in production!)
	//echo $access_token;
	$sql = "INSERT INTO shops(shop_url, access_token, install_date) VALUES('" . $params['shop'] . "','". $access_token . "',NOW())";
	
	//echo $sql;
	if(mysqli_query($conn,$sql)){
	    $scriptTags = shopify_call($access_token, $params['shop'], "/admin/api/2020-07/script_tags.json", 'GET');
		$scriptTags = json_decode($scriptTags['response'], JSON_PRETTY_PRINT);
		if(count($scriptTags) > 0){
		    if( isset( $scriptTags['script_tags'] ) && count( $scriptTags['script_tags'] ) > 0 ){
		       if(strpos($script['src'], "search.js") !== false){
		        	
	    		} 
		        
		    }else{
		        $array = array(
						'script_tag' => array(
							'event' => 'onload', 
							'src' => 'https://ventureby.com/shopify_popup_app/script/script.js',
							'display_scope' => 'all'
						)
					);
					
					$scriptTag = shopify_call($access_token, $params['shop'], "/admin/api/2019-07/script_tags.json", $array, 'POST');
			    	$scriptTag = json_decode($scriptTag['response'], JSON_PRETTY_PRINT);
			    //	echo '<pre>'; print_r($scriptTag); echo '</pre>';
		    }
		}
	    header("Location: https://". $params['shop']. "/admin/apps/shopify_popup_app");
	    
	    
	    exit();
	    
	}else{
	    echo "Error for inserting access token.";
	}

} else {
	// Someone is trying to be shady!
	die('This request is NOT from Shopify!');
}