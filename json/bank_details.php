<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");



$bank_details_query="SELECT bank_cd AS BankCode, bank_name AS BankName FROM bank ORDER BY bank_cd";

$bank_details_result=mysqli_query($DBLink,$bank_details_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($bank_details_result))
{
	$return[]=$row;
}
echo json_encode($return);
?>
