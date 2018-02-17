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
            	<h3 class="box-title">Whole District PP2 Details
                </h3>              
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->



<div class="box-body  table-responsive">
<div class="pad">
<div class="alert bg-primary">												
    <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;CEO OFFICE REPORT AS ON <?php date_default_timezone_set("Asia/Kolkata"); echo date('d/m/Y h:i A')?>
</div>
</div>
<table class="table table-bordered">
<tr><td>No of employees of State Govt.</td>
<?php

			$query_get_total_staff_form_personel=mysql_query("SELECT count(*) as Total_staff FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='02' ",$DBLink) or die(mysql_error());
		
				$ret_total=mysql_fetch_assoc($query_get_total_staff_form_personel);
				
			$query_get_total_male_staff_form_personel=mysql_query("SELECT count(*) as Total_male FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='02' and personnel.gender='M'",$DBLink) or die(mysql_error());
		
				$ret_male=mysql_fetch_assoc($query_get_total_male_staff_form_personel);
				
			$query_get_total_female_staff_form_personel=mysql_query("SELECT count(*) as Total_female FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='02' and personnel.gender='F'",$DBLink) or die(mysql_error());
		
				$ret_female=mysql_fetch_assoc($query_get_total_female_staff_form_personel);
				
				echo "<td>Male- ".$ret_male['Total_male']."</td><td>Female- ".$ret_female['Total_female']."</td><td>Total- ".$ret_total['Total_staff']."</td>";
?>
</tr>


<tr><td>No of employees of State Govt. Undertakings</td>
<?php

			$query_get_total_staff_form_personel=mysql_query("SELECT count(*) as Total_staff FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='04' ",$DBLink) or die(mysql_error());
		
				$ret_total=mysql_fetch_assoc($query_get_total_staff_form_personel);
				
			$query_get_total_male_staff_form_personel=mysql_query("SELECT count(*) as Total_male FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='04' and personnel.gender='M'",$DBLink) or die(mysql_error());
		
				$ret_male=mysql_fetch_assoc($query_get_total_male_staff_form_personel);
				
			$query_get_total_female_staff_form_personel=mysql_query("SELECT count(*) as Total_female FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='04' and personnel.gender='F'",$DBLink) or die(mysql_error());
		
				$ret_female=mysql_fetch_assoc($query_get_total_female_staff_form_personel);
				
				echo "<td>Male- ".$ret_male['Total_male']."</td><td>Female- ".$ret_female['Total_female']."</td><td>Total- ".$ret_total['Total_staff']."</td>";
?>
</tr>


<tr><td>No of employees of Central Govt.</td>
<?php

			$query_get_total_staff_form_personel=mysql_query("SELECT count(*) as Total_staff FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='01' ",$DBLink) or die(mysql_error());
		
				$ret_total=mysql_fetch_assoc($query_get_total_staff_form_personel);
				
			$query_get_total_male_staff_form_personel=mysql_query("SELECT count(*) as Total_male FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='01' and personnel.gender='M'",$DBLink) or die(mysql_error());
		
				$ret_male=mysql_fetch_assoc($query_get_total_male_staff_form_personel);
				
			$query_get_total_female_staff_form_personel=mysql_query("SELECT count(*) as Total_female FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='01' and personnel.gender='F'",$DBLink) or die(mysql_error());
		
				$ret_female=mysql_fetch_assoc($query_get_total_female_staff_form_personel);
				
				echo "<td>Male- ".$ret_male['Total_male']."</td><td>Female- ".$ret_female['Total_female']."</td><td>Total- ".$ret_total['Total_staff']."</td>";
?>
</tr>

<tr><td>No of employees of Central Govt. Undertakings</td>
<?php

			$query_get_total_staff_form_personel=mysql_query("SELECT count(*) as Total_staff FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='03' ",$DBLink) or die(mysql_error());
		
				$ret_total=mysql_fetch_assoc($query_get_total_staff_form_personel);
				
			$query_get_total_male_staff_form_personel=mysql_query("SELECT count(*) as Total_male FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='03' and personnel.gender='M'",$DBLink) or die(mysql_error());
		
				$ret_male=mysql_fetch_assoc($query_get_total_male_staff_form_personel);
				
			$query_get_total_female_staff_form_personel=mysql_query("SELECT count(*) as Total_female FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE office.govt='03' and personnel.gender='F'",$DBLink) or die(mysql_error());
		
				$ret_female=mysql_fetch_assoc($query_get_total_female_staff_form_personel);
				
				echo "<td>Male- ".$ret_male['Total_male']."</td><td>Female- ".$ret_female['Total_female']."</td><td>Total- ".$ret_total['Total_staff']."</td>";
?>
</tr>


<tr><td>No of Teachers and others</td>
<?php

			$query_get_total_staff_form_personel=mysql_query("SELECT count(*) as Total_staff FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE govt in ('05','06','07','08')",$DBLink) or die(mysql_error());
		
				$ret_total=mysql_fetch_assoc($query_get_total_staff_form_personel);
				
			$query_get_total_male_staff_form_personel=mysql_query("SELECT count(*) as Total_male FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE govt in ('05','06','07','08') and personnel.gender='M'",$DBLink) or die(mysql_error());
		
				$ret_male=mysql_fetch_assoc($query_get_total_male_staff_form_personel);
				
			$query_get_total_female_staff_form_personel=mysql_query("SELECT count(*) as Total_female FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE govt in ('05','06','07','08') and personnel.gender='F'",$DBLink) or die(mysql_error());
		
				$ret_female=mysql_fetch_assoc($query_get_total_female_staff_form_personel);
				
				echo "<td>Male- ".$ret_male['Total_male']."</td><td>Female- ".$ret_female['Total_female']."</td><td>Total- ".$ret_total['Total_staff']."</td>";
?>
</tr>

<tr class="success">
<td>Total</td>
<?php

			$query_get_total_staff_form_personel=mysql_query("SELECT count(*) as Total_staff FROM personnel inner join office ON personnel.`officecd`=office.`officecd`",$DBLink) or die(mysql_error());
		
				$ret_total=mysql_fetch_assoc($query_get_total_staff_form_personel);
				
			$query_get_total_male_staff_form_personel=mysql_query("SELECT count(*) as Total_male FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE gender='M' ",$DBLink) or die(mysql_error());
		
				$ret_male=mysql_fetch_assoc($query_get_total_male_staff_form_personel);
				
			$query_get_total_female_staff_form_personel=mysql_query("SELECT count(*) as Total_female FROM personnel inner join office ON personnel.`officecd`=office.`officecd` WHERE gender='F'",$DBLink) or die(mysql_error());
		
				$ret_female=mysql_fetch_assoc($query_get_total_female_staff_form_personel);
				
				echo "<td>Male- ".$ret_male['Total_male']."</td><td>Female- ".$ret_female['Total_female']."</td><td>Total- ".$ret_total['Total_staff']."</td>";
				
				$total_emp=$ret_total['Total_staff'];
?>
</tr>


<tr><td>Total Mobile No. of employees entered</td>
<?php

			$query_get_no_of_mobile=mysql_query("SELECT count(*) as Total_mob FROM personnel WHERE mob_no!='9999999999'",$DBLink) or die(mysql_error());
		
				$ret_total_mob=mysql_fetch_assoc($query_get_no_of_mobile);
				
			
				
				echo "<td colspan='3'>Total- ".$ret_total_mob['Total_mob']."</td>";
?>
</tr>

<tr><td>% of Mobile nos. entered</td>
<?php
	
	$percentage_mobile=($ret_total_mob['Total_mob']/$total_emp)*100;
				
			
				
				echo "<td colspan='3'> ".$percentage_mobile."%</td>";
?>
</tr>

<tr><td>Total Bank details of employees entered</td>
<?php

				echo "<td colspan='3'> ".$total_emp."</td>";
?>
</tr>
<tr><td>% of Bank details entered</td>
<?php
				echo "<td colspan='3'> 100%</td>";
?>
</tr>

<tr><td>Total Electoral details of employees entered</td>
<?php

				echo "<td colspan='3'> ".$total_emp."</td>";
?>
</tr>
<tr><td>% of Electoral details entered</td>
<?php
				echo "<td colspan='3'> 100%</td>";
?>
</tr>
</table>

</div><!-- /.box-body -->
<div class="box-footer text-center">
Showing number of staffs added in PP2 according to the Category of the offices.
            </div><!-- /.box-footer -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->   