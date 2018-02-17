<?php
session_start();
require("../config/config.php");
?>
<script>
$(document).ready(function(e) {
    $(document).scrollTop(0);
});
</script>
<div class="row">

	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h3 class="box-title">Catagory wise Office Details
                </h3>              
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->



<div class="box-body  table-responsive">
<div class="pad">
<div class="alert bg-primary">												
    <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;INFORMATION OF ALL OFFICES
</div>
</div>
<table class="table table-striped">
<tr><th width="26%">Office Catagory </th>
<?php
$query_get_subdiv=mysql_query("SELECT subdivisioncd,subdivision FROM subdivision_hooghly",$DBLink) or die(mysql_error());
	while($res=mysql_fetch_assoc($query_get_subdiv))
	{
?>
<th width="15%"><?php echo $subdiv=$res['subdivision'];?></th>
<?php
	}
?>
<th>TOTAL</th></tr>
<?php
$category_details_query="SELECT govtcategory.govt, govtcategory.govt_description FROM govtcategory";
$category_details_result=mysql_query($category_details_query,$DBLink) or die(mysql_error());

while($row=mysql_fetch_assoc($category_details_result))
{
	$total=0;
	$total_updated=0;
	$govtid=$row['govt'];
	$query_get_subdiv=mysql_query("SELECT subdivisioncd,subdivision FROM subdivision_hooghly",$DBLink) or die(mysql_error());
?>
<tr>
<?PHP
	echo "<td>".$row['govt_description']."</td>";
	while($res=mysql_fetch_assoc($query_get_subdiv))
	{
		$subdiv=$res['subdivisioncd'];
		$update_details_query1="SELECT COUNT(officecd) AS updatedOffice
		FROM office
		WHERE subdivisioncd ='$subdiv' AND flag='Y' AND govt='$govtid'";
		$update_details_result1=mysql_query($update_details_query1,$DBLink) or die(mysql_error());
		$row1=mysql_fetch_assoc($update_details_result1);
		
		
		$update_details_query2="SELECT COUNT(officecd) AS totaloffice
		FROM office
		WHERE subdivisioncd ='$subdiv' AND govt='$govtid'";
		$update_details_result2=mysql_query($update_details_query2,$DBLink) or die(mysql_error());
		$row2=mysql_fetch_assoc($update_details_result2);
		
		//$percentval=($row1['updatedOffice']/$row['OfficeCode'])*100;
		
		echo "<td><b>".$row2['totaloffice']."&nbsp;/</b>&nbsp;<span class=\"badge bg-green\">".$row1['updatedOffice']."</span></td>";
		/*echo "<td>".$row1['updatedOffice']."</td><td><span class=\"badge bg-light-blue\">".ceil($percentval)."%</span></td><td width='30%'><div class=\"progress progress-xs progress-striped active\"><div class=\"progress-bar progress-bar-success\" style=\"width:".$percentval."%\"></div></div></td>";
		*/
		$total=$total+$row2['totaloffice'];
		$total_updated=$total_updated+$row1['updatedOffice'];

	}
	echo "<td><b>".$total."&nbsp;/</b>&nbsp;<span class=\"badge bg-green\">".$total_updated."</span></td>";
?>
</tr>
<?PHP
}
?>
<tr class="info">
<?php
$query_get_subdiv=mysql_query("SELECT subdivisioncd,subdivision FROM subdivision_hooghly",$DBLink) or die(mysql_error());
echo "<td><b>Total</b></td>";
	$total=0;
	$total_updated=0;
	while($res=mysql_fetch_assoc($query_get_subdiv))
	{
		$subdiv=$res['subdivisioncd'];
		$update_details_query1="SELECT COUNT(officecd) AS updatedOffice
		FROM office
		WHERE subdivisioncd ='$subdiv' AND flag='Y'";
		$update_details_result1=mysql_query($update_details_query1,$DBLink) or die(mysql_error());
		$row1=mysql_fetch_assoc($update_details_result1);
		
		
		$update_details_query2="SELECT COUNT(officecd) AS totaloffice
		FROM office
		WHERE subdivisioncd ='$subdiv'";
		$update_details_result2=mysql_query($update_details_query2,$DBLink) or die(mysql_error());
		$row2=mysql_fetch_assoc($update_details_result2);
		$total=$total+$row2['totaloffice'];
		$total_updated=$total_updated+$row1['updatedOffice'];
		
		echo "<td><b><span class=\"badge bg-yellow\">".$row2['totaloffice']."</span>&nbsp;/</b>&nbsp;<span class=\"badge bg-green\">".$row1['updatedOffice']."</span></td>";	
	}
	echo "<td><b><span class=\"badge bg-yellow\">".$total."</span>&nbsp;/</b>&nbsp;<span class=\"badge bg-green\">".$total_updated."</span></td>";
/*
$percentval=($total_updated/$total)*100;
echo "<tr><td><b>Total office</b></td><td><b>".$total."</b></td><td>".$total_updated."</td><td><span class=\"badge bg-light-blue\">".ceil($percentval)."%</span></td><td><div class=\"progress progress-xs progress-striped active\"><div class=\"progress-bar progress-bar-success\" style=\"width:".$percentval."%\"></div></div></td></tr>";
*/
?>
</tr>
</table>

</div><!-- /.box-body -->
<div class="box-footer text-center">
Showing number of total offices and the number of offices already updated.
            </div><!-- /.box-footer -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->   