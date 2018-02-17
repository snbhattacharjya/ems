<?php
session_start();
require("../config/config.php");
?>
<script>
$(document).ready(function(e) {
	if(checkSubdivSession()=="TRUE")
	{
		$('#show_subdiv').html("for SUBDIVISION&nbsp;"+getSubdivNamefromSession());
		$('#div_message').hide();
		$('#office_table').show();
	}
	else
	{
		$('#div_message').show();
		$('#div_message').html("<h4>Please Set Subdivision first.</h4>");
		$('#office_table').hide();
	}
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



			<div class="box-body  table-responsive no-padding">
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

$category_details_query="SELECT govtcategory.govt, govtcategory.govt_description, COUNT( office.officecd ) AS OfficeCode
FROM office
INNER JOIN govtcategory ON office.govt = govtcategory.govt
WHERE office.subdivisioncd ='$subdiv'
GROUP BY govtcategory.govt";
$category_details_result=mysql_query($category_details_query,$DBLink) or die(mysql_error());
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
    
<table class="table table-striped" id="office_table">
<tr><th width="35%">Office Catagory </th><th width="15%">Total</th><th width="15%">Updated</th><th colspan="2">Progress</th></tr>
<?php
$total=0;
$total_updated=0;
while($row=mysql_fetch_assoc($category_details_result))
{
	$govtid=$row['govt'];
	$update_details_query="SELECT COUNT(officecd) AS updatedOffice
	FROM office
	WHERE subdivisioncd ='$subdiv' AND flag='Y' AND govt='$govtid'";
	$update_details_result=mysql_query($update_details_query,$DBLink) or die(mysql_error());
	$row1=mysql_fetch_assoc($update_details_result);
	
	$percentval=($row1['updatedOffice']/$row['OfficeCode'])*100;
	
	echo "<tr><td>".$row['govt_description']."</td><td>".$row['OfficeCode']."</td><td>".$row1['updatedOffice']."</td><td><span class=\"badge bg-light-blue\">".ceil($percentval)."%</span></td><td width='30%'><div class=\"progress progress-xs progress-striped active\"><div class=\"progress-bar progress-bar-success\" style=\"width:".$percentval."%\"></div></div></td></tr>";
	$total=$total+$row['OfficeCode'];
	$total_updated=$total_updated+$row1['updatedOffice'];
}
$percentval=($total_updated/$total)*100;
echo "<tr><td><b>Total office</b></td><td><b>".$total."</b></td><td>".$total_updated."</td><td><span class=\"badge bg-light-blue\">".ceil($percentval)."%</span></td><td><div class=\"progress progress-xs progress-striped active\"><div class=\"progress-bar progress-bar-success\" style=\"width:".$percentval."%\"></div></div></td></tr>";
?>
</table>
</div><!-- /.box-body -->
<div class="box-footer text-center">
showing number of total offices and the number of offices already updated in this subdivision.
            </div><!-- /.box-footer -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->   