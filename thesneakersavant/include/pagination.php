<?php



// Do Not Edit Below. //

if($page == '' || !ctype_digit($page)){ $page='1';}

$stcom = ($page - 1) * $perpage;
if($_GET['do'] == "g"){
	$page_active = "do=g";
}

if($_GET['do'] == "mesg"){
	$page_active = "do=mesg";
}

$num_sel=mysql_query($sqlq);

$num=mysql_num_rows($num_sel);

if($stcom >$num){ header("Location: $namep?do=mesg&page=1");}





$z = $num / $perpage;

$pg_n=(int)$z;

	if($pg_n<>$z){

	$pg_n++;

	}

if($pg_n=='0'){$pg_n='1';}



$prev=$page-1;

$nex=$page+1;

if($page=='1'){$ps="<span class='disabled_tnt_pagination'><!--&laquo; Prev--> <img src='images/previouss_inactive.png'/></span>";}

else{$ps="<a href='$namep?$page_active&page=$prev&order=$order&field=$field&search=$search_txt' title='previous'><!--&laquo; Prev--> <img src='images/previouss.png'/></a>";}

if($page==$pg_n){$nx="<span class='disabled_tnt_pagination'><!--Next &raquo;--> <img src='images/nextt_inactive.png'/></span>";}

else{$nx="<a href='$namep?$page_active&page=$nex&order=$order&field=$field&search=$search_txt' title='next'><!--Next &raquo;-->  <img src='images/nextt.png'/></a>";}

$k='1';	$l='0';

while($k<=$pg_n){

	if($k==$page){$pgs[$l]="<span class='active_tnt_link' style='color:#3B5998; font-weight:bold'>$k</span>";}

	else{$pgs[$l]="<a href='$namep?$page_active&page=$k&order=$order&field=$field&search=$search_txt' style='color:#3A3A3A' >$k</a>";}

$k++;	$l++;

}

?>