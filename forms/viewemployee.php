<?php
session_start();
include("../config/config.php");
$userid=$_SESSION['UserID'];
$mq="SELECT MID(UserID,1,3) AS sub_div_3 FROM userlogin WHERE UserID='$userid'";
$mq1=mysql_query($mq,$DBLink) or die(mysql_error());
$mq1=mysql_fetch_assoc($mq1);
if($mq1['sub_div_3']=='130')
$userid=$_SESSION['UserID'];
else
$userid=$_POST['OfficeCode'];
?>
<script type="text/javascript">
$('document').ready(function(){
	
	$('.view-employee').click(function(){
			var emp_id=($(this).attr("id"));
			//alert(emp_id);	
			$.getScript("js/personnel.js");
			LoadPersonnelDetailsForm(emp_id);
	});
	
});
</script>
<div class="row">
	<div id="breadcrumb" class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="#">Dashboard</a></li>
			<li><a href="#">Employee</a></li>
			<li><a href="#">View Employee</a></li>
		</ol>
	</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-10">
<div class="box">
  <div class="box-header">
		<div class="box-name">
					<i class="fa fa-search"></i>
					<span> Employee Details</span>
	  </div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
	</div>
            
	<div class="box-content no-padding">
	<table class="table table-bordered table-striped table-hover table-heading table-datatable" id="datatable-1">
					<thead>
						<tr>
							<th>Employee Id</th>
							<th>Employee Name</th>
							<th>Designation</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
<?php
include("../config/config.php");
?>
<?php	
	$get=mysql_query("select personcd,officer_name,off_desg from personnel WHERE officecd=$userid") or die("Could not select");
?>
					<!-- Start: list_row -->
                    <?php
                    while($fetch=mysql_fetch_array($get))
					{
						?>
						<tr>
							<td><?php echo $fetch['personcd'];?></td>
							<td><?php echo $fetch['officer_name'];?></td>
							<td><?php echo $fetch['off_desg'];?></td>
							<td colspan="2"><div class="row">
                         
<form class="form-horizontal" role="form">
	  <button type="button" class="btn btn-primary btn-lg btn-label-left view-employee" id="<?php echo $fetch['personcd']; ?>">
					    <span><i class="fa fa-pencil"></i></span>
						View Details 
						<?php
	}
    ?>
	  </button>
</form>
</div>

					<!-- End: list_row -->
					</tbody>
					<tfoot>
					</tfoot>
				</table>
	</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
// Run Datables plugin and create 3 variants of settings
function AllTables(){
	TestTable1();
	TestTable2();
	TestTable3();
	LoadSelect2Script(MakeSelect2);
}
function MakeSelect2(){
	$('select').select2();
	$('.dataTables_filter').each(function(){
		$(this).find('label input[type=text]').attr('placeholder', 'Search By Name');
	});
}
$(document).ready(function() {
	// Load Datatables and run plugin on tables 
	LoadDataTablesScripts(AllTables);
	// Add Drag-n-Drop feature
	WinMove();
});

</script>