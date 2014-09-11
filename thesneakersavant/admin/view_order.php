<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");

$tabl = 'order_shoes';
$item = 'Order';
$page_parent = 'manage_order.php';
$query_string = array("search" => $_GET['search'], "page" => $_GET['page'], "rel_id" => $_GET['rel_id'], "do" => $_GET['do'], "id" => $_GET['id']);
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}

$id = mysql_real_escape_string($_GET['id']);

$sql = "SELECT * from $tabl where uniq_key='".$id."'";
$exec = mysql_query($sql) or die(mysql_error());
//$fetch = mysql_fetch_assoc($exec);
/*$dvar['brand'] = $fetch['brand'];
$dvar['model'] = $fetch['model'];
$dvar['product'] = $fetch['product'];
$dvar['size'] = $fetch['size'];
$dvar['estVal'] = $fetch['estVal'];
$dvar['descr'] = $fetch['descr'];*/
/*$image = $fetch['image'];*/
 
$brand=shoes_brand();
$model=shoes_models();
$product=product();
$size=shoes_size();
$brandjs=shoes_brand();
$modeljs=shoes_models();
$productjs=product();
$sizejs=shoes_size();
$config=config();

 $con="SELECT * FROM `config`";
 $cexce=mysql_query($con);
 $config=mysql_fetch_assoc($cexce);

//SELECT * FROM `config`
 $key="SELECT * FROM `description` where uniq_key='".$_GET['id']."'";
 $kexce=mysql_query($key);
 $dec=mysql_fetch_assoc($kexce);
 $silver="SELECT * FROM `order_shoes` where uniq_key='".$_GET['id']."' and silver!='0'";
 $sexce=mysql_query($silver);
	$num1=mysql_num_rows($sexce);
	$amsilver=$num1*$config['silver'];
	$gold="SELECT * FROM `order_shoes` where uniq_key='".$_GET['id']."' and gold!='0'";
	$gexce=mysql_query($gold);
	$num2=mysql_num_rows($gexce);
	$amgold=$num2*$config['gold'];
	

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
         <table width="100%" cellspacing="0" cellpadding="0"  class="maintbl" >
            <tr class="fstrow"  >
              <td width="5%"><!--<input class="check" type="checkbox" id="mainchbx" name="chk" />--></td>
              <td align="left" width="20%">Brand</td>
              <td align="left" width="10%">model</td>
              <td align="left" width="10%"> product </td>
              <td align="left" width="10%"> size </td>
              <td align="left" width="10%"> Est val </td>
              <td align="left" width="20%"> Gold </td>
              <td align="left" width="10%"> Silver </td>
            </tr>
            <?php
                $exec = mysql_query($sql) or die(mysql_error());
				if(mysql_num_rows($exec) == 0){echo '<tr><td colspan="5" align="center"><div style="margin-top:10px;">No Result Found</div></td></tr>';}
                $z = 0;
                while($fetch = mysql_fetch_assoc($exec)){
            ?>
            <tr class="scndrow <?php echo $z%2 ? '' : 'alternate';?>">
              <td><!--<input type='checkbox' name='chk[]' value='<?php echo $fetch[id] ?>' id='checkme<?php echo $z; ?>' />--></td >
              <td align="left"><div class="n_1"><?php
			  $sql="SELECT name FROM `shoes_brand` where id='".$fetch['brand']."'";
			  $exce=mysql_query( $sql);
			  $data=mysql_fetch_assoc($exce);
			  echo $data['name'];
			   ?></div></td>
               <td align="left"><div class="n_1"><?php  $sql="SELECT name FROM `shoes_models` where id='".$fetch['model']."'";
			  $exce=mysql_query( $sql);
			  $data=mysql_fetch_assoc($exce);
			  echo $data['name'];
			   ?></div></td>
                  <td align="left"><div class="n_1"><?php 
				    $sql="SELECT name FROM `product` where id='".$fetch['product']."'";
			  $exce=mysql_query( $sql);
			  $data=mysql_fetch_assoc($exce);
			  echo $data['name'];
				  
				  ?></div></td>
                     <td align="left"><div class="n_1"><?php 
					  $sql="SELECT name FROM `shoes_size` where id='".$fetch['size']."'";
			  $exce=mysql_query( $sql);
			  $data=mysql_fetch_assoc($exce);
			  echo $data['name'];
					 
					 
					 ?></div></td>
                <td align="left"><div class="n_1"><?php echo $fetch['estVal']; ?></div></td>
                <td align="left"><div class="n_1"><?php echo $fetch['gold']; ?></div></td>
                <td align="left"><div class="n_1"><?php echo $fetch['silver']; ?></div></td>
              
             
            </tr>
            <?php $z++; } ?>
          </table>
          <textarea name="description" id="description" style="float: left; margin: 14px;" cols="45" rows="7"><?php echo $dec['desription']; ?></textarea>
          
          <?php 
		  
		  $rate="SELECT * FROM `customers` where order_key='".$_GET['id']."'";
		  $rexce=mysql_query($rate);
		  $cutomer=mysql_fetch_assoc($rexce);
		  
		  
		  ?>
          <table width="350" border="1" cellspacing="10" cellpadding="5">
  <tbody>
    <tr>
      <td><?php echo $num1; echo " ";?>pairs Silver Service</td>
      <td><?php echo "$"; echo $amsilver;?></td>
    </tr>
    <tr>
      <td><?php echo $num2; echo " ";?>pairs Gold Service</td>
      <td><?php echo "$"; echo $amgold;?></td>
    </tr>
    <tr>
      <td>Tax</td>
      <td><?php 
	  $total=$amsilver+$amgold;
	  
	  echo "$"; echo $tax=$total*($config['tax']/100);?></td>
    </tr>
    <tr>
      <td>Pair Total</td>
      <td><?php echo "$"; echo $total=$amsilver+$amgold+$tax;?></td>
    </tr>
  </tbody>
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
