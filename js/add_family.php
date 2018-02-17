<head>
<script>
$(document).ready(function(e) {
	$('.select2').select2();
	loadCategory();
	loadRationCardType();
	loadState();
	loadGender();
	loadDistrict($('#state').val());
	loadSubDistrict($('#dist').val());
	loadVillageTown($('#sub_dist').val());
	
	$('#state').change(function(e) {
        loadDistrict($(this).val());
		loadSubDistrict($('#dist').val());
		loadVillageTown($('#sub_dist').val());
    });
	
	$('#dist').change(function(e) {
        loadSubDistrict($(this).val());
		loadVillageTown($('#sub_dist').val());
    });
	
	$('#sub_dist').change(function(e) {
        loadVillageTown($(this).val());
    });
	
	$('#ration_type').change(function(e) {
    	if($(this).val().length > 0)
		{
			$('#ration_card_no').prop('disabled',false);
			$('#ration_card_no').addClass('check-ration');
		}
		else
		{
			$('#ration_card_no').prop('disabled',true);
			$('#ration_card_no').removeClass('check-ration');
		}
    });
	
	$('#addFamily').click(function(e) {
        if(validateForm('familyForm'))
			addFamilyDetails();
    });
});

function loadCategory(){
	$('#cat_code').empty();
	var category=getCategory();
	$.each(category,function(i){
		$('#cat_code').append("<option value='"+category[i].CatCode+"'>"+ category[i].CatName + "</option>");
	});
	$('#cat_code').select2();
}

function loadGender(){
	$('#gender').empty();
	var gender=getGender();
	$.each(gender,function(i){
		$('#gender').append("<option value='"+gender[i].GenderCode+"'>"+ gender[i].Gender + "</option>");
	});
	$('#gender').select2();
}

function loadRationCardType(){
	$('#ration_type').empty();
	$('#ration_type').append("<option value='' selected>NOT AVAILABLE</option>");
	var rationType=getRationCardType();
	$.each(rationType,function(i){
		$('#ration_type').append("<option value='"+rationType[i].RationCardTypeCode+"'>"+ rationType[i].RationCardType + "</option>");
	});
	$('#ration_type').select2();
}	

function loadState(){
	$('#state').empty();
	var state=getState();
	$.each(state,function(i){
		$('#state').append("<option value='"+state[i].StateCode+"'>"+ state[i].StateName + "</option>");
	});
	$('#state').select2();
}	

function loadDistrict(StateCode){
	$('#dist').empty();
	var dist=getDistrict(StateCode);
	$.each(dist,function(i){
		$('#dist').append("<option value='"+dist[i].DistrictCode+"'>"+ dist[i].DistrictName + "</option>");
	});
	$('#dist').select2();
}

function loadSubDistrict(DistrictCode){
	$('#sub_dist').empty();
	var sub_dist=getSubDistrict(DistrictCode);
	$.each(sub_dist,function(i){
		$('#sub_dist').append("<option value='"+sub_dist[i].SubDistrictCode+"'>"+ sub_dist[i].SubDistrictName + "</option>");
	});
	$('#sub_dist').select2();
}

function loadVillageTown(SubDistrictCode){
	$('#vill_town').empty();
	var vill_town=getVillageTown(SubDistrictCode);
	$.each(vill_town,function(i){
		$('#vill_town').append("<option value='"+vill_town[i].VillageTownCode+"'>"+ vill_town[i].VillageTownName + "</option>");
	});
	$('#vill_town').select2();
}

function addFamilyDetails()
{
	alert('Success');
}				
</script>
</head>

<div class="col-md-12">
  <!-- general form elements -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-user-plus"></i> Add Head of Family</h3>
      <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" id="familyForm">
      <div class="box-body">
      	<div class="col-md-6">
            <div class="form-group">
              <label for="hof">Head of Family Name:</label>
              <input type="text" class="form-control check-string" id="hof" placeholder="Head of Family Name">
            </div>
            <div class="form-group">
              <label for="gender">Gender:</label>
              <select id="gender" class="form-control select2" style="width: 100%;">
              </select>
            </div>
            <div class="form-group">
              <label for="age">Age:</label>
              <input type="text" class="form-control check-age" data-less="100" id="age" placeholder="Age">
            </div>
            <div class="form-group">
              <label for="addr1">Address Line 1:</label>
              <input type="text" class="form-control check-required" id="addr1" placeholder="Address Line 1">
            </div>
            <div class="form-group">
              <label for="addr2">Address Line 2:</label>
              <input type="text" class="form-control" id="addr2" placeholder="Address Line 2">
            </div>
            <div class="form-group">
              <label for="addr3">Address Line 3:</label>
              <input type="text" class="form-control" id="addr3" placeholder="Address Line 3">
            </div>
            <div class="form-group">
              <label for="addr3">Pincode:</label>
              <input type="text" class="form-control check-pin" id="pincode" placeholder="Pincode">
            </div>
            <div class="form-group">
              <label for="minority">Minority:</label>
              <select id="minority" class="form-control select2" style="width: 100%;">
              	<option value="0" selected>NO</option>
                <option value="1">YES</option>
              </select>
            </div>
        </div><!-- col 1 -->
        
        <div class="col-md-6">
        	<div class="form-group">
              <label for="state">State:</label>
              <select id="state" class="form-control select2" style="width: 100%;">
              </select>
            </div>
            <div class="form-group">
              <label for="dist">District:</label>
              <select id="dist" class="form-control select2" style="width: 100%;">
              </select>
            </div>
            <div class="form-group">
              <label for="sub_dist">Sub District:</label>
              <select id="sub_dist" class="form-control select2" style="width: 100%;">
              </select>
            </div>
            <div class="form-group">
              <label for="vill_town">Village/Town:</label>
              <select id="vill_town" class="form-control select2" style="width: 100%;">
              </select>
            </div>
            <div class="form-group">
              <label for="ration_type">Ration Card Type:</label>
              <select id="ration_type" class="form-control select2" style="width: 100%;">
              </select>
            </div>
            <div class="form-group">
              <label for="ration_card_no">Ration Card No:</label>
              <input type="text" class="form-control check-number" id="ration_card_no" placeholder="Ration Card No" disabled="disabled">
            </div>
            <div class="form-group">
              <label for="cat_code">Category:</label>
              <select id="cat_code" class="form-control select2" style="width: 100%;">
              </select>
            </div>
            <div class="form-group">
              <label for="caste_category">Caste Category:</label>
              <select id="caste_category" class="form-control select2" style="width: 100%;">
              	<option value="01">SC</option>
                <option value="02">ST</option>
                <option value="03">OBC</option>
                <option value="99">OTHERS</option>
              </select>
            </div>
        </div><!-- Col 2 -->
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="button" class="btn btn-success  btn-lg pull-right" id="addFamily"><i class="fa fa-save"></i> Save</button>
      </div>
    </form>
  </div><!-- /.box -->
</div>