<?PHP
session_start();
?>
<script src="js/personnel.js"></script>
<script type="text/javascript">
var table;
$(document).ready(function(){	

	if(checkSubdivSession()=="TRUE")
	{
		if(checkOfficeSession()=="TRUE")
		{
			$('#show_office').html("of&nbsp;"+getOfficeNamefromSession());
			$('#div_message').hide();
			$('#show_emp_form').show();
			$('#table_employee').hide();
			table=$('#table_employee').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true
			}); 
			LoadEmployeebyOffice();
		}
		else
		{
			$('#div_message').show();
			$('#div_message').html("<h4>Please Set Office Code first.</h4>");
			$('#show_emp_form').hide();		
		}
	}
	else
	{
		$('#div_message').show();
		$('#div_message').html("<h4>Please Set Subdivision first.</h4>");
		$('#show_emp_form').hide();
	}		
});	



function LoadEmployeebyOffice()
{
	$.ajax({
	mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
	url: 'json/employee_by_office.php',

	success: function(data) {
		var retObj=JSON.parse(JSON.stringify(data));
		table.clear().draw();
		for(var i=0; i<retObj.length; i++)
		{
			table.row.add([retObj[i].PersonCode, retObj[i].OfficerName, retObj[i].Desg, '<a href="#" onclick="DeletePersonnel('+retObj[i].PersonCode+')"><span class="fa fa-trash-o"></span>&nbsp;Delete</a>']).draw();
			//table.row.add(['1', '2', 'Edit', 'Delete']).draw();
			//alert(retObj[i].OfficeCode);
		}
		$('.overlay').hide();
		$('#table_employee').show();
	},
		error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	},
	dataType: "json",
	async: false
	});	
}

	  
</script>
<?php
include("../config/config.php");
?>

<div class="row">
	<div class="col-md-12">
    	 <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Employee Details&nbsp;
                    <span id="show_office">
                    
                    </span>
                    <?PHP
					if(isset($_SESSION['Office']))
                    echo "&nbsp;(".$_SESSION['Office'].")";?>
                </h3> 
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                            
               	<div id="div_message" class="callout callout-danger">												
    			</div>
            
            	<div id="show_emp_form">
                <div class="overlay">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
                  <table id="table_employee" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>EMPLOYEE CODE</th>
                        <th>EMPLOYEE NAME</th>
                        <th>EMPLOYEE DESIGNATION</th>
                        <th>EDIT EMPLOYEE</th>
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