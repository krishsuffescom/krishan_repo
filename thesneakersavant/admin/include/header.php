<div class="top_header">
  <div class="logo"> <a href="dashboard.php"> <img src="../images/logoCircle.png" alt="images/s" width="85" height="69" /> </a> </div>
  <div class="site_name"><?php echo $site_name; ?> Admin Panel </div>
  <div class="top_header_right">
    <div class="clock">
      <div id="Date"></div>
      <ul>
        <li id="hours">LO</li>
        <li id="point">:</li>
        <li id="min">AD</li>
        <li id="point">:</li>
        <li id="sec">IN</li>
        <li id="ap">G...</li>
      </ul>
    </div>
  </div>
  <a class="log" href="logout.php">Logout</a> <a class="log" href="update_profile.php">Update Profile</a> </div>
<div class="header">
  <div class="list">
    <ul id="nav">
      <li class="dashboard"> <a href="javascript:void(0)"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="configuration<?php echo  $pg_active['con'];; ?>">Shoes brand</span> </span> <span class="dashboardright"></span> </a>
        <ul>
          <li class="listdiv"></li>
          <li><a href="manage_brand.php">Manage shoes brand</a></li>
          <li class="listdivbtm"></li>
        </ul>
      </li>
      <li class="dashboard"> <a href="javascript:void(0)"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="configuration<?php echo  $pg_active['con'];; ?>">Model</span> </span> <span class="dashboardright"></span> </a>
        <ul>
          <li class="listdiv"></li>
         <li><a href="manage_model.php">Manage shoes model</a></li>
          <li class="listdivbtm"></li>
        </ul>
      </li>
       <li class="dashboard"> <a href="javascript:void(0)"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="configuration<?php echo  $pg_active['con'];; ?>">Size</span> </span> <span class="dashboardright"></span> </a>
        <ul>
          <li class="listdiv"></li>
         <li><a href="manage_size.php">Manage shoes size</a></li>
          <li class="listdivbtm"></li>
        </ul>
      </li>
       <li class="dashboard"> <a href="javascript:void(0)"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="configuration<?php echo  $pg_active['con'];; ?>">Product</span> </span> <span class="dashboardright"></span> </a>
        <ul>
          <li class="listdiv"></li>
         <li><a href="manage_product.php">Manage product</a></li>
          <li class="listdivbtm"></li>
        </ul>
      </li>
        <li class="dashboard"> <a href="manage_order.php"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="configuration<?php echo  $pg_active['con'];; ?>">Order</span> </span> <span class="dashboardright"></span> </a>
    <!--   <li class="dashboard"> <a href="manage_payment.php"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="configuration<?php echo  $pg_active['con'];; ?>">Payment</span> </span> <span class="dashboardright"></span> </a>-->
      <li class="dashboard"> <a href="add_config.php"> <span class="dashboardleft"></span> <span class="dashboardcenter"> <span class="configuration<?php echo  $pg_active['con'];; ?>">Configuration</span> </span> <span class="dashboardright"></span> </a>
        <!--<ul>
          <li class="listdiv"></li>
          <li><a href="manage_gold.php">Config</a></li>
          <li class="listdivbtm"></li>
        </ul>-->
      </li>
     
    </ul>
    <div class="clear"></div>
  </div>
</div>
