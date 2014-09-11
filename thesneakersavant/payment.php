<?php
require_once("init.php");
require_once("config_db.php");
$paypal_id='ben@benfarr.com';  // sriniv_1293527277_biz@inbox.com*/
if( $_REQUEST['submitbtn'] == 'Pay now'){
	$uniq =date("His").rand(1234, 9632);
	for($a=0; $a < $_REQUEST['totalRow']; $a++){
	$sql="INSERT INTO order_shoes (`uniq_key`, `brand`, `model`, `product`, `size`, `estVal`, `gold`, `silver`, `time`) VALUES ( '".$uniq."','".$_REQUEST['brand_'.$a]."', '".$_REQUEST['model_'.$a]."','".$_REQUEST['product_'.$a]."', '".$_REQUEST['size_'.$a]."', '".$_REQUEST['estval_'.$a]."','".$_REQUEST['gold_'.$a]."','".$_REQUEST['silver_'.$a]."','". time()."')";
	mysql_query($sql);
	}
	$descr="INSERT INTO description (`uniq_key`,`desription`, `time`) VALUES ( '".$uniq."','".$_REQUEST['descr']."', '". time()."')";
	if(mysql_query($descr)){
		$msg="success";
			$dvar[action]='process';
			$dvar[cmd]='_xclick';
			$dvar[currency_code]='USD';
			$dvar[invoice]=$uniq;
			$dvar[business]=$paypal_id;
			$dvar[cbt]='Return to Your Business Name';
			$dvar[item_name]='Shoes';
			$dvar[no_shipping]=$_REQUEST['totalRow'];
			$dvar[shipping]=$_REQUEST['amount'];
			$dvar[handling]='0';
			$dvar[submit_x]='0';
			$dvar[submit_y]='0';
			$dvar[submit]='submit';
			$_SESSION[formdata]=$dvar;
			header('Location: paypal.php?sandbox=1');
	}else{
		$msg="error";
	}
}

?>
