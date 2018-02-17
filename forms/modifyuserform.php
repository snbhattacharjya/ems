<?php
session_start();
$userid=$_SESSION['UserID'];
include("../config/config.php");
?>
<script type="text/javascript" language="javascript" src="js/validate.js">
</script>
<script type="text/javascript" language="javascript" src="js/usertype.js">
</script>
<script type="text/javascript" language="javascript" src="js/Subdivision.js">
</script>
<script>

$('document').ready(function(){
	LoadUserDetailsForm();
	$('#Modify').click(function(){
	LoadModifyUser();	
	LoadAjaxContent('forms/adduserform.php');
});
});
function LoadUserDetailsForm()
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/users_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Office Update Form*/
			$('#UserName').val(retObj.UserName);
			$('#Designation').val(retObj.Designation);
			$('#EmailId').val(retObj.Email);
			$('#MobileNumber').val(retObj.Mobile);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}
function LoadModifyUser(){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/updateuser.php',
		type: 'POST',
		
		data: {
			UserName: $('#UserName').val(),
			Designation: $('#Designation').val(),
			EmailId: $('#EmailId').val(),
			MobileNumber: $('#MobileNumber').val(),
							
		},
		
		success: function(data) {
			$('#Modify').prop('disabled',true);
		  alert(data);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(jqXHR);
			//alert(errorThrown);
			alert("Secure update Error");
		},
		dataType: "html",
		async: false
	});
	}
</script>
<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<ol class="breadcrumb">
			<li><a href="index.html">Home</a></li>
			<li><a href="#">Login</a></li>
            <li><a href="forms/modifyuserform.php">ModifyUser</a></li>
		</ol>
	</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-8">
	<div class="box">
    <div class="box-header">
				<div class="box-name">
					<i class="fa fa-search"></i>
					<span>Modefy User Form</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
				</div>
				<div class="no-move"></div>
	  </div>
     <div class="box-content">
<form class="form-horizontal" role="form" id="AddUser" name="AddUser">
         <div class="form-group">
           <div class="col-sm-6"></div>
  </div>
          
          <div class="form-group" id="Subdivision">
            <div class="col-sm-5"></div>
  </div>
           <div class="form-group">
						<label class="col-sm-4 control-label">User Name</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" placeholder="User Name" data-toggle="tooltip" data-placement="bottom" title="Enter User Name" id="UserName" onblur="blankcheck(UserName);" name="UserName">
             </div>
  </div>
           <div class="form-group">
			 <label class="col-sm-4 control-label">Designation</label>
						<div class="col-sm-5">
			<input type="text" class="form-control" placeholder="Designation" data-toggle="tooltip" data-placement="bottom" title="Enter Designation" id="Designation" onblur="blankcheck(Designation);numbercheck(Designation);" name="Designation">
             </div>
		   </div>
                   <div class="form-group">
				<label class="col-sm-4 control-label">Email ID</label>
				<div class="col-sm-5">
		<input type="text" class="form-control" placeholder="Email Id" name="EmailId" id="EmailId" data-toggle="tooltip" data-placement="bottom" title="Enter Email Id" onblur="emailaddresscheck(EmailId)"/>
                     </div>
           </div> 
                    <div class="form-group">
						<label class="col-sm-4 control-label">Mobile No</label>
						<div class="col-sm-3">
							   <input type="text" class="form-control" placeholder="Mobile Number" name="MobileNumber" id="MobileNumber" data-toggle="tooltip" data-placement="bottom" title="Enter Mobile Number" maxlength="10" onblur="blankcheck(MobileNumber);chactercheck(MobileNumber);spacialchactercheck(MobileNumber);">
      </div>

</div>  
 <div class="form-group" id="animateuserid">
   <div class="col-sm-5" id="autoGenUserID"></div>
 <div class="col-sm-5" id="autoGenPass"></div>
 </div>
</form>
       <div>
        <div>
<form class="form-horizontal" role="form">
  <button type="button" class="btn btn-primary btn-lg btn-label-left" id="Modify"><span><i class="fa fa-save"></i></span>Modify</button></form>
  </div>
</div>
</div>    