<?php
require_once("init.php");
require_once("config_db.php");
require_once("include/paypal_class.php");



$p 				= new paypal_class(); // paypal class
$p->admin_mail 	= EMAIL_ADD; // set notification email
if(isset($_SESSION[formdata])){
$action 		= $_SESSION[formdata]["action"];
}else if(isset($_POST)){
	
 $action 		= 'success';
}
if($_GET['action']=='cancel'){
	
	$action 		= 'cancel';
}
switch($action){
	case "process": // case process insert the form data in DB and process to the paypal
	mysql_query("INSERT INTO `customers` (`invoice`,`quantity`,`amount`,`payment_status`,`posted_date`,`time`) VALUES ( '".$_SESSION[formdata][invoice]."','".$_SESSION[formdata][no_shipping]."','".$_SESSION[formdata][shipping]."','pending', NOW() ,'".time()."')");

		$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$p->add_field('business', PAYPAL_EMAIL_ADD); // Call the facilitator eaccount
		$p->add_field('cmd', '_xclick'); // cmd should be _cart for cart checkout
		$p->add_field('upload', '1');
		$p->add_field('return', WEB_URL.'?action=success'); // return URL after the transaction got over
		$p->add_field('cancel_return', WEB_URL.'?action=cancel'); // cancel URL if the trasaction was cancelled during half of the transaction
		$p->add_field('notify_url', WEB_URL.'?action=ipn'); // Notify URL which received IPN (Instant Payment Notification)
		//$p->add_field('notify_url', $this_script."/ipn.php?cart=".$_POST["invoice"]);
		$p->add_field('currency_code', $_SESSION[formdata]["currency_code"]);
		$p->add_field('invoice', $_SESSION[formdata]["invoice"]);
		/*$p->add_field('item_name_1', $_POST["product_name"]);
		$p->add_field('item_number_1', $_POST["product_id"]);*/
		$p->add_field('quantity_1', $_SESSION[formdata]["no_shipping"]);
		/*$p->add_field('amount_1', $_POST["product_amount"]);
		$p->add_field('first_name', $_POST["first_name"]);
		$p->add_field('last_name', $_POST["last_name"]);
		$p->add_field('address1', $_POST["payer_address"]);
		$p->add_field('city', $_POST["city"]);
		$p->add_field('state', $_POST["payer_state"]);
		$p->add_field('country', $_POST["payer_country"]);
		$p->add_field('zip', $_POST["payer_zip"]);*/
		$p->add_field('email', $_SESSION[formdata]["email"]);
		$p->add_field('item_name', ' Order');
		$p->add_field('amount', $_SESSION[formdata]['shipping']);
		$p->submit_paypal_post(); // POST it to paypal
		unset($_SESSION[formdata]);
		$p->dump_fields(); // Show the posted values for a reference, comment this line before app goes live
	break;
	
	case "success": // success case to show the user payment got success
		$trasaction_id  = $_POST["txn_id"];
		$payment_status = strtolower($_POST["payment_status"]);
		$invoice		= $_POST["invoice"];
		$pending_reason = $_POST["pending_reason"];
		$payment_type   = $_POST["payment_type"];
		$log_array		= print_r($_POST, TRUE);
		$log_query		= "SELECT * FROM `paypal_log` WHERE `txn_id` = '$trasaction_id'";
		$log_check 		= mysql_query($log_query);
				if(mysql_num_rows($log_check) <= 0){
					mysql_query("INSERT INTO `paypal_log` (`txn_id`, `log`, `posted_date`) VALUES ('$trasaction_id', '$log_array', NOW())");
				}else{
					mysql_query("UPDATE `paypal_log` SET `log` = '$log_array' WHERE `txn_id` = '$trasaction_id'");
				} // Save and update the logs array
			$paypal_log_fetch 	= mysql_fetch_array(mysql_query($log_query));
			$paypal_log_id		= $paypal_log_fetch["id"];
		if($_POST["payer_status"]=='verified'){

			mysql_query("UPDATE `customers` SET fname ='$_POST[last_name]', lname ='$_POST[first_name]', email ='$_POST[payer_email]',  city ='$_POST[address_city]', state='$_POST[address_state]', country='$_POST[address_country]', zip='$_POST[address_zip]', `transaction_id` = '$trasaction_id ', `log_id` = '$paypal_log_id', `payment_status` = '$payment_status',`pending_reason`='$pending_reason',`payment_type`='$payment_type' WHERE `invoice` = '$invoice'");
			mysql_query("UPDATE `description` SET `archived` = '0',`status` = '1' WHERE  `uniq_key` = '$invoice'");
			$subject = 'Instant Payment Notification - Recieved Payment';
			$p->send_report($subject); // Send the notification about the transaction
			header("Location: http://thesneakersavant.com/emailSignupForm.php?confirm=1");
			exit;
			
		}else{
			$subject = 'Instant Payment Notification - Payment Fail';
			$p->send_report($subject); // failed notification
			header("Location: http://thesneakersavant.com/emailSignupForm.php?confirm=0");
			exit;
		}
	break;
	
	case "cancel": // case cancel to show user the transaction was cancelled
		header("Location: http://thesneakersavant.com/emailSignupForm.php");
		exit;
	break;
	
}
?>