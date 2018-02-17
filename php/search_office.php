<?PHP
session_start();
?>
<script>
var table;
$(document).ready(function(){	

	if(checkSubdivSession()=="TRUE")
	{
		$('#show_subdiv').html("for SUBDIVISION&nbsp;"+getSubdivNamefromSession());
		$('#div_message').hide();
		$('#show_office_form').show();
		$('#table_office').hide();
		table=$('#table_office').DataTable({
		"paging": true,
	 	"lengthChange": true,
	  	"searching": true,
	  	"ordering": false,
	  	"info": true,
	  	"autoWidth": true
		}); 
		LoadOfficebySubdiv();
	}
	else
	{
		$('#div_message').show();
		$('#div_message').html("<h4>Please Set Subdivision first.</h4>");
		$('#show_office_form').hide();
	}		
});	



function LoadOfficebySubdiv()
{
	$.ajax({
	mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
	url: 'json/office_by_subdiv.php',

	success: function(data) {
		var retObj=JSON.parse(JSON.stringify(data));
		table.clear().draw();
		for(var i=0; i<retObj.length; i++)
		{
			table.row.add([retObj[i].OfficeCode, retObj[i].OfficeName, retObj[i].UniqueID, '<a href="#" class="abcd" onclick="setOfficeSession('+retObj[i].OfficeCode+')"><span class="fa fa-pencil"></span>&nbsp;Edit</a>']).draw();
			//table.row.add(['1', '2', 'Edit', 'Delete']).draw();
			//alert(retObj[i].OfficeCode);
		}
		$('.overlay').hide();
		$('#table_office').show();
	},
		error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	},
	dataType: "json",
	async: false
	});	
}



function setOfficeSession(officecd)
{
	save_office_in_session(officecd);

	$('#page_content').load("forms/update_office_form.php");

}
	  
</script>
<?php
include("../config/config.php");
?>

<div class="row">
	<div class="col-md-12">
    	 <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title">Office Details
                <span id="show_subdiv">
                </span>
        		<?PHP 
				if(isset($_SESSION['Subdiv']))
				echo "(".$_SESSION['Subdiv'].")";
				
				?>
                </h3> 
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                            
               	<div id="div_message" class="callout callout-danger">												
    			</div>
            
            	<div id="show_office_form">
                <div class="overlay">
                  <i class="fa fa-refresh fa-spin"></i>
                </div>
                  <table id="table_office" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>OFFICE CODE</th>
                        <th>OFFICE NAME</th>
                        <th>UNIQUE ID</th>
                        <th>EDIT OFFICE</th>
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