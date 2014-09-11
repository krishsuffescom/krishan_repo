<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");

$tabl = 'config';
$item = 'config';
//$page_parent = 'manage_gold.php';
$query_string = array("search" => $_GET['search'], "page" => $_GET['page'], "rel_id" => $_GET['rel_id'], "do" => $_GET['do'], "id" => $_GET['id']);
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}

$id = mysql_real_escape_string($_GET['id']);
$relation = mysql_real_escape_string($_GET['relation']);

if($_POST['submitbut'] == 'Save'){
	
		
		print_r($_POST);
		
		$dvar['gold'] = $_POST['gold'];
		$dvar['silver'] = $_POST['silver'];
		$dvar['tax'] = $_POST['tax'];

		if($_GET['do'] == 'edit'){
		
		$dvar['gold'] = $_POST['gold'];
		$dvar['silver'] = $_POST['silver'];
		$dvar['tax'] = $_POST['tax'];
			
				
			$sql_s = "select * from $tabl where id='".$id."'";
			$exec_s = mysql_query($sql_s);
			$fetch_s = mysql_fetch_assoc($exec_s);			

			$sql = "UPDATE $tabl SET ".update_query($dvar, $add_dvar, $remove_dvar, $change_dvar)." where id='".$id."'";
			

			$fg = 'ed';
		}
		else{
			$uniq = random_generator(10);
			$add_dvar = array('status' => '1', 'time' => time());
			
			

			list($insert_q[0], $insert_q[1]) = insert_query($dvar, $add_dvar, $remove_dvar, $change_dvar);
			
			echo $sql = "INSERT into $tabl(sort, $insert_q[0]) SELECT max(sort)+1, $insert_q[1] from $tabl";
			
			
			$fg = 'ad';
		}
		if(mysql_query($sql)){
			
			$flag[$fg] = $item;
		}
		else{
			$flag['q'] = 'r';
		}

}


if($_GET['do'] == 'edit'){
	$sql = "SELECT * from $tabl where id='".$id."'";
	$exec = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_assoc($exec);
	$dvar['gold'] = $fetch['gold'];
	$dvar['silver'] = $fetch['silver'];
	$dvar['tax'] = $fetch['tax'];
}


if($_GET['do'] == 'edit' && ($flag[$fg] <> '')){
	$sql = "SELECT * from $tabl where id='$id'";
	$exec = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_assoc($exec);
	$dvar['gold'] = $fetch['gold'];
	$dvar['silver'] = $fetch['silver'];
	$dvar['tax'] = $fetch['tax'];
}
	$sql = "SELECT * from $tabl";
	$exec = mysql_query($sql) or die(mysql_error());
	$fetch = mysql_fetch_assoc($exec);
	$dvar['gold'] = $fetch['gold'];
	$dvar['silver'] = $fetch['silver'];
	$dvar['tax'] = $fetch['tax'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add/Edit <?php echo $item; ?></title>
<?php include("include/head.php"); ?>
<script type="text/javascript">
	var i;
	$(document).ready(function(){
		$('#tb_clone_click').click(function(){
			$("#table-data tr:first").clone().find("input").each(function() {
				$(this).val('').attr('id', function(_, id) { return id + i });
			}).end().appendTo("#table-data");
		var rowCount = document.getElementById('table-data').rows.length; 
		});
	});
	
</script>
<?php
if($flag[$fg] <> ''){
?>
<!--<meta http-equiv="refresh" content="3; URL=<?php echo $page_parent."?1=1".$q_string; ?>">-->
<?php } ?>
</head>

<body>
<div align="center">
  <div class="container">
	<?php
    $pg_active['pdt'] = 'active';
    require_once('include/header.php'); 
    ?>
    <div class="content">
      <div style="margin-top:10px">
      <?php
        echo print_messages($flag, $error_message, $success_message);
		?>
      </div>
      <div class="form5">
        <form id="add" name="add" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?1=1<?php echo $q_string; ?>" enctype="multipart/form-data">
            <table width="1150" border="0" cellpadding="5">
               <tr>                
                  <td align="right" class="label_form">Gold : </td>
                  <td><input type="text" name="value" class="input_text" value="<?php echo $dvar['gold']; ?>"  /> 
				  <br class="clear" /></td>
              </tr>
			    <tr>                
                  <td align="right" class="label_form">Silver : </td>
                  <td><input type="text" name="value" class="input_text" value="<?php echo $dvar['silver']; ?>"  /> 
				  <br class="clear" /></td>
              </tr>
                <tr>                
                  <td align="right" class="label_form">Tax : </td>
                  <td><input type="text" name="value" class="input_text" value="<?php echo $dvar['tax']; ?>"  /> 
				  <br class="clear" /></td>
              </tr>
             
           <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="btn">
                        <input class="button" name="submitbut" value="Save" type="submit" />
                        <a class="a_button" href="<?php echo $page_parent."?1=1".$q_string; ?>">Cancel</a>
                    </div>
                </td>
              </tr>
            </table>
        </form>
      </div>
      <?php
	  	 include "include/footerlogo.php";
	  ?>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
