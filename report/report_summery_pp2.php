<?php
session_start();
require("../config/config.php");
?>
<div class="row">

	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h3 class="box-title">Subdisistion wise PP2 Details
                </h3>              
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->



<div class="box-body  table-responsive">
<div class="pad">
<div class="alert bg-primary">												
    <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;INFORMATION OF ALL SUBDIVISION
</div>
</div>
<table class="table table-striped">
<tr class="success"><th>Subdivision Name</th><th>Employee Added in PP2</th><th>Total Number of Employee as per PP1</th></tr>

<?php
$total_staff_district_from_office=0;
$total_staff_district_from_personnel=0;
$query_get_subdiv=mysql_query("SELECT subdivisioncd,subdivision FROM subdivision_hooghly",$DBLink) or die(mysql_error());
	while($res=mysql_fetch_assoc($query_get_subdiv))
	{
		$subdiv=$res['subdivisioncd'];
		echo "<tr><td><b>".$res['subdivision']."</b></td>";
	$query_get_staff=mysql_query("SELECT tot_staff FROM office WHERE subdivisioncd='$subdiv'",$DBLink) or die(mysql_error());
	$total_staff_from_office=0;
		while($ret_1=mysql_fetch_assoc($query_get_staff))
		{
			$total_staff_from_office=$total_staff_from_office+$ret_1['tot_staff'];
			
		}
		
		$total_staff_district_from_office=$total_staff_district_from_office+$total_staff_from_office;
		
		
	$query_get_total_staff_form_personel=mysql_query("SELECT count(*) as Total_staff FROM personnel WHERE subdivisioncd='$subdiv'",$DBLink) or die(mysql_error());

		$ret_total=mysql_fetch_assoc($query_get_total_staff_form_personel);
		
		echo "<td>".$ret_total['Total_staff']."</td><td>".$total_staff_from_office."</td></tr>";
		$total_staff_district_from_personnel=$total_staff_district_from_personnel+$ret_total['Total_staff'];
	}
	
	echo "<tr class='info'><td><b>Total</b></td><td>".$total_staff_district_from_personnel."</td><td>".$total_staff_district_from_office."</td></tr>";
?>

</table>

</div><!-- /.box-body -->
<div class="box-footer text-center">
Showing number of total Employees and the number of Employees added.
            </div><!-- /.box-footer -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->   