<?php
session_start();
include("../config/config.php");
?>

<script>
$(document).ready(function(e) {
	
	$('#load_report_form').empty();
	if(checkSubdivSession()=="TRUE")
	{
		$('#show_subdiv').html("for SUBDIVISION&nbsp;"+getSubdivNamefromSession());
		$('#div_message').hide();
		$('#enterdate_form').show();
		$('#Register').show();
	}
	else
	{
		$('#div_message').show();
		$('#div_message').html("<h4>Please Set Subdivision first.</h4>");
		$('#enterdate_form').hide();
		$('#Register').hide();
	}

});  
$('#Register').click(function(){
	$('#load_report_form').empty();
	if($('#date').val()==null){
		alert('Please enter date in correct format');
		return false;
	}
	if($('#date').val().length!=10){
		alert('Please enter date in correct format');
		return false;
	}
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'report/report_office_add_post_date.php',
		type: 'POST',
		data:{date:$('#date').val()},
		success: function(data) {
			$('#load_report_form').html(data);
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "html",
		async: false
	});
});
</script>
<div class="row">

	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h3 class="box-title">Reports of PP1 Add 
                <span id="show_subdiv">
                </span>
        		<?PHP 
				if(isset($_SESSION['Subdiv']))
				echo "(".$_SESSION['Subdiv'].")";
				
				?>
                </h3>              
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->



			<div class="box-body">
            
           	<div id="div_message" class="callout callout-danger" hidden="">												
    		</div>
            
<form class="form-horizontal" role="form" id="enterdate_form" name="enterdate_form">
         <div class="form-group" id="div_SelectUserType">
						<label class="col-sm-4 control-label">Enter Date (Format : YYYY-MM-DD)</label>
						<div class="col-sm-5">
						<input type="text" class="form-control" id="date" data-toggle="tooltip" data-placement="bottom" title="Date" placeholder="yyyy-mm-dd">
						</div>
  		</div>
 
</form>
</div><!-- /.box-body -->
            <div class="box-footer text-center">
            	<button type="button" class="btn btn-warning btn-lg" id="Register"><span><i class="fa fa-save"></i></span>&nbsp;&nbsp;Register</button>
            </div><!-- /.box-footer -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->   
<div id="load_report_form">

</div>