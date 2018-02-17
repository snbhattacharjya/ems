<?PHP
session_start();
?>
<script>
$(document).ready(function(){

	if(checkSubdivSession()=="TRUE")
	{
		$('#div_message').hide();
		$('#select_office').show();
		//alert(checkOfficeSession());
		if(checkOfficeSession()=="TRUE")
		{
		//alert(getOfficeNamefromSession());
			$("#callout_office").show();
			$('#show_office').html(getOfficeNamefromSession());
		}
		else
		{
			$("#callout_office").hide();
	
		}
		LoadSubdivWiseOfficeDetails('office');
	}
	else
	{
		$('#div_message').show();
		$('#select_office').hide();
	}
	
	$('#save').click(function(e) {
        save_office_in_session($('#office').val());
		$("#callout_office").show();
		$("#show_office_code").html($("#office").val());
		$('#show_office').html(getOfficeNamefromSession());
    });
	
	$('#clear').click(function(e) {
	clear_office_from_session();
	$("#callout_office").hide();
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
         	<div id="div_message" class="callout callout-danger" hidden="">												
         	<h4><i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;Please Select SubDivision first.</h4>
        	</div>
         <!--set office parameter-->
         <div id="select_office">
         <div id="callout_office" class="alert bg-orange" hidden="">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>
        <?php echo "SELECTED OFFICE:&nbsp;";
		?>
        <span id="show_office_code">
        <?PHP
		echo $_SESSION['Office']."&nbsp";?>
        </span>
        </h4>
        <div id="show_office">
		
		</div>
        </div>
         <div class="callout bg-teal">												
            		<h4><i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;SET OFFICE CODE</h4>
          		</div>
         <form class="form-horizontal" role="form"> 
         <div class="form-group" id="div_OfficeName">
						<label class="col-sm-3 control-label">Select Office</label>
						<div class="col-sm-5">
							<select id="office" class="form-control">
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