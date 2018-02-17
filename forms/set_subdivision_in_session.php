<?PHP
session_start();
?>
<script>
$(document).ready(function(){

	if(checkSubdivSession()=="TRUE")
	{
		$("#callout_subdiv").show();
		$('#show_subdiv').html(getSubdivNamefromSession());
	}
	else
	{
		$("#callout_subdiv").hide();
	}
	LoadSubdivisionDetails('subdivision');
	
	$('#save').click(function(e) {
        setSubdivSession($('#subdivision').val());
		$("#callout_subdiv").show();
		$("#show_subdiv_code").html($("#subdivision").val());
		$('#show_subdiv').html(getSubdivNamefromSession());
    });
	$('#clear').click(function(e) {
	clear_subdiv_office_from_session();
	$("#callout_subdiv").hide();
	});
})
</script>
<div class="row">
	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h3 class="box-title">SET PARAMETER FOR FUTURE USE 
                </h3>              
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->
		<div class="box-body">
       
        <!--set subdiv parameter
          		<div class="callout bg-teal">												
            		<i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;SET SUBDIVISION
          		</div>
         <form class="form-horizontal" role="form"> 
         <div class="form-group" id="div_OfficeName">
				<label class="col-sm-4 control-label">Select Subdivision</label>
                <div class="col-sm-4">
					<select id="subdiv" class="form-control">
            		</select>
               	</div>
           </div>
         </form>
         
         -->
         <!--set subdiv parameter-->
         <div id="select_subdiv">
         <div id="callout_subdiv" class="alert bg-gray" hidden="">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>
        <?php echo "SELECTED SUBDIVISION:&nbsp;";
		?>
        <span id="show_subdiv_code">
        <?PHP
		echo $_SESSION['Subdiv']."&nbsp";?>
        </span>
        </h4>
        <div id="show_subdiv">
		
		</div>
        </div>
         <div class="callout bg-warning">												
            		<h4><i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;SET SUBDIVISION CODE</h4>
          		</div>
         <form class="form-horizontal" role="form"> 
         <div class="form-group">
						<label class="col-sm-3 control-label">Select Subdivision</label>
						<div class="col-sm-5">
							<select id="subdivision" class="form-control">
            				</select>
						</div>
                        <div class="col-sm-1">
           				<button type="button" class="btn btn-block btn-success" id="save">&nbsp;&nbsp;<i class="fa fa-save"></i>&nbsp;&nbsp;</button>
                        </div>
                        <div class="col-sm-1">
                        <button type="button" class="btn btn-block btn-warning" id="clear">&nbsp;&nbsp;<i class="fa fa-trash-o"></i>&nbsp;&nbsp;</button>
                        </div>
           </div>
         </form>
         </div>
     </div>
</div>
</div>
</div>