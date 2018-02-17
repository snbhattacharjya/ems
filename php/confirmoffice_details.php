<script>
function confirmOfficeDetails(){
$("#confirm").click(function(){
		$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/insertoffice.php',
		type: 'POST',
		
		data: {
			OfficeName: $('#OfficeName').val(),
			Designation: $('#Designation').val(),
			Street: $('#Street').val(),
			Town: $('#Town').val(), 
			PostOffice: $('#PostOffice').val(),
			Subdivision: $('#Subdivision').val(),
			PoliceStation: $('#PoliceStation').val(),
			Municipality: $('#Municipality').val(),
			District: $('#District').val(),
			PinCode: $('#PinCode').val(),
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
		  alert(data);
		  LoadAjaxContent('dashboard/office_dashboard.php');
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
}
$("#cancel").click(function(){
$.getScript('js/Office.js');
LoadOfficeDetailsForm();
});
</script>
<div class="row">
  <div class="col-xs-12 col-sm-10">
    <div class="box">
      <div class="box-header">
        <div class="box-name"></div>
        <div class="no-move"></div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-10">
    <div class="box">
      <div class="box-header">
        <div class="box-name"> <i class="fa fa-search"></i> <span>Office Details</span> Check Before Final Submission</div>
        <div class="box-icons"> <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a> <a class="expand-link"> <i class="fa fa-expand"></i> </a> </div>
        <div class="no-move"></div>
      </div>
      <div class="box-content" id="OfficeDetails">
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-sm-4 control-label">Office Name</label>
            <div class="col-sm-6"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Designation of office-in-charge</label>
            <div class="col-sm-6"></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-10">
    <div class="box">
      <div class="box-header">
        <div class="box-name"> <i class="fa fa-search"></i> <span>Office Address</span> </div>
        <div class="box-icons"> <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a> <a class="expand-link"> <i class="fa fa-expand"></i> </a> </div>
        <div class="no-move"></div>
      </div>
      <div class="box-content" id="OfficeAddress">
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-sm-4 control-label">Para/Tola/Street</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Vill/Town/Metro</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Post Office</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">District</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Subdivision</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Block/Municipality</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Police Station</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Pin Code</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Status Of Office</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Nature Of Office</label>
            <div class="col-sm-5"></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-10">
    <div class="box">
      <div class="box-header">
        <div class="box-name"> <i class="fa fa-search"></i> <span>Office Contact Details</span> </div>
        <div class="box-icons"> <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a> <a class="expand-link"> <i class="fa fa-expand"></i> </a> </div>
        <div class="no-move"></div>
      </div>
      <div class="box-content" id="OfficeContactDetails">
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-sm-4 control-label">Email ID</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Phone No</label>
            <div class="col-sm-5"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Mobile No</label>
            <div class="col-sm-5">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">FAX No</label>
            <div class="col-sm-5"></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-10">
    <div class="box">
      <div class="box-header">
        <div class="box-name"> <i class="fa fa-search"></i> <span>Office Personnel Details</span> </div>
        <div class="box-icons"> <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a> <a class="expand-link"> <i class="fa fa-expand"></i> </a> </div>
        <div class="no-move"></div>
      </div>
      <div class="box-content" id="OfficePersonnelDetails">
        <form class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-sm-4 control-label">Total Male Staffs</label>
            <div class="col-sm-3"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Total Female Staffs</label>
            <div class="col-sm-3"></div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Total Number of Staffs</label>
            <div class="col-sm-3"></div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
<div class="col-xs-12 col-sm-4">
<form class="form-horizontal" role="form">
    <button type="button" class="btn btn-primary btn-lg btn-label-left" id="confirm">
						<span><i class="fa fa-save"></i></span>
							Confirm
						
    </button>
    </form>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-4">
<form class="form-horizontal" role="form">
    <button type="button" class="btn btn-primary btn-lg btn-label-left" id="cancel">
						<span><i class="fa fa-close"></i></span>
							Cancel
						
    </button>
    </form>
</div>
</div>
  </div>
</div>
