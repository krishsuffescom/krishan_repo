<?php
require_once("../init.php");
require_once("../config_db.php");
require_once("include/protecteed.php");

$tabl = 'customers';
// Config. for pagination //
$page = $_GET['page'];				// get variable for page
$search_txt = $_GET['search'];
$perpage = '10';						// Show per page
$base_tabl = $tabl;				// table name for query
$item = 'Gold';				// table name for query
$page_child = 'add_edit_gold.php';				// table name for query
$namep = $_SERVER['PHP_SELF'];	
			// Page name
$query_string = array("search" => "$search_txt");
foreach($query_string as $k=>$v){
	$q_string .= "&$k=$v";
}
$q_string_pg = $q_string."&page=$page";		// value inside pages
$stcom = stcom($page, $perpage);

// Select Query part for every query related to this page
$select = "$base_tabl.* ";
$from = "  $base_tabl where 1=1 ";

if($_GET['search'] == '' || $_GET['search'] == 'search'){
	// Make query to select records
	$sql1 = "SELECT $select from $from";		// SQL query to select rows.
}
else{
	$search_txt_db = mysql_real_escape_string($search_txt);
	$sql1 = "SELECT $select from $from AND $base_tabl.value like '%$search_txt_db%'"; 
}

// If multiple rows selected and form submitted
if($_POST['Delete'] == 'Delete Selected'){
	@$chk = $_POST['chk'];
	$i='0';
	if( is_array($chk)){
		while (list ($key, $val) = each ($chk)) {
			if($val <> ''){
				$chk_arr[$i] = $val;
			}
			$i++;
		}
	}
	$arr_num = count($chk_arr);
	if($arr_num > 0){
		$sql_s = "SELECT image from $base_tabl where id in (";
		$sql = "DELETE from $base_tabl where id in (";
		$j = 0;
		while($j<$arr_num){
			if($j<>0){$sql_sub = $sql_sub.",";}
			$sql_sub = $sql_sub."$chk_arr[$j]";
			$j++;
		}
		$sql = $sql.$sql_sub.')';
		$sql_s = $sql_s.$sql_sub.')';
		//delete images/files
		$exec_s = mysql_query($sql_s);
		while($fetch_s = mysql_fetch_assoc($exec_s)){
			@unlink('../pics/'.$fetch_s[image]);
			@unlink('../thumb/'.$fetch_s[image]);
		}
		if(mysql_query($sql)){$flag['d'] = $item;}
		else{$flag['q'] = 'r';}
	}
	else{$flag['z'] = $item;}
}

//If Delete button is pressed for one row
if($_GET['do'] == 'delete' && ctype_digit($_GET['id'])){
	$id = $_GET['id'];
	$sql = "SELECT image from $base_tabl where id='$id'";
	$exec = mysql_query($sql);
	
	list($image) = mysql_fetch_row($exec);
	
	@unlink('../pics/'.$image);
	@unlink('../thumb/'.$image);
	
	$sql = "DELETE from $base_tabl where id='$id'"; 
	if(mysql_query($sql)){
		$flag['d'] = $item;
	}
	else{
		$flag['q'] = 'r';
	}
}


if($_GET['do'] == 'enable'){
	$id = $_GET['id'];
	$sql = "UPDATE $tabl SET status='1' where id = '$id' ";
	mysql_query($sql) or die(mysql_error());
}

if($_GET['do'] == 'disable'){
	$id = $_GET['id'];
	$sql = "UPDATE $tabl SET status='0' where id = '$id'";
	mysql_query($sql) or die(mysql_error());
}

$sqlq = $sql1;
$sql2 = $sql1." ORDER BY id ASC LIMIT $stcom , $perpage";
// pagination file include
include "include/pagination.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage<?php echo $item; ?></title>
<?php include("include/head.php"); ?>
<script type="text/javascript">
	function del_fun(){
		if(confirm("Are you sure you want to delete this <?php echo $item; ?>?")){return true;}
		else{return false;}
	}

	function dis_fun(){
		if(confirm("Are you sure you want to Disable this <?php echo $item; ?>?")){return true;}
		else{return false;}
	}

	function enb_fun(){
		if(confirm("Are you sure you want to Enable this <?php echo $item; ?>?")){return true;}
		else{return false;}
	}
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
    <!-- error and success msg start here -->
      <div style="margin-top: 20px;"> <?php echo print_messages($flag, $error_message, $success_message); ?> </div>
      <!-- error and success msg end here -->
      <div class="down_category" style="margin-top:30px">
        <div class="head"> <span class="head_text"><?php echo $item; ?></span>
          <!--<div class="add"> <a href="<?php echo $page_child; ?>"> <span class="add1"> <span class="head_text1" style="font-size:14px;"> <?php echo $item; ?></span> </span> </a></div>-->
          <div class="resetallpage"><a href="<?php echo $namep; ?>">Reset</a></div>
          <div class="search">
          <!-- searching start from here -->
           <!-- <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <?php foreach($query_string as $k=> $v){?>
              <input name="<?php echo $k; ?>" value="<?php echo $v; ?>" type="hidden" />
              <?php }	?>
              <input type="text" name="search" value="<?php if($search_txt ==''){$search_txt = 'search';}  echo $search_txt; ?>" onfocus="if(this.value=='search'){this.value=''}" onblur="if(this.value==''){this.value='search'}"/>
              <input type="submit" value="Search" name="Submitbut" class="side_search"  />
            </form>-->
          </div>
        </div>
        <br/>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?1=1<?php echo $q_string_pg; ?>" method="post" name="<?php echo $item; ?>">
          <input name="done" type="hidden" value="send" />
          <table width="100%" cellspacing="0" cellpadding="0"  class="maintbl" >
            <tr class="fstrow"  >
              <td width="5%"><input class="check" type="checkbox" id="mainchbx" name="chk" /></td>
            <td align="left" width="10%">Name</td>
            <td align="left" width="15%">email</td>
            <td align="left" width="20%">Txn</td>
            <td align="left" width="10%">payment</td>
            <td align="left" width="15%">status</td>
              <!--<td align="center" width="10%"> Position </td>-->
              <td align="center" width="10%"> Displayed </td>
              <td align="center" width="30%"> Actions </td>
            </tr>
            <?php
                $exec = mysql_query($sql2) or die(mysql_error());
				if(mysql_num_rows($exec) == 0){echo '<tr><td colspan="5" align="center"><div style="margin-top:10px;">No Result Found</div></td></tr>';}
                $z = 0;
                while($fetch = mysql_fetch_assoc($exec)){
            ?>
            <tr class="scndrow <?php echo $z%2 ? '' : 'alternate';?>">
              <td><input type='checkbox' name='chk[]' value='<?php echo $fetch[id] ?>' id='checkme<?php echo $z; ?>' /></td >
              <td align="left"><div class="n_1"><?php echo $fetch['first_name'].' '.$fetch['last_name']; ?></div></td>
               <td align="left"><div class="n_1"><?php echo $fetch['email']; ?></div></td>
                <td align="left"><div class="n_1"><?php echo $fetch['txn_id']; ?></div></td>
                 <td align="left"><div class="n_1"><?php echo $fetch['mc_gross']; ?></div></td>
                  <td align="left"><div class="n_1"><?php echo $fetch['payment_status']; echo " ";echo "(";  if($fetch['payment_status']=='Pending'){echo $fetch['pending_reason']; } echo ")";
				  ?></div></td>
           <!--   
              <td align="center"><a href="sort_gen.php?type=first_name&tab=<?php echo $tabl; ?>&height=500&width=600&rel=<?php echo $fetch['id']; ?>" class="thickbox"><img src="images/sort-neither.png" title="Sort" width="13" height="16" /></a></td>-->
              <td align="center"><?php if($fetch['status'] == '1'){ ?>
                <a href='<?php echo $namep; ?>?do=disable&id=<?php echo $fetch['id'].$q_string_pg; ?>' onclick='return dis_fun();'><img src='images/enabled.gif' title='Disable' width='16' height='16' /></a>
                <?php }else{ ?>
                <a href='<?php echo $namep; ?>?do=enable&id=<?php echo $fetch['id'].$q_string_pg; ?>' onclick='return enb_fun();'><img src='images/disabled.gif' title='Enable' width='16' height='16' /></a>
                <?php } ?>
              </td>
             <!-- <td align="center"><a title="View" href="manage_aspiration_text.php?qee=<?php echo $fetch['id']; ?>" class="addq"><big><b>+</b></big>Aspirations Text</a></td>-->
              <td align="center">
              	 <!--<a style="margin:0px 10px;" href="view_product.php?do=view&id=<?php echo $fetch['id'].$q_string_pg; ?>" title="View"> <img src="images/view.png" /> </a>-->
                <!--<a style="margin:0px 10px;" href="<?php echo $page_child; ?>?do=edit&id=<?php echo $fetch['id'].$q_string_pg; ?>" title="Edit"> <img src="images/edit.png" /> </a>-->
                <a style="margin:0px 10px;" href="<?php echo $namep.'?do=delete&id='.$fetch['id'].$q_string_pg; ?>" title="Delete" onclick="return del_fun();"> <img src="images/delete.png" /> </a>
              </td>
            </tr>
            <?php $z++; } ?>
          </table>
          <!-- pagination start from here -->
		  <?php
            require("include/pagination_show.php");
          ?>
          <!-- pagination end from here -->
          <div class="clear"></div>
          <div class="slideshowdelend">
            <input onclick="return del_fun();" type="submit" name="Delete" value="Delete Selected" class="formbutton" />
          </div>
        </form>
      </div>
      <!-- footer logo start from here -->
      <?php
	  	include "include/footerlogo.php";
	  ?>
      <!-- footer logo end from here -->
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>
