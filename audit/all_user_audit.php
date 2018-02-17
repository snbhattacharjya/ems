<?PHP
session_start();
?>
<script type="text/javascript">
var table;
$(document).ready(function(){	

	
	table=$('#table_application_audit').DataTable({
	"lengthChange": true,
	"searching": true,
	"info": true,
	"autoWidth": true
	}); 
	LoadApplicationAudit();
});	



function LoadApplicationAudit()
{
		var retObj=getAllUserAudit();
		table.clear().draw();
		for(var i=0; i<retObj.length; i++)
		{
			var user_details=retObj[i].UserName+", "+retObj[i].Designation;
			table.row.add([retObj[i].UserID, user_details, retObj[i].ObjectID, retObj[i].ObjectActivity, retObj[i].RequestIP, retObj[i].SessionID, retObj[i].ActivityTimeStamp]).draw();
			//table.row.add(['1', '2', 'Edit', 'Delete']).draw();
			//alert(retObj[i].OfficeCode);
		}
		$('#table_employee').show();
}

	  
</script>
<div class="row">
	<div class="col-md-12">
    	 <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">
                  <i class="fa fa-th-large"></i>
                  All User Application Audit
                </h3> 
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="table_application_audit" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>User ID</th>
                        <th>User Details</th>
                        <th>Object ID</th>
                        <th>Object Activity</th>
                        <th>Remote IP Address</th>
                        <th>Session ID</th>
                        <th>Activity Timestamp</th>
                      </tr>
                    </thead>

                    <tfoot>

                    </tfoot>
                  </table>
                  </div>
        	</div><!-- /.box-body -->
       	</div><!-- /.box -->
   	</div><!-- /.col -->
</div><!-- /.row -->