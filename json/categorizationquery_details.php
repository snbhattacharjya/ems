<?php
//session_start();
//header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
require("../config/config.php");
$subdiv=$_POST['subdivision'];
$postcat=$_POST['postcategory'];
$officecat= explode(',',$_POST['officecat']);
$designation=explode(',',$_POST['designation']);
$basicpay=explode(',',$_POST['basicpay']);
$gradepay=explode(',',$_POST['gradepay']);
$qualification=explode(',',$_POST['qualification']);
$categorization_details_query="SELECT COUNT(personcd) as count FROM ((personnel INNER JOIN office ON personnel.officecd=office.officecd) INNER JOIN govtcategory ON office.govt=govtcategory.govt) INNER JOIN qualification ON personnel.qualificationcd=qualification.qualificationcd WHERE ";
if($subdiv != '')
	$categorization_details_query.="personnel.subdivisioncd='$subdiv'";
if(isset($postcat))
	$categorization_details_query.=" AND personnel.poststat='$postcat'";
if(isset($officecat))
{
	$categorization_details_query.=" AND govtcategory.govt_description IN (";
	for($i=0;$i<count($officecat);$i++)
	{
		$categorization_details_query.="'$officecat[$i]',";
	}
	$categorization_details_query=substr($categorization_details_query,0,-1);
	$categorization_details_query.=")";
}
if(isset($designation)){
	$categorization_details_query.=" AND personnel.off_desg IN (";
	for($i=0;$i<count($designation);$i++)
	{
		$categorization_details_query.="'$designation[$i]',";
	}
	$categorization_details_query=substr($categorization_details_query,0,-1);
	$categorization_details_query.=")";
}
if(isset($basicpay)){
	$categorization_details_query.=" AND personnel.basic_pay IN (";
	for($i=0;$i<count($basicpay);$i++)
	{
		$categorization_details_query.="$basicpay[$i],";
	}
	$categorization_details_query=substr($categorization_details_query,0,-1);
	$categorization_details_query.=")";
}
if(isset($gradepay)){
	$categorization_details_query.=" AND personnel.grade_pay IN (";
	for($i=0;$i<count($gradepay);$i++)
	{
		$categorization_details_query.="$gradepay[$i],";
	}
	$categorization_details_query=substr($categorization_details_query,0,-1);
	$categorization_details_query.=")";
}
if(isset($qualification)){
	$categorization_details_query.=" AND qualification.qualification IN (";
	for($i=0;$i<count($qualification);$i++)
	{
		$categorization_details_query.="'$qualification[$i]',";
	}
	$categorization_details_query=substr($categorization_details_query,0,-1);
	$categorization_details_query.=")";
}
echo $categorization_details_query;
$select=mysqli_query($categorization_details_query,$DBLink);
$fetch=mysqli_fetch_array($DBLink,$select);
echo $fetch['count'];
?>