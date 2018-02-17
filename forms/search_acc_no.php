<script>
$(document).ready(function(e) {

	$("#search").click(function(){
	
	if($('#accno').val()=="")
	{
		alert('Please provide account number');
		return false;	
	}
	
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/search_by_accno.php',
		type: 'POST',
		data: {
			accno: $('#accno').val()
				
		},
		
		success: function(data) {

			$('#result_div').html(data);
			//LoadSuccessModal(data);
			//$('#box_container').show();
			//alert(data);
			//$('#box_container').empty();
		  	//	LoadAjaxContent('forms/Add_office_form.php');
			$(document).find('input').each(function() {
                $(this).val("");
            });		
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(jqXHR);
			//alert(errorThrown);
			alert("Secure update Error");
		},
		dataType: "html",
		async: false
	});
	
});




});
</script>

<div class="row">
	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h3 class="box-title">SEARCH ACCOUNT NUMBER   
                </h3>              
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->
            
<div class="box-body">

            
<form class="form-horizontal" role="form" id="AddSdo_form" name="AddSdo_form">

    <div class="form-group">
        <label class="col-sm-4 control-label">Provide Account Number</label>
        <div class="col-sm-5">
               <input type="text" class="form-control check-mobile" placeholder="Account Number" name="accno" id="accno" data-toggle="tooltip" data-placement="bottom" title="Enter Account Number" maxlength="25"/>
    	</div>
    </div>  

</form>
</div><!-- /.box-body -->
    <div class="box-footer text-center">
        <button type="button" class="btn btn-success btn-lg" id="search"><span><i class="fa fa-search"></i></span>&nbsp;&nbsp;Search</button>
    </div><!-- /.box-footer -->
</div>

<div id="result_div">

</div>
</div>
</div>
