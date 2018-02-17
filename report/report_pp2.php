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
<table class="table table-bordered">
<tr class="info"><th>Office Catagory </th>
<?php
$query_get_subdiv=mysql_query("SELECT subdivisioncd,subdivision FROM subdivision_hooghly",$DBLink) or die(mysql_error());
	while($res=mysql_fetch_assoc($query_get_subdiv))
	{
?>
<th colspan="3"><?php echo $subdiv=$res['subdivision'];?></th>
<?php
	}
?>
</tr>
<tr class="success"><td></td><th>Male</th><th>Female</th><th>Total</th><th>Male</th><th>Female</th><th>Total</th><th>Male</th><th>Female</th><th>Total</th><th>Male</th><th>Female</th><th>Total</th></tr>
<?php
$category_details_query="SELECT govtcategory.govt, govtcategory.govt_description FROM govtcategory";
$category_details_result=mysql_query($category_details_query,$DBLink) or die(mysql_error());

while($row=mysql_fetch_assoc($category_details_result))
{
	$govtid=$row['govt'];
	$query_get_subdiv=mysql_query("SELECT subdivisioncd,subdivision FROM subdivision_hooghly",$DBLink) or die(mysql_error());
?>
<tr>
<?PHP
	echo "<td>".$row['govt_description']."</td>";
	while($res=mysql_fetch_assoc($query_get_subdiv))
	{
		$total_staff_district_from_office=0;
		$male_staff_district_from_office=0;
		$female_staff_district_from_office=0;
		$total_staff_district_from_personnel=0;
		$male_staff_district_from_personnel=0;
		$female_staff_district_from_personnel=0;
		$subdiv=$res['subdivisioncd'];
		$query_get_staff_form_office=mysql_query("SELECT tot_staff,male_staff,female_staff FROM office WHERE subdivisioncd='$subdiv' and govt='$govtid'",$DBLink) or die(mysql_error());
			$total_staff_from_office=0;
			$male_staff_from_office=0;
			$female_staff_from_office=0;
				while($ret1=mysql_fetch_assoc($query_get_staff_form_office))
				{
					$total_staff_from_office=$total_staff_from_office+$ret1['tot_staff'];
					$male_staff_from_office=$male_staff_from_office+$ret1['male_staff'];
					$female_staff_from_office=$female_staff_from_office+$ret1['female_staff'];
					
				}
				
			$query_get_total_staff_form_personel=mysql_query("SELECT count(*) as Total_staff FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.subdivisioncd='$subdiv' and office.govt='$govtid' ",$DBLink) or die(mysql_error());
		
				$ret_total=mysql_fetch_assoc($query_get_total_staff_form_personel);
				
			$query_get_total_male_staff_form_personel=mysql_query("SELECT count(*) as Total_male FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.subdivisioncd='$subdiv' and office.govt='$govtid' and personnel.gender='M'",$DBLink) or die(mysql_error());
		
				$ret_male=mysql_fetch_assoc($query_get_total_male_staff_form_personel);
				
			$query_get_total_female_staff_form_personel=mysql_query("SELECT count(*) as Total_female FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.subdivisioncd='$subdiv' and office.govt='$govtid' and personnel.gender='F'",$DBLink) or die(mysql_error());
		
				$ret_female=mysql_fetch_assoc($query_get_total_female_staff_form_personel);
				
				echo "<td style='text-align:right;'>".$ret_male['Total_male']."/".$male_staff_from_office."</td><td>".$ret_female['Total_female']."/".$female_staff_from_office."</td><td>".$ret_total['Total_staff']."/".$total_staff_from_office."</td>";
				$total_staff_district_from_office=$total_staff_district_from_office+$total_staff_from_office;
				$male_staff_district_from_office=$male_staff_district_from_office+$male_staff_from_office;
				$female_staff_district_from_office=$female_staff_district_from_office+$female_staff_from_office;
		
				$total_staff_district_from_personnel=$total_staff_district_from_personnel+$ret_total['Total_staff'];
				$male_staff_district_from_personnel=$male_staff_district_from_personnel+$ret_male['Total_male'];
				$female_staff_district_from_personnel=$female_staff_district_from_personnel+$ret_female['Total_female'];

	}
?>
</tr>
<?PHP
}
?>

<tr class="warning">
<td>Total</td>
<?php
$query_get_subdiv=mysql_query("SELECT subdivisioncd,subdivision FROM subdivision_hooghly",$DBLink) or die(mysql_error());
	while($res=mysql_fetch_assoc($query_get_subdiv))
	{
		$subdiv=$res['subdivisioncd'];
	$query_get_staff=mysql_query("SELECT tot_staff,male_staff,female_staff FROM office WHERE subdivisioncd='$subdiv'",$DBLink) or die(mysql_error());
	$total_staff_from_office=0;
	$male_staff_from_office=0;
	$female_staff_from_office=0;
		while($ret_1=mysql_fetch_assoc($query_get_staff))
		{
			$total_staff_from_office=$total_staff_from_office+$ret_1['tot_staff'];
			$male_staff_from_office=$male_staff_from_office+$ret_1['male_staff'];
			$female_staff_from_office=$female_staff_from_office+$ret_1['female_staff'];
			
		}
		
	$query_get_total_staff_form_personel=mysql_query("SELECT count(*) as Total_staff FROM personnel WHERE subdivisioncd='$subdiv'",$DBLink) or die(mysql_error());

		$ret_total=mysql_fetch_assoc($query_get_total_staff_form_personel);
		
	$query_get_total_male_staff_form_personel=mysql_query("SELECT count(*) as Total_male FROM personnel WHERE subdivisioncd='$subdiv' and gender='M'",$DBLink) or die(mysql_error());

		$ret_male=mysql_fetch_assoc($query_get_total_male_staff_form_personel);
		
	$query_get_total_female_staff_form_personel=mysql_query("SELECT count(*) as Total_female FROM personnel WHERE subdivisioncd='$subdiv' and gender='F'",$DBLink) or die(mysql_error());

		$ret_female=mysql_fetch_assoc($query_get_total_female_staff_form_personel);
		
		echo "<td>".$ret_male['Total_male']."/".$male_staff_from_office."</td><td>".$ret_female['Total_female']."/".$female_staff_from_office."</td><td>".$ret_total['Total_staff']."/".$total_staff_from_office."</td>";
	}
?>
</tr>
</table>

</div><!-- /.box-body -->
<div class="box-footer text-center">
Showing number of staffs added and the actual number of staffs in the Subdivision according to the Category of the offices.
            </div><!-- /.box-footer -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->   