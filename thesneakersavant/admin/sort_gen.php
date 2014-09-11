<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");

$id = mysql_real_escape_string($_GET['rel']);
$rel_id = mysql_real_escape_string($_GET['rel_id']);
$tabl = mysql_real_escape_string($_GET['tab']);
$type = mysql_real_escape_string($_GET['type']);
$categ = mysql_real_escape_string($_GET['categ']); 

if($categ == 1){
	$sql = "SELECT * from $tabl order by sort ASC"; 
}
else if($categ == 2){
		$sql = "SELECT * from $tabl order by sort ASC";
}
else if($rel_id != ''){
		$sql = "SELECT * from $tabl where relation='$rel_id' order by sort ASC";
}
else{
	$sql = "SELECT * from $tabl $preview_sql order by sort ASC";
}
$exec = mysql_query($sql) or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Sort</title>
<script type="text/javascript" src="scripts/jquery-ui-personalized-1.6rc4.min.js"></script>
<script type="text/javascript">
// When the document is ready set up our sortable with it's inherant function(s)
$(document).ready(function() {
	$("#test-list").sortable();
});
function save(){
	var form = $('#sort_form');
	var order = $('#test-list').sortable('serialize');
	$.ajax({
		type: "GET",
		data: form.serialize(),
		url: "ajax.php?do=sort_single&tab=<?php echo $tabl; ?>&"+order,
		success: function(rep){
		var response_array = rep.split(':');
		if(response_array[0] == 'Success'){
			$("#info").html(rep);
			setTimeout('tb_remove();', 2000);
			setTimeout('reload_win("sort")', 2200);
		}
		else{
			$('#info').html(rep);					
		}
		}
	});
}
$('form').submit(function(){
	save();
	return false;
});
</script>
</head>
<body>
<pre>
<div id="info">Click save after Sorting.</div>
</pre>
<ul id="test-list">
<?php
$i = 1;
while($fetch1 = mysql_fetch_assoc($exec)){
	echo '<li id="listItem_'.$fetch1['id'].'" style="padding:2px;"><img src="images/arrow.png" alt="move" width="16" height="16" class="handle" /> '.$fetch1[$type].'</a></li>';
	$i++;
}
?>
</ul>
<br />
<br />
<form id="sort_form" name="sort" method="post" action="">
  <input name="submitbut" value="Save" type="submit" />
  <input name="cancel" value="Cancel" onclick="tb_remove();" type="button" />
</form>
</body>
</html>