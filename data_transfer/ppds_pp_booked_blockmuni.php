<?php
session_start();
require("../config/config.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$block_muni=$_POST['blockmuni'];

$blockmuni_query=$mysqli_ppds->prepare("SELECT personnela.personcd, personnela.forassembly, personnela.booked, training_pp.training_sch FROM (office INNER JOIN personnela ON office.officecd=personnela.officecd) INNER JOIN training_pp ON personnela.personcd = training_pp.per_code WHERE personnela.poststat IN ('PR','P1','P2','P3') AND personnela.booked IN ('P','R','C') AND training_pp.training_type='01' AND office.blockormuni_cd = ? ORDER BY personnela.personcd") or die($mysqli_ppds->error);
$blockmuni_query->bind_param("s",$block_muni) or die($blockmuni_query->error);
$blockmuni_query->execute() or die($blockmuni_query->error);
$blockmuni_query->bind_result($personcd,$forassembly,$booked,$training1_sch) or die($blockmuni_query->error);
$blockmuni=array();
while($blockmuni_query->fetch()){
	$blockmuni[]=array("personcd"=>$personcd, "forassembly"=>$forassembly, "booked"=>$booked,"training1_sch"=>$training1_sch);
}
$blockmuni_query->close();
echo json_encode($blockmuni);
?>