<?php
session_start();
require("../config/config.php");
?>
<script>
$(document).ready(function(e) {
	var table;
	
});

</script>
<div class="row">

	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h3 class="box-title">Office Summary 
                </h3>              
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->



			<div class="box-body">
    

<div class="pad"></div>
    
<table class="table table-bordered table-condensed small" id="pp2_table">
<thead>
<tr class="warning">
    <th>#</th>
    <th>Subdivision Name</th>
    <th>Office Count</th>
    <th>Office List</th>
    <th>Initimation Letter</th>
    <th>PP1 Progress</th>
    <th>PP2 Progress</th>
    <th>Pending</th>
</tr>
</thead>
<tbody>
<?php
$user_id=$_SESSION['UserID'];
$block_code=substr($user_id,3,6);

if(substr($user_id,0,3) == 'BDO'){
	$query_get_office=mysql_query("SELECT office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.phone, office.mobile, office.tot_staff AS pp1_count, COUNT(personcd) AS pp2_count FROM ((office INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) LEFT JOIN personnel ON office.officecd=personnel.officecd WHERE office.subdivisioncd='$subdiv' AND office.blockormuni_cd='$block_code' GROUP BY office.officecd, office.office, office.officer_desg, office.address1, office.address2, office.postoffice, office.pin, office.phone, office.mobile, office.tot_staff ORDER BY office.tot_staff - COUNT(personcd) DESC",$DBLink) or die(mysql_error());
}
else{
	$query_get_office=mysql_query("SELECT office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.phone, office.mobile, office.tot_staff AS pp1_count, COUNT(personcd) AS pp2_count FROM ((office INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) LEFT JOIN personnel ON office.officecd=personnel.officecd WHERE office.subdivisioncd='$subdiv' GROUP BY office.officecd, office.office, office.officer_desg, office.address1, office.address2, office.postoffice, office.pin, office.phone, office.mobile, office.tot_staff ORDER BY office.tot_staff - COUNT(personcd) DESC",$DBLink) or die(mysql_error());
}
$count=0;
$total_pp1=0;
$total_pp2=0;
	while($res=mysql_fetch_assoc($query_get_office))
	{
		$count=$count+1;
?>
<tr>
<td><?php echo $office=$res['officecd']?></td>
<td><?php echo $res['office'];?></td>
<td><?php echo $res['officer_desg'];?></td>
<td><?php echo $res['address1'].', '.$res['address2'].'; <strong>Block/Muni</strong> - '.$res['blockmuni'].'; <strong>P.S. </strong>- '.$res['policestation'].'; <strong>PO: </strong>'.$res['postoffice'].'; <strong>Pin </strong>- '.$res['pin'];?></td>
<td>
<?php echo $res['phone']." / ".$res['mobile']; ?></td>
<?php
		
	$total_pp1=$total_pp1+$res['pp1_count'];
	
	$total_pp2=$total_pp2+$res['pp2_count'];
			
?>
<td><?php echo $res['pp1_count']; ?></td>
<td><?php echo $res['pp2_count']; ?></td>
<td><?php echo $res['pp1_count'] - $res['pp2_count']; ?></td>
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
    <th><?php echo $total_pp2;?></th>
    <th><?php echo $total_pp1 - $total_pp2;?></th>
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