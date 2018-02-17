<?php
session_start();
include("../config/config.php");
?>

<script>
function validation(){
		var usertype=document.getElementById("SelectUserType").options[document.getElementById("SelectUserType").selectedIndex].text;
		var subdivision=document.getElementById("SelectSubdivision").options[document.getElementById("SelectSubdivision").selectedIndex].text;
		var username=document.getElementById("UserName").value;
		var designation=document.getElementById("Designation").value;
		var email=document.getElementById("EmailId").value;
		var mobile=document.getElementById("MobileNumber").value;
		
		if(usertype=="Select User Type"){
		alert("Select User Type");
		$('#div_SelectUserType').removeClass("has-success").addClass("has-error");
		$("#SelectUserType").focus();
		return 0;
		}
		if((usertype=="Deo Sdo") && (subdivision=="Select Subdivision Name")){
		alert("Select Subdivision Name");
		$("#div_SelectSubdivision").removeClass("has-success").addClass('has-error');
		$("#SelectSubdivision").focus();
		return 0;
		}
		else
		{
			$('#div_SelectSubdivision').removeClass("has-error").addClass("has-success");	
		}
		if((usertype=="SDO") && (subdivision=="Select Subdivision Name"))
		{
		alert("Select Subdivision Name");
		$("#div_SelectSubdivision").removeClass("has-success").addClass('has-error');
		$("#SelectSubdivision").focus();
		return 0;	
		}
		else
		{
			$('#div_SelectSubdivision').removeClass("has-error").addClass("has-success");	
		}
		if(username==""){
		alert("Enter User Name");
		$('#div_UserName').removeClass("has-success").addClass('has-error');
		$("#UserName").focus();
		return 0;
		}
		if(designation==""){
		alert("Enter Designation");
		$('#div_Designation').removeClass("has-success").addClass('has-error');
		$("#Designation").focus();
		return 0;
		}
		if(email==""){
		alert("Enter Email Id");
		$('#div_EmailId').removeClass("has-success").addClass('has-error');
		$("#EmailId").focus();
		return 0;
		}
		if(mobile==""){
		alert("Enter Mobile Number");
		$('#div_MobileNumber').removeClass("has-success").addClass('has-error');
		$("#MobileNumber").focus();
		return 0;
		}
		else
		return 1;
	}
</script>
<script>
$(document).ready(function(e) {
	 LoadUserTypeDetails('SelectUserType');
	 LoadSubdivisionDetails('SelectSubdivision');
	 $('#div_SelectSubdivision').hide();
	 $('#SelectUserType').change(function(){
		 
		if($(this).val()=="Select User Type"){
		alert("Select User Type");
		$('#div_SelectUserType').removeClass("has-success").addClass("has-error");
		$("#SelectUserType").focus();
		return 0;
		}
		else
		{
			$('#div_SelectUserType').removeClass("has-error").addClass("has-success");	
		}
		if($(this).val()=='4'){
		  $('#div_SelectSubdivision').show('blind',500);
		}
		else if($(this).val()=='3'){
		  $('#div_SelectSubdivision').show('blind',500);
		}
		else
		{
		  $('#div_SelectSubdivision').hide('blind',500);
		}
	 });
	 $('#animateuserid').hide('blind',500);
	 $('#animatepass').hide('blind',500);
});  
$('#Register').click(function(){
	if(validation()==1){
	LoadAddUser();
	$('#animateuserid').show('blind',500);
	$('#animatepass').show('blind',700);
	$('#Register').prop('disabled', true);
	}
});
</script>
<section class="content-header">
        	<h1>&nbsp;
            </h1>
	<ol class="breadcrumb">
    	<li class="active">ADD USER </li>
	</ol>
</section>

<section class="content">
<div class="callout callout-info" id="timer_div">
           <b>Warning!</b>
          </div>
<div class="row">
	<div class="col-md-12">
    	<div class="box box-warning">
        	<div class="box-header with-border">
                  <h3 class="box-title">ADD USER FORM</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->


			<div class="box-body">
<form class="form-horizontal" role="form" id="AddUser" name="AddUser">
         <div class="form-group" id="div_SelectUserType">
						<label class="col-sm-4 control-label">User Type</label>
						<div class="col-sm-5">
							<select name="SelectUserType" id="SelectUserType" class="form-control" data-toggle="tooltip" title="Select User Type">
            <option value="Select User Type">Select User Type</option>
          </select>
						</div>
  </div>
          
          <div class="form-group" id="div_SelectSubdivision">
			<label class="col-sm-4 control-label">Subdivision Name</label>
				<div class="col-sm-5">
    <select name="SelectSubdivision" id="SelectSubdivision" data-toggle="tooltip" class="form-control" data-placement="bottom" title="Enter Subdivision">
      <option value="Select Subdivision Name">Select Subdivision Name</option>
    </select>
  </div>
  </div>
           <div class="form-group" id="div_UserName">
						<label class="col-sm-4 control-label">User Name</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" placeholder="User Name" data-toggle="tooltip" data-placement="bottom" title="Enter User Name" id="UserName" onblur="blankcheck(UserName);">
             </div>
  </div>
           <div class="form-group" id="div_Designation">
			 <label class="col-sm-4 control-label">Designation</label>
						<div class="col-sm-5">
			<input type="text" class="form-control" placeholder="Designation" data-toggle="tooltip" data-placement="bottom" title="Enter Designation" id="Designation" onblur="blankcheck(Designation);numbercheck(Designation);">
             </div>
		   </div>
                <div class="form-group" id="div_EmailId">
				<label class="col-sm-4 control-label">Email ID</label>
				<div class="col-sm-5">
		<input type="text" class="form-control" placeholder="Email Id" name="EmailId" id="EmailId" data-toggle="tooltip" data-placement="bottom" title="Enter Email Id" onblur="emailaddresscheck(EmailId)"/>
                     </div>
           </div> 
                    <div class="form-group" id="div_MobileNumber">
						<label class="col-sm-4 control-label">Mobile No</label>
						<div class="col-sm-5">
							   <input type="text" class="form-control" placeholder="Mobile Number" name="MobileNumber" id="MobileNumber" data-toggle="tooltip" data-placement="bottom" title="Enter Mobile Number" maxlength="10" onblur="blankcheck(MobileNumber);chactercheck(MobileNumber);spacialchactercheck(MobileNumber);"/>
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
</section><!-- /.content -->       