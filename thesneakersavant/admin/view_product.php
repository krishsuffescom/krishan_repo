<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");

$tabl = 'products';
$item = 'Product';
$page_parent = 'manage_states.php';
$query_string = array("search" => $_GET['search'], "page" => $_GET['page'], "rel_id" => $_GET['rel_id'], "do" => $_GET['do'], "id" => $_GET['id']);
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}

$id = mysql_real_escape_string($_GET['id']);

$sql = "SELECT * from $tabl where id='".$id."'";
$exec = mysql_query($sql) or die(mysql_error());
$fetch = mysql_fetch_assoc($exec);
$dvar['name'] = $fetch['name'];
$dvar['price'] = $fetch['price'];
$dvar['description'] = $fetch['description'];
$dvar['quantity'] = $fetch['quantity'];
$image = $fetch['image'];
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View <?php echo $item; ?></title>
<?php include("include/head.php"); ?>
<script type="text/javascript">
jQuery(document).ready(function () {
	$('input#start_date').simpleDatepicker({ startdate: 2012, enddate: 2099 });
	$('input#end_date').simpleDatepicker({ startdate: 2012, enddate: 2099 });
});
</script>
</head>
<body>
<div align="center">
  <div class="container">
	<?php
    $pg_active['pdt'] = 'active';
    require_once('include/header.php'); 
    ?>
    <div class="content">
      <div class="viewform">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <table width="1150" border="0" cellpadding="5">
      
          <tr>
            <td align="right" class="label_form"><div class="view1">Product Name :</div></td>
         	<td><div class="view2"><?php echo $dvar['name']; ?></div></td>
         </tr>
          <tr>
            <td align="right" class="label_form"><div class="view1">Price :</div></td>
         	<td><div class="view2"><?php echo $dvar['price']; ?></div></td>
         </tr>
         <tr>
         	<td align="right" class="label_form"><div class="view1">Image :</div></td>
            <td><div class="pic"><img src="<?php if($image <> ''){echo '../pics/'.$image;}else{echo 'images/1.png';} ?>" alt="images/1" width="98" height="98" /></div></td>
         </tr>
         <tr>
         	<td align="right" class="label_form"><div class="view1">Description :</div></td>
            <td><div class="view2" style="width:620px;"><?php echo nl2br($dvar['description']); ?></div></td>
         </tr>
         <tr>
         	<td align="right" class="label_form"><div class="view1">Quantity :</div></td>
            <td><div class="view2" style="width:620px;"><?php echo $dvar['quantity']; ?></div></td>
         </tr>
         <tr><td></td>
            <td><a class="a_button" href="<?php echo $page_parent."?1=1".$q_string; ?>">Close</a></td>
         </tr>
     
       </table>
        </form>
      </div>
      <?php
	   include "include/footerlogo.php";
	  ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
