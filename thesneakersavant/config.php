<?php
if(isset($_COOKIE['rem'])){
	$uniqc = mysql_real_escape_string($_COOKIE['rem']);
	$sql = "SELECT count(*) from signup where uniq='".$uniqc."'";
	$exec = mysql_query($sql);
	list($numc) = mysql_fetch_row($exec);
	
	if($numc == '1'){
		$_SESSION['user'] = $uniqc;
	}
}
?>