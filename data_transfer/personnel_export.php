<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$officecd = $_POST['officecd'];
$personnel_export_query="SELECT * FROM personnel WHERE officecd='$officecd'";

$personnel_export_result=mysql_query($personnel_export_query,$DBLink) or die(mysql_error());
$return=array();
while($row=mysql_fetch_assoc($personnel_export_result))
{
    $return[]=$row;
}	
echo json_encode($return);
?>
