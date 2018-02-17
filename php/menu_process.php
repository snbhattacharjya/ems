<?php
session_start();
$user_type_id=$_POST['user_type_id'];
$userid=$_SESSION['UserID'];
require_once("../config/config.php");

$menu_query=$mysqli->prepare("SELECT userpage.PageName, userpage.PageTitle, userpage.PageIcon, usermenu.MenuType, usermenu.MenuOrder, usermenu.SubMenuOrder FROM userpage INNER JOIN usermenu ON userpage.PageID=usermenu.PageID WHERE usermenu.UserTypeID=? ORDER BY usermenu.MenuOrder, usermenu.SubMenuOrder") or die($mysqli->error);
$menu_query->bind_param("i",$user_type_id) or die($menu_query->error);
$menu_query->execute() or die($menu_query->error);
$menu_query->bind_result($page_name, $page_title, $page_icon, $menu_type, $menu_order, $submenu_order);
?>
<ul class="sidebar-menu">
<?php
$flag=0;
$temp_menu_order=0;
$counter=1;
while($menu_query->fetch()){
	if($menu_type==1 && $submenu_order==0 && $flag==0){
?>
	<li>
      <a href="<?php echo $page_name;?>" class="ajax_link">
        <i class="fa fa-<?php echo $page_icon; ?>"></i> <span><?php echo $page_title; ?></span>
      </a>
    </li>
	<?php
    }
	if($menu_type==2 && $submenu_order==0 && $flag==0 && $temp_menu_order!=$menu_order){
		$temp_menu_order=$menu_order;
		$flag=1;
	?>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-<?php echo $page_icon; ?>"></i>
        <span><?php echo $page_title; ?></span><i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
    <?php 
	}
	if($menu_type==2 && $submenu_order!=0 && $flag==1 && $temp_menu_order==$menu_order){
	?>
    	<li><a href="<?php echo $page_name;?>" class="ajax_link"><i class="fa fa-<?php echo $page_icon; ?>"></i><?php echo $page_title; ?></a></li>
    <?php
	}
	if($menu_type==2 && $submenu_order==0 && $temp_menu_order!=$menu_order && $flag=1){
		$temp_menu_order=$menu_order;
	?>
   	</ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-<?php echo $page_icon; ?>"></i>
        <span><?php echo $page_title; ?></span><i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
    <?php
	}
	if($menu_type==1 && $submenu_order==0 && $flag==1){
		$flag=0;
	?>
    </ul>
    </li>
    <li>
      <a href="<?php echo $page_name;?>" class="ajax_link">
        <i class="fa fa-<?php echo $page_icon; ?>"></i> <span><?php echo $page_title; ?></span>
      </a>
    </li>
    <?php
	}
    ?>
<?php
}
if($flag=1)
{
?>
	</ul>
    </li>
<?php
}
?>
</ul>