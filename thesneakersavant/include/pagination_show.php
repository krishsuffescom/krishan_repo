<div id="tnt_pagination" style="float:right; margin-top:5px">
  <div align="center">
    <?php 
	if($l > '1'){
	 echo $ps.' ';	$m='0';
	
	 while($m < $l){echo $pgs[$m].' ';	$m++;}
	
	 echo $nx.' ';
	}
	?>
  </div>
</div>
