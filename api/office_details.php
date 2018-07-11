<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");

$office_details_query="SELECT * FROM office";

$office_details_result=mysqli_query($DBLink,$office_details_query) or die(mysqli_error($DBLink));

$return = array();
while($office = mysqli_fetch_assoc($office_details_result)){
    $return[] = $office;
}
echo json_encode($return);
?>
