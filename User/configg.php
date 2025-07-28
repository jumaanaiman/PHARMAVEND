

<?php
require_once '../Config/config.php';
?>

<?php

// Product Details 
$itemNumber = "DP12345";
$itemName = "Demo Product";
$itemPrice = 75;
$currency = "USD";

/* PayPal REST API configuration 
 * You can generate API credentials from the PayPal developer panel. 
 * See your keys here: https://developer.paypal.com/dashboard/ 
 */
define('PAYPAL_SANDBOX', TRUE); //TRUE=Sandbox | FALSE=Production 
define('PAYPAL_SANDBOX_CLIENT_ID', 'AQeom892Q9pxedrWBL7vQS97iZmbamFcKaGYMZsYDd64uVi82m4PMOaeuiDMVJpmKME0DnmRhV5SyMBQ');
define('PAYPAL_SANDBOX_CLIENT_SECRET', 'Insert_PayPal_Secret_Key_For_Sandbox_Here');
define('PAYPAL_PROD_CLIENT_ID', 'Insert_Live_PayPal_Client_ID_Here');
define('PAYPAL_PROD_CLIENT_SECRET', 'Insert_Live_PayPal_Secret_Key_Here');
