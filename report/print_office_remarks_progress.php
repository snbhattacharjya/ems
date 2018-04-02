<?php
session_start();
require("../config/config.php");
?>


<h3 class="box-title">Personnel Remarks Distribution Report (Total)</h3>

<table border="1" cellspacing="0" cellpadding="5">
  <?php
  $remarks_names=array();
  $remarks_query=$mysqli->prepare("SELECT remarks.remarks_cd, remarks.remarks, COUNT(CASE personnel.gender WHEN 'M' THEN 1 END), COUNT(CASE personnel.gender WHEN 'F' THEN 1 END) FROM personnel INNER JOIN remarks ON personnel.remarks=remarks.remarks_cd GROUP BY remarks.remarks_cd, remarks.remarks ORDER BY remarks.remarks_cd") or die($mysqli->error);
  $remarks_query->execute() or die($remarks_query->error);
  $remarks_query->bind_result($remarks_code,$remarks_name,$male_remarks_count,$female_remarks_count) or die($remarks_query->error);
  while($remarks_query->fetch()){
  	$remarks_names[]=array("RemarksCode"=>$remarks_code,"RemarksName"=>$remarks_name,"MaleRemarksCount"=>$male_remarks_count,"FemaleRemarksCount"=>$female_remarks_count);
  }
  $remarks_query->close();
  ?>
  <thead>
  <tr class="bg-teal-gradient">
  <th>REMARKS</th>
  <th>Male Count</th>
  <th>Female Count</th>
  <th>TOTAL</th>
  </tr>
  </thead>
  <tbody>
  <?php
  $total_male_count = 0;
  $total_female_count = 0;
  	for($i=0;$i<count($remarks_names);$i++){
  ?>
  	  <tr>
      	<td><?php echo $remarks_names[$i]['RemarksName']; ?></td>
        <td><?php echo $remarks_names[$i]['MaleRemarksCount']; ?></td>
        <td><?php echo $remarks_names[$i]['FemaleRemarksCount']; ?></td>
        <td><?php echo $remarks_names[$i]['MaleRemarksCount'] + $remarks_names[$i]['FemaleRemarksCount']; ?></td>
      </tr>
  <?php
    $total_male_count += $remarks_names[$i]['MaleRemarksCount'];
    $total_female_count += $remarks_names[$i]['FemaleRemarksCount'];
  }
  ?>
  </tbody>
  <tfoot>
  <tr class="info">
  	<th>TOTAL</th>
    <th><?php echo $total_male_count; ?></th>
    <th><?php echo $total_female_count; ?></th>
  	<th><?php echo $total_male_count + $total_female_count; ?></th>
  </tr>
  </tfoot>
</table>
<h1 style="page-break-after: always;"></h1>
<h3 class="box-title">Personnel Remarks Distribution Report (Updated)</h3>

<table border="1" cellspacing="0" cellpadding="5">
  <?php
  $remarks_names=array();
  $remarks_query=$mysqli->prepare("SELECT remarks.remarks_cd, remarks.remarks, COUNT(CASE personnel.gender WHEN 'M' THEN 1 END), COUNT(CASE personnel.gender WHEN 'F' THEN 1 END) FROM personnel INNER JOIN remarks ON personnel.remarks=remarks.remarks_cd AND DATE_FORMAT(personnel.posted_date,'%Y') = '2018' GROUP BY remarks.remarks_cd, remarks.remarks ORDER BY remarks.remarks_cd") or die($mysqli->error);
  $remarks_query->execute() or die($remarks_query->error);
  $remarks_query->bind_result($remarks_code,$remarks_name,$male_remarks_count,$female_remarks_count) or die($remarks_query->error);
  while($remarks_query->fetch()){
  	$remarks_names[]=array("RemarksCode"=>$remarks_code,"RemarksName"=>$remarks_name,"MaleRemarksCount"=>$male_remarks_count,"FemaleRemarksCount"=>$female_remarks_count);
  }
  $remarks_query->close();
  ?>
  <thead>
  <tr class="bg-teal-gradient">
  <th>REMARKS</th>
  <th>Male Count</th>
  <th>Female Count</th>
  <th>TOTAL</th>
  </tr>
  </thead>
  <tbody>
  <?php
  $total_male_count = 0;
  $total_female_count = 0;
  	for($i=0;$i<count($remarks_names);$i++){
  ?>
  	  <tr>
      	<td><?php echo $remarks_names[$i]['RemarksName']; ?></td>
        <td><?php echo $remarks_names[$i]['MaleRemarksCount']; ?></td>
        <td><?php echo $remarks_names[$i]['FemaleRemarksCount']; ?></td>
        <td><?php echo $remarks_names[$i]['MaleRemarksCount'] + $remarks_names[$i]['FemaleRemarksCount']; ?></td>
      </tr>
  <?php
    $total_male_count += $remarks_names[$i]['MaleRemarksCount'];
    $total_female_count += $remarks_names[$i]['FemaleRemarksCount'];
  }
  ?>
  </tbody>
  <tfoot>
  <tr class="info">
  	<th>TOTAL</th>
    <th><?php echo $total_male_count; ?></th>
    <th><?php echo $total_female_count; ?></th>
  	<th><?php echo $total_male_count + $total_female_count; ?></th>
  </tr>
  </tfoot>
</table>
