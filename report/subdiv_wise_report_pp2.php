<?php
session_start();
require("../config/config.php");
?>
<script>
$(document).ready(function(e) {
	var table;
	if(checkSubdivSession()=="TRUE")
	{
		$('#show_subdiv').html("for SUBDIVISION&nbsp;"+getSubdivNamefromSession());
		$('#div_message').hide();
		$('#pp2_table').show();
		
	}
	else
	{
		$('#div_message').show();
		$('#div_message').html("<h4>Please Set Subdivision first.</h4>");
		$('#pp2_table').hide();
	}
	$(document).scrollTop(0);
	
});

</script>
<div class="row">

	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h3 class="box-title">Office wise PP2 Details 
                </h3>              
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->



			<div class="box-body">
    <div id="div_message" class="callout callout-danger" hidden="">												
    </div>
<?php
if(isset($_SESSION['Subdiv']))
{
$subdiv=$_SESSION['Subdiv'];
}
else
{
	die();	
}
?>

<div class="pad">
<div class="alert bg-primary">												
    <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;INFORMATION OF ALL OFFICES
        <span id="show_subdiv">
        </span>
        <?PHP 
        if(isset($_SESSION['Subdiv']))
        echo "(".$_SESSION['Subdiv'].")";
        
        ?>
</div>
</div>
    
<table class="table table-striped" id="pp2_table">
<thead>
<tr><th>Office Code </th><th>Office Name</th><th>Male Employee</th><th>Female Employee</th><th>Total Employee</th></tr>
</thead>
<tbody>
<?php
$query_get_office=mysql_query("SELECT officecd,office,phone,mobile FROM office WHERE subdivisioncd='$subdiv'",$DBLink) or die(mysql_error());
$total_staff_district_from_office=0;
$male_staff_district_from_office=0;
$female_staff_district_from_office=0;
$total_staff_district_from_personnel=0;
$male_staff_district_from_personnel=0;
$female_staff_district_from_personnel=0;
	while($res=mysql_fetch_assoc($query_get_office))
	{
?>
<tr>
<td><?php echo $office=$res['officecd']?></td>
<td><?php echo $res['office']."(".$res['phone']." / ".$res['mobile'].")"?></td>
<?php

	$query_get_staff_form_office=mysql_query("SELECT tot_staff,male_staff,female_staff FROM office WHERE officecd='$office'",$DBLink) or die(mysql_error());
	$total_staff_from_office=0;
	$male_staff_from_office=0;
	$female_staff_from_office=0;
		while($ret1=mysql_fetch_assoc($query_get_staff_form_office))
		{
			$total_staff_from_office=$total_staff_from_office+$ret1['tot_staff'];
			$male_staff_from_office=$male_staff_from_office+$ret1['male_staff'];
			$female_staff_from_office=$female_staff_from_office+$ret1['female_staff'];
			
		}
		
	$query_get_total_staff_form_personel=mysql_query("SELECT count(*) as Total_staff FROM personnel WHERE officecd='$office'",$DBLink) or die(mysql_error());

		$ret_total=mysql_fetch_assoc($query_get_total_staff_form_personel);
		
	$query_get_total_male_staff_form_personel=mysql_query("SELECT count(*) as Total_male FROM personnel WHERE officecd='$office' and gender='M'",$DBLink) or die(mysql_error());

		$ret_male=mysql_fetch_assoc($query_get_total_male_staff_form_personel);
		
	$query_get_total_female_staff_form_personel=mysql_query("SELECT count(*) as Total_female FROM personnel WHERE officecd='$office' and gender='F'",$DBLink) or die(mysql_error());

		$ret_female=mysql_fetch_assoc($query_get_total_female_staff_form_personel);
		
		echo "<td>".$ret_male['Total_male']."/".$male_staff_from_office."</td><td>".$ret_female['Total_female']."/".$female_staff_from_office."</td><td>".$ret_total['Total_staff']."/".$total_staff_from_office."</td>";
		$total_staff_district_from_office=$total_staff_district_from_office+$total_staff_from_office;
		$male_staff_district_from_office=$male_staff_district_from_office+$male_staff_from_office;
		$female_staff_district_from_office=$female_staff_district_from_office+$female_staff_from_office;

		$total_staff_district_from_personnel=$total_staff_district_from_personnel+$ret_total['Total_staff'];
		$male_staff_district_from_personnel=$male_staff_district_from_personnel+$ret_male['Total_male'];
		$female_staff_district_from_personnel=$female_staff_district_from_personnel+$ret_female['Total_female'];
		
?>
</tr>
<?php
	}
?>
</tbody>
<tfoot>
<tr class="info">
<?php
echo "<td><b>Total Staff in Subdivision</b></td><td></td>
<td><span class=\"badge bg-yellow\">".$male_staff_district_from_personnel."</span>/<span class=\"badge bg-light-blue\">".$male_staff_district_from_office."</span></td><td><span class=\"badge bg-yellow\">".$female_staff_district_from_personnel."</span>/<span class=\"badge bg-light-blue\">".$female_staff_district_from_office."</span></td><td><span class=\"badge bg-yellow\">".$total_staff_district_from_personnel."</span>/<span class=\"badge bg-green\">".$total_staff_district_from_office."</span></td>";
	
?>
</tr>
</tfoot>
</table>
</div><!-- /.box-body -->
<div class="box-footer text-center">
Showing number of staffs added and the actual number of staffs in the Office.
            </div><!-- /.box-footer -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->   
<script>
table=$('#pp2_table').DataTable({
		"paging": true,
	 	"lengthChange": true,
	  	"searching": true,
	  	"ordering": true,
	  	"info": true,
	  	"autoWidth": true
		}); 
</script>