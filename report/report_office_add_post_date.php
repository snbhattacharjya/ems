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
if(isset($_POST['date']))
{
$date=$_POST['date'];
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
<tr><th>Office Code </th><th>Office Name</th><th>Designation of Office-in-charge</th><th>Contact Number</th></tr>
</thead>
<tbody>
<?php
$query_get_office=mysql_query("SELECT office.officecd,office.officer_desg,office.office,office.phone,office.mobile FROM office inner join users on office.officecd=users.UserID WHERE office.subdivisioncd=$subdiv and office.posted_date>='$date' and users.ChangePassword=1",$DBLink) or die(mysql_error());

	while($res=mysql_fetch_assoc($query_get_office))
	{
?>
<tr>
<td><?php echo $office=$res['officecd']?></td>
<td><?php echo $res['office'];?></td>
<td><?php echo $res['officer_desg'];?></td>
<td><?php echo $res['phone']." / ".$res['mobile'];?></td>
</tr>
<?php
	}
?>
</tbody>
</table>
</div><!-- /.box-body -->
<div class="box-footer text-center">
Showing offices added after <?php echo $date; ?>.
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