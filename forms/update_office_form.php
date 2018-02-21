<?php
session_start();
if(isset($_SESSION['Office']))
$officeid=$_SESSION['Office'];
else
die("Cannot connet to the server");
require("../config/config.php");

$district_details_query="SELECT dist_cd, distnm_cap FROM environment";
$district_details_result=mysql_query($district_details_query,$DBLink) or die(mysql_error());
$result=mysql_fetch_assoc($district_details_result);
?>

<div class="row">
	<div class="col-md-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h3 class="box-title">UPDATE OFFICE FORM for OFFICE CODE&nbsp;  
                <span id="office_subdiv"><?php echo $officeid; ?></span>
                </h3>              
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->


			<div class="box-body">
                
          <form class="form-horizontal" role="form" id="add_office_form">            
            <div id="office_form">
            	<div class="callout bg-success">												
                	<i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;BASIC DETAILS
            	</div>        

         <div class="form-group" id="div_OfficeName">
						<label class="col-sm-4 control-label">Office Name</label>
						<div class="col-sm-5">
							<input type="text" class="form-control check-required" placeholder="Office Name" data-toggle="tooltip" data-placement="bottom" title="Enter Office Name" id="OfficeName" name="OfficeName" maxlength="50">
						</div>
           </div>
           
           <div class="form-group" id="div_OfficeId">
						<label class="col-sm-4 control-label">Unique ID for Office (eg. DDO code/IFSC (for Bank)/DISE Code for School/Kanyashree ID (for college)/Branch Code(for Insurance Company) etc.</label>
						<div class="col-sm-5">
							<input type="text" class="form-control check-required" placeholder="Office Id" data-toggle="tooltip" data-placement="bottom" title="Enter Office Id" id="OfficeId" name="OfficeId">
						</div>
           </div>
           
                        <div class="form-group" id="div_Designation">
						<label class="col-sm-4 control-label">Designation of Officer-in-charge</label>
						<div class="col-sm-5">
							<input type="text" class="form-control check-required" placeholder="Designation of office-in-charge" data-toggle="tooltip" data-placement="bottom" title="Enter Designation Of Office-in-charge" id="Designation" name="Designation">
                          </div>
					</div>
</div>
          <div class="callout bg-success">												
            <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;OFFICE ADDRESS
          </div>

<div id="OfficeAddress">
       
        	<div class="form-group" id="div_Street">
			  <label class="col-sm-4 control-label">Para/Tola/Street</label>
			  <div class="col-sm-5">
				   <input type="text" class="form-control check-required" placeholder="Para/Tola/Street" data-toggle="tooltip" data-placement="bottom" title="Enter Para/Tola/Street" id="Street" name="Street">
              </div>
          </div>
                    <div class="form-group" id="div_Town">
						<label class="col-sm-4 control-label">Vill/Town/Metro</label>
						<div class="col-sm-5">
							 <input type="text" class="form-control check-required" placeholder="Vill/Town/Metro" data-toggle="tooltip" data-placement="bottom" title="Enter Vill/Town/Metro" id="Town" name="Town">
                      </div>
          </div>
             <div class="form-group" id="div_PostOffice">
						<label class="col-sm-4 control-label">Post Office</label>
						<div class="col-sm-5">
							 <input type="text" class="form-control check-required" placeholder="PostOffice" data-toggle="tooltip" data-placement="bottom" title="Enter Post Office" id="PostOffice" name="PostOffice">
                      </div>
          </div>
              <div class="form-group" id="div_District">
                <label class="col-sm-4 control-label">District</label>
                <div class="col-sm-5">
                <select name="District" id="District" class="form-control" data-toggle="tooltip" data-placement="bottom">
            <option value="<?php echo $result['dist_cd'];?>" selected="selected"><?php echo $result['distnm_cap'];?></option>
          </select>
				</div>
</div>
<div class="form-group" id="div_Municipality">
						<label class="col-sm-4 control-label">Block/Municipality</label>
						<div class="col-sm-5">
					    <select name="Municipality" id="Municipality" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Enter Block/Municipality" >
            <option>Select Block/Municipality Name</option>
          </select>
          	  </div>
</div>
<div class="form-group" id="div_PoliceStation">
						<label class="col-sm-4 control-label">Police Station</label>
						<div class="col-sm-5">
						  <select name="PoliceStation" id="PoliceStation" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Enter Police Station">
            <option>Select Police Station</option>
          </select> 
			  </div>
          </div>
          <div class="form-group" id="div_PinCode">
						<label class="col-sm-4 control-label">Pin Code</label>
						<div class="col-sm-5">
							 <input type="text" class="form-control check-pin" placeholder="Pin Code" data-toggle="tooltip" data-placement="bottom" title="Enter Pin Code" id="PinCode" name="PinCode" maxlength="6">
              </div>
          </div>
          <div class="form-group" id="div_StatusOfOffice">
						<label class="col-sm-4 control-label">Office Catagory</label>
						<div class="col-sm-5">
					    <select name="StatusOfOffice" id="StatusOfOffice" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Enter Status Of Office">
            <option>Select Status Of Office</option>
          </select>
          	  </div>
</div>
<div class="form-group" id="div_pc_dtls">
						<label class="col-sm-4 control-label">Office Parliament Code</label>
						<div class="col-sm-5">
					    <select name="pc_dtls" id="pc_dtls" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Enter Office Parliament Code">
            <option>Select Office Parliament Code</option>
          </select>
          	  </div>
</div>
     <div class="form-group" id="div_Assembly_dtls">
						<label class="col-sm-4 control-label">Office Assembly Code</label>
						<div class="col-sm-5">
					    <select name="Assembly_dtls" id="Assembly_dtls" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Enter Office Assembly Code">
            <option>Office Assembly Code</option>
          </select>
          	  </div>
</div>
     <div class="form-group" id="div_NatureOfOffice">
						<label class="col-sm-4 control-label">Nature Of Office</label>
						<div class="col-sm-5">
					    <select name="NatureOfOffice" id="NatureOfOffice" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Enter Nature Of Office">
            <option>Select Nature Of Office</option>
          </select>
          	  </div>
</div>
</div>
          <div class="callout bg-success">												
            <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;CONTACT DETAILS
          </div>               

<div id="OfficeContactDetails">

<div class="form-group" id="div_EmailId">
						<label class="col-sm-4 control-label">Email ID</label>
						<div class="col-sm-5">
							 <input type="text" class="form-control check-mail" placeholder="Email Id" name="EmailId" id="EmailId" data-toggle="tooltip" data-placement="bottom" title="Enter Email Id">
                      </div>
                    </div>
                   <div class="form-group" id="div_PhoneNumber">
						<label class="col-sm-4 control-label">Phone No</label>
						<div class="col-sm-5">
							  <input type="text" class="form-control check-phone" placeholder="Phone Number" name="PhoneNumber" id="PhoneNumber" data-toggle="tooltip" data-placement="bottom" title="Enter Phone Number" maxlength="15">
                     </div>
  </div>
  <div class="form-group" id="div_MobileNumber">
						<label class="col-sm-4 control-label">Mobile Number of Head of Office/Officer-in-Charge</label>
						<div class="col-sm-5">
							   <input type="text" class="form-control check-mobile" placeholder="Mobile Number" name="MobileNumber" id="MobileNumber" data-toggle="tooltip" data-placement="bottom" title="Enter Mobile Number" maxlength="10">
      </div>
</div>
<div class="form-group" id="div_FaxNo">
						<label class="col-sm-4 control-label">FAX No</label>
						<div class="col-sm-5">
							   <input type="text" class="form-control" placeholder="Fax No" name="FaxNo" id="FaxNo" data-toggle="tooltip" data-placement="bottom" title="Enter Fax No" maxlength="15" >
                        </div>
</div>
</div>
          <div class="callout bg-success">												
            <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;OFFICE PERSONNEL DETAILS
          </div>

<div id="OfficePersonnelDetails">

<div class="form-group" id="div_TotalMaleStaffs">
						<label class="col-sm-4 control-label">Total Male Staff</label>
						<div class="col-sm-5">
							   <input type="text" class="form-control emp check-number" placeholder="Total Male Staff" name="TotalMaleStaff" id="TotalMaleStaffs" data-toggle="tooltip" data-placement="bottom" title="Enter Total Male Staff" maxlength="5">
                        </div>
</div>
<div class="form-group" id="div_TotalFemaleStaffs">
						<label class="col-sm-4 control-label">Total Female Staff</label>
						<div class="col-sm-5">
							   <input type="text" class="form-control emp check-number" placeholder="Total Female Staff" name="TotalFemaleStaff" id="TotalFemaleStaffs" data-toggle="tooltip" data-placement="bottom" title="Enter Fax No" maxlength="5">
                        </div>
</div>
<div class="form-group" id="div_TotalNumberofStaffs">
						<label class="col-sm-4 control-label">Total Number of Staff</label>
						<div class="col-sm-5">
							   <input type="text" class="form-control check-total" placeholder="Total Number of Staff" name="TotalNumberofStaff" id="TotalNumberofStaffs" readonly="readonly" data-toggle="tooltip" data-placement="bottom" title="Enter Total Number of Staff" maxlength="6">
      					</div>
</div>
</div>
	   <div class="form-group col-sm-12">
       <div class="callout callout-info">	
			<i class="fa fa-star"></i><b style="color:#000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Certified that the detail information furnished earlier in PP-1 format and also PP-2 format are verified with office record and genuine. Names of all officials have been included in the PP-2 format and no information has been concealed.</b>
        </div>
      	</div>
</form>
</div><!-- /.box-body -->
    <div class="box-footer text-center">
        <button type="button" class="btn btn-success btn-lg" id="confirm"><span><i class="fa fa-save"></i></span>&nbsp;&nbsp;Register</button>
    </div><!-- /.box-footer -->
</div>
</div>
</div>
<!-- Page Modal -->
<div id="pageModal" class="modal modal-warning fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
	<div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Message</h3>
      </div>
      <div class="modal-body">
      	<p id="error_msg">Error in Page. Please Check the Red Field(/s)</p>
        <p id="warning_msg">Are you sure to submit?</p>
        <h4 id="success_msg"></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" id="ok">Ok</button>
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>
<!-- Page Modal Ends -->
<!-- Message Modal -->
<div id="messageModal" class="modal modal-success fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Message</h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" data-dismiss="modal">Ok</button>
      </div>
    </div>

  </div>
</div>
<!-- Message Modal Ends -->

<script src="js/OfficeSDO.js"></script>
<script>

$(document).ready(function(){
	LoadOfficeDetailsSDOForm();
				$('#pc_dtls').change(function(e) {
            		LoadAssemblyDetailsBypc('Assembly_dtls',$('#pc_dtls').val());
        });
	$('.content').slideDown('slow');
	
	$('#District').select2();
/*
	LoadSubdivisionDetails('subdiv');
	if(checkSubdivSession()=='FALSE')
	{
		$('#box_container').hide();
		showSubdivModal();
	}
	
	
	//$('#District').prop('disabled', true);
	$('#office_subdiv').html(getSubdivNamefromSession());
	$('#District').select2();
	LoadPoliceStationBySubdiv('PoliceStation');
	LoadBlockMuniBySubdiv('Municipality');
	
	LoadGovtCattegoryDetails('StatusOfOffice');
	LoadNatureDetails('NatureOfOffice');
*/

	$('.emp').change(function(e) {
			var TotalMaleStaffs= $('#TotalMaleStaffs').val();
			var TotalFemaleStaffs= $('#TotalFemaleStaffs').val();
        $('#TotalNumberofStaffs').val(+TotalMaleStaffs + +TotalFemaleStaffs);
    });
	
	//$('.content').slideDown('slow');
	//$('#District').prop('disabled', true);
	
		$('#confirm').attr('data-toggle', 'modal');
		$('#confirm').attr('data-target', '#pageModal');

	$("#confirm").click(function(){
		
		if(validateForm('add_office_form'))
		{
			$('#pageModal').removeClass('modal-danger').removeClass('modal-success').addClass('modal-warning');
			$('#warning_msg').show();
			$('#error_msg').hide();
			$('#success_msg').hide();
			$('.modal-footer').show();
		}
		else
		{
			$('#pageModal').removeClass('modal-warning').removeClass('modal-success').addClass('modal-danger');
			$('#warning_msg').hide();
			$('#error_msg').show();
			$('#success_msg').hide();
			$('.modal-footer').hide();		
		}
	});
	
	
	$("#ok").click(function(){

	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/office_update.php',
		type: 'POST',
		data: {
			OfficeName: $('#OfficeName').val(),
			OfficeId: $('#OfficeId').val(),
			Designation: $('#Designation').val(),
			Street: $('#Street').val(),
			Town: $('#Town').val(), 
			PostOffice: $('#PostOffice').val(),
			PoliceStation: $('#PoliceStation').val(),
			Municipality: $('#Municipality').val(),
			District: $('#District').val(),
			PinCode: $('#PinCode').val(),
			pc_dtls:$('#pc_dtls').val(),
			Assembly_dtls:$('#Assembly_dtls').val(),
			Statusofoffice: $('#StatusOfOffice').val(),
			NatureOfOffice: $('#NatureOfOffice').val(),
			EmailId: $('#EmailId').val(),
			PhoneNumber: $('#PhoneNumber').val(),
			MobileNumber: $('#MobileNumber').val(),
			FaxNo: $('#FaxNo').val(),
			TotalMaleStaffs: $('#TotalMaleStaffs').val(),
			TotalFemaleStaffs: $('#TotalFemaleStaffs').val(),
			TotalNumberOfStaffs: $('#TotalNumberofStaffs').val(),
				
		},
		
		success: function(data) {
			$('#pageModal').removeClass('modal-warning').addClass('modal-success');
			$('.modal-footer').hide();
			$('#warning_msg').hide();
			$('#success_msg').show();
			$('#success_msg').html(data);
			//LoadSuccessModal(data);
			//$('#box_container').show();
			//alert(data);
			//$('#box_container').empty();
		  	//	LoadAjaxContent('forms/Add_office_form.php');
		
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


function showMessageModal(message)
{
	$('#messageModal').find('.modal-body').html(message);
	$('#messageModal').modal('show');
	//$('#content').load('forms/Add_office_form.php');
}



function showSubdivModal()
{
	$('#subdivModal').modal('show');
	$('#box_container').hide();
}
/*	
function setSubdivSession()
{
	$.ajax({
	mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
	url: 'php/set_subdiv_session.php',
	type: 'POST',
	data: {subdiv: $('#subdiv').val()},
	success: function(data) {
		//$('#office_subdiv').html($('#subdiv').val());
		$('#office_subdiv').html(getSubdivNamefromSession());
		$('#box_container').show();
		LoadPoliceStationBySubdiv('PoliceStation');
		LoadBlockMuniBySubdiv('Municipality');
	},
		error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	},
	dataType: "html",
	async: false
});
}
*/
</script>