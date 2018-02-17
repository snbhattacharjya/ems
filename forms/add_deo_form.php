<?php
session_start();
include("../config/config.php");
?>

<script>
$(document).ready(function(e) {
	
	
	if(checkSubdivSession()=="TRUE")
	{
		$('#show_subdiv').html("for SUBDIVISION&nbsp;"+getSubdivNamefromSession());
		$('#div_message').hide();
		$('#AddDeo_form').show();
		$('#animateuserid').hide();
		$('#animatepass').hide();
		$('#Register').show();
	}
	else
	{
		$('#div_message').show();
		$('#div_message').html("<h4>Please Set Subdivision first.</h4>");
		$('#AddDeo_form').hide();
		$('#Register').hide();
	}

});  
$('#Register').click(function(){
	if(validateForm('AddDeo_form')){
	LoadAddUser('DEO');
	$('#animateuserid').show('blind',500);
	$('#animatepass').show('blind',700);
	$('#Register').prop('disabled', true);
	}
});
</script>
<div class="row">

	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h3 class="box-title">ADD DEO FORM 
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
            
<form class="form-horizontal" role="form" id="AddDeo_form" name="AddDeo_form">
         <div class="form-group" id="div_SelectUserType">
						<label class="col-sm-4 control-label">User Type</label>
						<div class="col-sm-5">
						<input type="text" disabled class="form-control" data-toggle="tooltip" data-placement="bottom" title="User Type" value="Data Entry Operator">
						</div>
  		</div>

           <div class="form-group" id="div_UserName">
						<label class="col-sm-4 control-label">User Name</label>
						<div class="col-sm-5">
							<input type="text" class="form-control check-string" placeholder="User Name" data-toggle="tooltip" data-placement="bottom" title="Enter User Name" id="UserName">
             </div>
  			</div>
           <div class="form-group" id="div_Designation">
			 <label class="col-sm-4 control-label">Designation</label>
						<div class="col-sm-5">
			<input type="text" class="form-control check-required" placeholder="Designation" data-toggle="tooltip" data-placement="bottom" title="Enter Designation" id="Designation">
             </div>
		   </div>
                <div class="form-group" id="div_EmailId">
				<label class="col-sm-4 control-label">Email ID</label>
				<div class="col-sm-5">
		<input type="text" class="form-control check-mail" placeholder="Email Id" name="EmailId" id="EmailId" data-toggle="tooltip" data-placement="bottom" title="Enter Email Id"/>
                     </div>
           </div> 
                    <div class="form-group" id="div_MobileNumber">
						<label class="col-sm-4 control-label">Mobile No</label>
						<div class="col-sm-5">
							   <input type="text" class="form-control check-mobile" placeholder="Mobile Number" name="MobileNumber" id="MobileNumber" data-toggle="tooltip" data-placement="bottom" title="Enter Mobile Number" maxlength="10"/>
      </div>
</div>  
 <div class="form-group" id="animateuserid">
      <label class="col-sm-4 control-label">User ID</label>
  <div class="col-sm-5" id="autoGenUserID">
  </div>
    </div>
    <div class="form-group" id="animatepass">
      <label class="col-sm-4 control-label">Auto Generated Password</label>
  <div class="col-sm-5" id="autoGenPass">
  </div>
</form>
</div><!-- /.box-body -->
            <div class="box-footer text-center">
            	<button type="button" class="btn btn-warning btn-lg" id="Register"><span><i class="fa fa-save"></i></span>&nbsp;&nbsp;Register</button>
            </div><!-- /.box-footer -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->   