<?php

error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR);
$servername='localhost';

if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '192.168.1.250'){
	$dbusername='root';
	$dbpassword='sunny007';
	$dbname='veenomous';
}
else if($_SERVER['SERVER_NAME'] == 'demo.suffescom.com' || $_SERVER['SERVER_NAME'] == 'www.suffescom.com' || $_SERVER['SERVER_NAME'] == '107.6.138.108'){
	$dbusername='suffesd_vnmousho';
	$dbpassword='veenomous!@#$';
	$dbname='suffesd_veenomous';
	}
else if($_SERVER['SERVER_NAME'] == 'thesneakersavant.com' || $_SERVER['SERVER_NAME'] == 'www.thesneakersavant.com'){
	$dbusername='mapmarki_veenomo';
	$dbpassword='veenomous!@#$';
	$dbname='mapmarki_vnmousho';
} else{
	$servername="site87.db.9483213.hostedresource.com";
	$dbusername='site87';
	$dbpassword='Wali@007';
	$dbname='site87';

	if (substr($_SERVER['HTTP_HOST'], 0, 4) <> 'www.') {
		header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://www.' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		exit;
	}
}

//Include common files
require_once(ROOT_DIR."/include/common.php"); // page protect function here
require_once(ROOT_DIR."/include/message.php"); // page protect function here


connecttodb($servername,$dbname,$dbusername,$dbpassword);
?>