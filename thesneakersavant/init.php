<?php
/************ CMS v3.1 *************/
/*
-There are few changes in how sessions in admin panel work. Now you need to specify session name in init for admin panel.
-check_login file name changed
*/

session_start();

define('ROOT_DIR', dirname(__FILE__));
define('ADMIN_SESSION', 'admin_session');
define('USER_SESSION', 'user_session');
define('ROOT_URL', 'http://thesneakersavant.com/admin/'); 
define('WEB_URL', 'http://thesneakersavant.com/paypal.php'); 

$site_name = 'Veenomous'; 
$email_def = 'testing.slinfy@gmail.com';
$email_merchant = 'waliaw_1309867236_biz@gmail.com';

//$sandbox_env = '1'; // Sandbox environment
define('EMAIL_ADD', 'testing.suffescom@gmail.com'); // define any notification email
define('PAYPAL_EMAIL_ADD', 'ben@benfarr.com'); // facilitator email which will receive payments change this email to a live paypal account id when the site goes live

// Inventory settings
//$inventory = 0;

/*define('YOUR_APP_ID', '418106331553845');
define('YOUR_APP_SECRET', '97316b2ca8349dd8cefb6680eb83f491');
*/
?>