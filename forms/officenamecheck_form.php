<?php
session_start();
?>
<script src="js/Office.js" type="text/javascript">
</script>
<script src="js/validate.js" type="text/javascript">
</script>
<div id="accordian">
<div class="row">
  <div id="breadcrumb" class="col-xs-12">
		<ol class="breadcrumb">
			<li><a href="dashboard/deo_sdo_dashboard.php" class="ajax-link">Home</a></li>
		  <li><a href="forms/officenamecheck_form.php">Office Name</a></li>
		</ol>
  </div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-10">
	<div class="box">
    <div class="box-header">
				<div class="box-name">
					<i class="fa fa-search"></i>
					<span>Office Details</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<img src="icon/up.png"></img>
					</a>
					<a class="expand-link">
						<img src="icon/expand.png"></img>
					</a>
				</div>
				<div class="no-move"></div>
	  </div>
      <div class="box-content">
      <form class="form-horizontal" role="form">
         <div class="form-group">
						<label class="col-sm-4 control-label">Office Name</label>
						<div class="col-sm-8">
						<select name="OfficeName" id="OfficeName" class="populate placeholder" data-toggle="tooltip" data-placement="bottom" title="Select Office Name" onchange="blankcheck(OfficeName);">
						    <option>Select Office Name</option>
					      </select>
						</div>
                        
        </div>
        <div class="col-sm-5" id="showofficecode">
         
	    </div>
      </form>   
    <div>        
       <form class="form-horizontal" role="form">
    <button type="button" class="btn btn-primary btn-lg btn-label-left" id="next"><span><i class="fa fa-save"></i></span>ADD EMPLOYEE</button>    
    <button type="button" class="btn btn-primary btn-lg btn-label-left" id="next1"><span><i class="fa fa-save"></i></span>VIEW EMPLOYEE</button></form>
</div>
<script>
var officecd;
$(document).ready(function(e) {
	$.ajax({
		url: 'json/subdivision_wise_office_details.php',
		type: 'POST',
		data: {
		},
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			for(var i=0;i<retObj.length;i++)
			{
			$('#OfficeName').append( "<option value='"+retObj[i].OfficeCode+"'>"+retObj[i].OfficeCode+ "-" + retObj[i].Office + "</option>");
			}
			$.getScript('plugins/select2/select2.min.js');
			$('#OfficeName').select2();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Secure insert Error");
		},
		dataType: "json",
		async: false
		});
$('#next').click(function(){
officecd=$("#OfficeName").val();	
 $.ajax({
		url: 'php/addemployee.php',
		type: 'POST',
		data: { OfficeCode: officecd
		},
		success: function(data) {
			$("#ajax-content").html(data);
			LoadEmployeeDetails();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Secure insert Error");
		},
		dataType: "html",
		async: false
		});
	});
	$('#next1').click(function(){
   officecd=$("#OfficeName").val();	
 $.ajax({
		url: 'forms/viewemployee.php',
		type: 'POST',
		data: { OfficeCode: officecd
		},
		success: function(data) {
			$("#ajax-content").html(data);
			LoadEmployeeDetails();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Secure insert Error");
		},
		dataType: "html",
		async: false
		});
	});
});
$('#EmpButton').html('<span><i class="fa fa-save"></i></span>Update');
</script>