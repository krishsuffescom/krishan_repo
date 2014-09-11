<?php
include "../init.php";                       // include init for root url, sitename etc
include "../config_db.php";                  // database connection details stored here
include "include/protecteed.php";            // page protect function here

//_1] => qd [description_2] => qdqd [description_3] => qdqd [description_4] => qdqdq [submitbut] => Save )
$time = time();							     // for current time 
$tabl = 'config';						     // for database table name that used on this page
$item = 'config';
$page_parent = 'add_config.php';           // for redirection 
$query_string = array("search" => $_GET['search'],"type" =>"1", "page" => $_GET['page'], "rel_id" => $_GET['rel_id'], "do" => $_GET['do'], "id" => $_GET['id']);
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}

if($_POST['submitbut'] == 'Save'){	
			$dvar['gold'] = $_POST['gold'];
			$dvar['silver'] = $_POST['silver'];
			$dvar['tax'] = $_POST['tax'];

			$sql_s = "select * from $tabl where id='".$id."'"; //for 
			$exec_s = mysql_query($sql_s);
			$fetch_s = mysql_fetch_assoc($exec_s);
			$add_dvar = array('time' => time());
			//$remove_dvar = array('image_delete');
			$sql = "UPDATE $tabl SET ".update_query($dvar, $add_dvar, $remove_dvar, $change_dvar)."";
			$fg = 'ed';
		
		if(mysql_query($sql)){
			$flag[$fg] = $item;
		}
		
}
//for show data after submit form
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
 <title>Add/Edit<?php echo $item; ?></title>
 <?php include("include/head.php"); ?>
 <script>
  var myCalendar;
  function doOnLoad() {
   myCalendar = new dhtmlXCalendarObject(["date_of_birth"]);
  }
 </script>
 <?php
// after addition/updation redirection
if($flag[$fg] <> ''){
?>
 <meta http-equiv="refresh" content="3; URL=<?php echo $page_parent."?1=1".$q_string; ?>">
 <?php } ?>
 </head>

 <body>
<div align="center">
   <div class="container">
    <?php  $pg_active['con'] = 'active'; 
   			require_once('include/header.php'); ?>
    <div class="content">
       <div style="margin-top:10px"> <?php echo print_messages($flag, $error_message, $success_message); ?> </div>
       <div class="form5">
       <!--For Form fields-->
       <form id="add" name="add" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?do=<?php echo $_GET['do'].'&uniq='.$uniq.'&id='.$_GET['id']; ?>" enctype="multipart/form-data">
        <table width="100%" border="0" cellpadding="5">
            <tr>                
              <td align="right" class="label_form">Gold : </td>
                  <td><input type="text" name="gold" class="input_text" value="<?php echo $dvar['gold']; ?>"  /> 
				  <br class="clear" /></td>
              </tr>
			    <tr>                
                  <td align="right" class="label_form">Silver : </td>
                  <td><input type="text" name="silver" class="input_text" value="<?php echo $dvar['silver']; ?>"  /> 
				  <br class="clear" /></td>
              </tr>
                <tr>                
                  <td align="right" class="label_form">Tax : </td>
                  <td><input type="text" name="tax" class="input_text" value="<?php echo $dvar['tax']; ?>"  /> 
				  <br class="clear" /></td>
              </tr>
           <tr>
            <td>&nbsp;</td>
            <td><div class="btn">
                <input class="button" name="submitbut" value="Save" type="submit" />
                <a class="a_button" href="<?php echo $page_parent."?1=1".$q_string; ?>">Cancel</a> </div></td>
          </tr>
         </table>
      </form>
     </div>
    <?php  include "include/footerlogo.php"; ?>
      </div>
   <div class="clear"></div>
 </div>
</div>
</body>
</html>
