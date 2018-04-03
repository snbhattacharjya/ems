<?php
session_start();
require("../config/config.php");
?>


            	<h3 class="box-title">Office Pending Report (NO Personnel)</h3>


<table border="1" cellspacing="0" cellpadding="5">
<thead>
<tr class="warning">
  <th>Office Code </th>
  <th>Office Name</th>
  <th>Head Of Office Designation</th>
  <th>Office Address</th>
  <th>Email</th>
  <th>Contact Details</th>
  <th>Total Staff PP1</th>
  <th>Male Staff PP1</th>
  <th>Female Staff PP1</th>
  <th>PP1 Update Date</th>
</tr>
</thead>
<tbody>
<?php
$opt = $_GET['opt'];
$code = $_GET['code'];
if($opt == 'subdiv'){
	$query_get_office=mysqli_query($DBLink,"SELECT office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.email, office.phone, office.mobile, office.tot_staff AS pp1_count, office.male_staff, office.female_staff, office.posted_date FROM (office INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd WHERE officecd NOT IN (SELECT officecd FROM personnel) AND office.subdivisioncd='$code'") or die(mysqli_error($DBLink));
}
else{
	$query_get_office=mysqli_query($DBLink,"SELECT office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.email, office.phone, office.mobile, office.tot_staff AS pp1_count, office.male_staff, office.female_staff, office.posted_date FROM (office INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd WHERE officecd NOT IN (SELECT officecd FROM personnel) AND office.blockormuni_cd='$code'") or die(mysqli_error($DBLink));
}
$count=0;
$total_pp1=0;
$total_male=0;
$total_female=0;
	while($res=mysqli_fetch_assoc($query_get_office))
	{
		$count=$count+1;
?>
<tr>
<td><?php echo $res['officecd'];?></td>
<td><?php echo $res['office'];?></td>
<td><?php echo $res['officer_desg'];?></td>
<td><?php echo $res['address1'].', '.$res['address2'].'; <strong>Block/Muni</strong> - '.$res['blockmuni'].'; <strong>P.S. </strong>- '.$res['policestation'].'; <strong>PO: </strong>'.$res['postoffice'].'; <strong>Pin </strong>- '.$res['pin'];?></td>
<td><?php echo $res['email'];?></td>
<td>
<?php echo $res['phone']." / ".$res['mobile']; ?></td>
<?php

	$total_pp1=$total_pp1+$res['pp1_count'];
  $total_male+=$res['male_staff'];
	$total_female+=$res['female_staff'];

?>
<td><?php echo $res['pp1_count']; ?></td>
<td><?php echo $res['male_staff']; ?></td>
<td><?php echo $res['female_staff']; ?></td>
<td>
  <?php
    if(date_format(date_create($res['posted_date']),'Y') == 2018){
      echo date_format(date_create($res['posted_date']),'d-M-Y H:i:s');
    }
    else {
      echo "Not Updated";
    }
  ?>
</td>
</tr>
<?php
	}
?>
</tbody>
<tfoot>
<tr class="info">
	<th colspan="3">Total Office</th>
    <th><?php echo $count;?></th>
    <th>Total Count</th>
    <th><?php echo $total_pp1;?></th>
    <th><?php echo $total_male;?></th>
    <th><?php echo $total_female;?></th>
    <th>&nbsp;</th>
</tr>
</tfoot>
</table>
