<?php
session_start();
if(isset($_SESSION['Office']))
$ofccd=$_SESSION['Office'];
else
die();
require("../config/config.php");
$query_mark_declaration=mysql_query("UPDATE office SET dc_flag=1 WHERE officecd='$ofccd'") or die(mysql_error());
?>