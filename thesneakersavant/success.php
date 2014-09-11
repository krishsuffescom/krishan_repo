<?php
require_once("init.php");
require_once("config_db.php");

$sql= "INSERT INTO `customers` (`order_key`,`first_name`, `last_name`, `email`, `txn_id`, `mc_gross`, `payment_status`, `pending_reason`,`payment_date`, `time`) VALUES ( '".$_POST[invoice]."','".$_POST[first_name]."', '".$_POST[last_name]."', '".$_POST[payer_email]."','".$_POST[txn_id]."', '".$_POST[mc_gross]."', '".$_POST[payment_status]."', '".$_POST[pending_reason]."', '".$_POST[payment_date]."','".time()."')";


if(mysql_query($sql)){
	echo "<h1>".$_POST[last_name]."  ".$_POST[last_name]."</h1>";
	echo '<h1>Payment Successful</h1>';
	mysql_query("UPDATE order_shoes SET `payment_status` = '".$_POST[payment_status]."' WHERE `shoes_key` = '".$_POST['invoice']."'");
	header('Location: emailSignupForm.php?confirm=1');
}else{
    echo "Payment Error";
	header('Location: emailSignupForm.php?confirm=0');
}
//Array ( [transaction_subject] => cu65ofgfb7r9nup53ru9vu7dq4 [txn_type] => web_accept [payment_date] => 06:09:31 Aug 22, 2014 PDT [last_name] => Sunny [residence_country] => US [pending_reason] => unilateral [item_name] => Name of Item [payment_gross] => 66.00 [mc_currency] => USD [payment_type] => instant [protection_eligibility] => Ineligible [payer_status] => verified [verify_sign] => AFcWxV21C7fd0v3bYYYRCpSSRl31ACkydxtiQlhXt1LYHqmPgVrreK3w [tax] => 0.00 [test_ipn] => 1 [payer_email] => testing.suffescom_user@gmail.com [txn_id] => 26923920WN685333D [quantity] => 1 [receiver_email] => ben@benfarr.com [first_name] => Walia [invoice] => 0019012 [payer_id] => G3FK5W9KS8GHU [item_number] => [handling_amount] => 0.00 [payment_status] => Pending [shipping] => 0.00 [mc_gross] => 66.00 [custom] => cu65ofgfb7r9nup53ru9vu7dq4 [charset] => windows-1252 [notify_version] => 3.8 [merchant_return_link] => click here [auth] => AIsPu2PUKhCh4t0wRGHLF05vVk.S9WuRyJpVq1LY7lLaPnDj0XBu7IYQSWWHOy1mg-RsqE5N69L7MjP8e-P6gCw ) Under process.........
echo "Under process.........";
//print_r($_GET);

/*$uid = $_SESSION['uid'];
$username=$_SESSION['username'];

$item_no = $_GET['item_number'];
$item_transaction = $_GET['tx'];
$item_price = $_GET['amt'];
$item_currency = $_GET['cc'];

//Getting product details
$sql=mysql_query("select product,price,currency from producst where pid='$item_no'");
$row=mysql_fetch_array($sql);
$price=$row['price'];
$currency=$row['currency'];

//Rechecking the product details
if($item_price==$price && item_currency==$currency)
{

$result = mysql_query("INSERT INTO sales(pid, uid, saledate,transactionid) VALUES('$item_no', '$uid', NOW(),'$item_transaction')");
if($result){
  echo "<h1>Welcome, $username</h1>";
    echo '<h1>Payment Successful</h1>';
    echo "<b>Example Query</b>: INSERT INTO sales(pid, uid, saledate) VALUES('<font color='#f00;'>$item_no</font>', '<font color='#f00;'>$uid</font>', <font color='#f00;'>NOW()</font>)";
}else{
    echo "Payment Error";
}
}
else
{
echo "Payment Failed";
}*/
?>
