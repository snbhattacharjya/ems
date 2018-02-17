<?php
session_start();
require("../config/config.php");
?>
<script>
	$('.select2').select2();
</script>
<div class="row">

	<div class="col-sm-12">
    	<div class="box box-solid">
        	<div class="box-header with-border">
            	<h3 class="box-title text-red"><strong>Personnel Post Status Reports</strong></h3>              
         	</div><!-- /.box-header -->
			<div class="box-body">
    			<div class="row">
                <form role="form" class="form-horizontal">
                    <div class="from-group">
                        <div class="col-md-3">
                          <label for="report_title" class="pull-right">Report Title:</label>
                        </div>
                        <div class="col-md-6">
                          <select id="report_title" class="form-control select2" style="width: 100%;">
                          	<option value="pp_category/report_govt_post.php">Office Category wise Post Status Distribution</option>
                            <option value="pp_category/report_desg_post.php">Post Status for Designation</option>
                            <option value="pp_category/report_subdiv_post.php">Subdivision wise Post Requirement Availibility Matrix</option>
                            <option value="pp_category/report_subdiv_post_all.php">Subdivision wise Post Allocation</option>
                            <option value="pp_category/report_perm_asm_post_pp.php">Permanent Assembly wise PP Distribution</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                        	<button class="btn btn-primary pull-left" id="reportBtn" type="button">Generate Report</button> 
                        </div>
                    </div>  
                </form>
                </div><!-- End Row 1 -->
                
                <div id="report_loader" style="text-align:center; display:none">
                    <img src="pp_category/loading_gif_1.gif" width="430" height="260" alt="loading">
                </div>
				<div class="margin"></div>
                <div id="report_result">
                
                </div>
                
			</div><!-- /.box-body -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row --> 
<script>
$('#reportBtn').click(function(e) {
	$('#report_result').empty();
	$('#report_loader').show();
    var report_url=$('#report_title').val();
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: report_url,
		success: function(data) {
			$('#report_loader').hide();
			$('#report_result').html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "html",
		async: false
	});
});
</script>  