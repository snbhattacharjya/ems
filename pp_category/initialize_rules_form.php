<?php
session_start();
?>
<script>

</script>
<div class="row">
	<div class="col-md-12">
    	<div class="box box-solid">
        	<div class="box-header with-border">
    		<h3 class="box-title text-blue"><strong>Personnel Categorization - Initialize Rules</strong>
         	</div><!-- /.box-header -->


	<div class="box-body">
	<div class="row">
    	<div class="col-md-6">
    		<button class="btn btn-danger btn-flat btn-block btn-lg" id="initRules"><i class="fa fa-warning"></i> Initialize Rules</button>
        </div>
        <div class="col-md-6">
            <button class="btn btn-warning btn-flat btn-block btn-lg" id="initPoststat"><i class="fa fa-warning"></i> Initialize Personnel Post Status</button>
        </div>
    </div><!-- End Row 1 -->
    
    <div class="row">
		<div id="report_loader" style="text-align:center; display:none">
            <img src="pp_category/loading_gif_1.gif" width="430" height="260" alt="loading">
        </div>
    </div><!-- End Row 2 -->
    
    <div class="pad"></div>
    
    <div class="row">
    	<div class="col-md-12">
		<div class="panel panel-success"  style="display:none" id="report_panel">
          <div class="panel-heading" id="report_result">Panel Heading</div>
        </div>
        </div>
    </div><!-- End Row 3 -->
    	
	</div><!-- BOX BODY-->
   
	</div><!--BOX-->
	</div><!-- COLUMN-->
</div><!--ROW-->

<script>
$(document).ready(function(){
	$('#initRules').click(function(e) {
        e.preventDefault();
		$('#report_panel').hide();
		$('#report_loader').show();
		$.ajax({
			mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
			url: 'pp_category/initialize_rules.php',
			success: function(data) {
				result=JSON.parse(JSON.stringify(data));
				$('#report_panel').show()
				$('#report_result').html('Records Affected: '+result.Status);
				$('#report_loader').hide();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			},
			dataType: "json",
			async: false
		});
    });
	
	$('#initPoststat').click(function(e) {
        e.preventDefault();
		$('#report_panel').hide();
		$('#report_loader').show();
		$.ajax({
			mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
			url: 'pp_category/initialize_poststat.php',
			success: function(data) {
				result=JSON.parse(JSON.stringify(data));
				$('#report_panel').show();
				$('#report_result').html('Records Affected: '+result.Status);
				$('#report_loader').hide();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			},
			dataType: "json",
			async: false
		});
    });
});
</script>