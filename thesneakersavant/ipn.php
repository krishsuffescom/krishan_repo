<?php
require_once("init.php");
require_once("config_db.php");

		$trasaction_id  = $_POST["txn_id"];
		$payment_status = strtolower($_POST["payment_status"]);
		$invoice		= $_POST["invoice"];
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
		if ($p->validate_ipn()){ // validate the IPN, do the others stuffs here as per your app logic
			mysql_query("UPDATE `customers` SET `trasaction_id` = '$trasaction_id ', `log_id` = '$paypal_log_id', `payment_status` = '$payment_status' WHERE `invoice` = '$invoice'");
			$subject = 'Instant Payment Notification - Recieved Payment';
			$p->send_report($subject); // Send the notification about the transaction
			header('Location: emailSignupForm.php?confirm=1');
			exit;
			
		}else{
			$subject = 'Instant Payment Notification - Payment Fail';
			$p->send_report($subject); // failed notification
				header('Location: emailSignupForm.php?confirm=0');
			exit;
		}

?>