<?PHP
session_start();
?>
<script>
$("#submit").click(function(e) {
	var p=$("#p").val();
	var p1=$("#p1").val();
	var p2=$("#p2").val();
	if(p=="")
	{
		$("#div_p").addClass("has-error");
		$("#p").focus();
		return false;	
	}
	else
	{
		$("#div_p").removeClass("has-error").addClass("has-success");	
	}
	if(p1=="")
	{
		$("#div_p1").addClass("has-error");
		$("#p1").focus();
		return false;	
	}
	else
	{
		$("#div_p1").removeClass("has-error").addClass("has-success");	
	}
	if(p2=="")
	{
		$("#div_p2").addClass("has-error");
		$("#p2").focus();
		return false;
	}
	else
	{
		$("#div_p2").removeClass("has-error").addClass("has-success");		
	}
	if(p1!=p2)
	{
		$("#div_p1").addClass("has-error");
		$("#div_p2").addClass("has-error");
		alert("Passwords Do Not Match!!!!");
		return false;
	}
	else
	{
		$("#div_p1").removeClass("has-error").addClass("has-success");	
		$("#div_p2").removeClass("has-error").addClass("has-success");	
	}
	if(p!=p1)
	{
		$("#div_p").removeClass("has-error").addClass("has-success");
		$("#div_p1").removeClass("has-error").addClass("has-success");	
		$("#div_p2").removeClass("has-error").addClass("has-success");	
	}
	else
	{
		$("#div_p").addClass("has-error");
		$("#div_p2").addClass("has-error");
		$("#div_p1").addClass("has-error");
		alert("Same Password Provided!!!!");
		return false;
	}

	
	$.ajax({
		url: "security/submit_password.php",
		type: 'POST',
		data: {
			Password: p,
			NewPassword:p1
		},
		success: function(data) {
			$('#defaultForm').html(data+"<br><h3 class=\"text-center\" style=\"color:#C30\">After Login With New Password, Please click on download link(left side span) and Download the README file. Read it First carefully and then proceed accordingly</h3><br><h3 class=\"text-center\"><a href=\"index.php\">Login</a></h3>");
			$('#submit').hide();
		},
		error: function () {
			alert("ERROR OCCURED!!!");
			$('#submit').hide();
		}
	});
});
</script>
<div class="wrapper">
   <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo" style="color:">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>E</b>MS</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="img/india-ashoka-emblem.gif" alt="Logo" height="40" width="40" class=" text-left">
          
          <b>EMS</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
        </nav>
      </header>

<section class="content" style="min-height:750px;">
<div class="row">
	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
                  <h3 class="box-title">CHANGE PASSWORD TO CONTINUE</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->


			<div class="box-body">
				
                <form class="form-horizontal" role="form" id="defaultForm">
                	<div class="form-group" id="div_p">
						<label class="col-sm-4 control-label">Existing Password</label>
						<div class="col-sm-5">
							<input type="password" id="p" class="form-control" placeholder="Password" data-toggle="tooltip" data-placement="bottom" title="Provide Existing Password">
						</div>
                    </div>
					<div class="form-group" id="div_p1">
						<label class="col-sm-4 control-label">New Password</label>
						<div class="col-sm-5">
							<input type="password" id="p1" class="form-control" placeholder="New Password" data-toggle="tooltip" data-placement="bottom" title="Provide New Password">
						</div>
                    </div>
                    <div class="form-group" id="div_p2">
						<label class="col-sm-4 control-label">Retype Password</label>
						<div class="col-sm-5">
							<input type="password" class="form-control" id="p2" placeholder="Retype Password" data-toggle="tooltip" data-placement="bottom" title="Retype Password">
						</div>
                    </div>
                 </form>
                
            </div><!-- /.box-body -->
            <div class="box-footer text-center">
            	<button type="button" class="btn btn-primary btn-lg" id="submit">Submit</button>
            </div><!-- /.box-footer -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.wrapper -->