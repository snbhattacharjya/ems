<script>
$(document).ready(function(e) {
   
$('#reset_psd').click(function(e) {
	$.ajax({
	mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
	url: 'php/reset_password.php',
	data:{userid : $('#uid').val()},
	type: 'POST',
	success: function(data) {
		$('#div_message').html("<i class='fa fa-info'></i>&nbsp;&nbsp;&nbsp;&nbsp;"+data);
		$('#div_message').slideDown(500);
	},
		error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	},
	dataType: "html",
	async: false
	});

});
});
</script>
<div class="row">
	<div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">PASSWORD RESET FORM </h3>
            </div>
            <div class="box-body">
                <div id="div_message" class="callout callout-success" hidden="">												
                </div>
                
				<form class="form-horizontal" role="form" id="defaultForm">
                	<div class="form-group">
						<label class="col-sm-4 control-label">Provide UserId</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" placeholder="User Id" data-toggle="tooltip" data-placement="bottom" title="Enter UserId" id="uid" maxlength="10">
						</div>
                    </div>
               	</form>
           	</div>
                
            <div class="box-footer text-center">
                <button type="button" class="btn btn-warning btn-lg" id="reset_psd" ><span><i class="fa fa-save"></i></span>&nbsp;&nbsp;Reset Password</button>
            </div>
            </div><!-- end of box body -->
        </div><!-- end of box -->
    </div>
</div>

