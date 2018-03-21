<?php
session_start();
if(isset($_SESSION['Office']))
$ofccd=$_SESSION['Office'];
else
die();
require("../config/config.php");
date_default_timezone_set("Asia/Kolkata");
$query_mark_declaration=mysqli_query($DBLink,"UPDATE office SET dc_flag=1, dc_date = now() WHERE officecd='$ofccd'") or die(mysqli_error($DBLink));
?>
