<?php
session_start();
?>
<script>
$('.select2').select2();
$('#office_code').select2({placeholder: 'Select Office'});
		
$('#basic_pay').prop('disabled',true);
$('#grade_pay').prop('disabled',true);
$('#qualification_code').prop('disabled',true);
$('#next2').prop('disabled',true);

$('#desg').prop('disabled',true);
$('#gender').prop('disabled',true);
$('#age').prop('disabled',true);
$('#next3').prop('disabled',true);

$('#remarks').prop('disabled',true);
$('#post_stat_from').prop('disabled',true);
$('#post_stat_to').prop('disabled',true);
$('#setrule').prop('disabled',true);

//Green color scheme for iCheck
$('input[type="checkbox"].minimal-red').iCheck({
  checkboxClass: 'icheckbox_minimal-red'
});

$('#not_qualification, #not_designation, #not_remarks').iCheck('disable');
</script>
<div class="row">
	<div class="col-md-12">
    	<div class="box box-solid">
        	<div class="box-header with-border">
    		<h3 class="box-title text-red"><strong>Personnel Categorization - New Rule</strong>
         	</div><!-- /.box-header -->


	<div class="box-body">
	<div class="row">
	<form role="form" id="pp_category_form1">
    	<div class="col-md-4">
    		<div class="form-group">
              <label for="subdiv">Subdivision:</label>
			  <div>
              <select id="subdiv" class="form-control select2" style="width: 100%;">
              </select>
			  </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <label for="office_govt">Office Category:</label>
			  <div class="input-group">
              <select id="office_govt" class="form-control select2" style="width: 100%;" multiple="multiple">
              </select>
              <span class="input-group-btn">
              	<button class="btn btn-warning pull-right" id="loadOffice"><i class="fa fa-arrow-circle-right"></i> Load Office</button>
              </span>
			  </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <label for="office_code">Office:</label>
			  <div class="input-group">
              <select id="office_code" class="form-control select2" style="width: 100%;" multiple="multiple">
              </select>
              <span class="input-group-btn">
              	<button class="btn btn-primary pull-right" id="next1"><i class="fa fa-arrow-circle-down"></i> Next</button>
              </span>
			  </div>
            </div>
        </div>
    </form>
    </div><!-- End Row 1 -->
    
    <div class="row">
	<form role="form" id="pp_category_form2">    
        <div class="col-md-4">
        	<div class="form-group">
              <label for="basic_pay">Basic Pay:</label>
              <input id="basic_pay" type="text" name="basic_pay" value="" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
    		<div class="form-group">
              <label for="grade_pay">Grade Pay:</label>
              <input id="grade_pay" type="text" name="grade_pay" value="" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <label for="qualification">Qualification:</label>
			  <div class="input-group">
              <span class="input-group-addon">
                  <input type="checkbox" class="minimal-red" id="not_qualification"> <i class="fa fa-exclamation text-yellow"></i>
              </span>
              <select id="qualification_code" class="form-control select2" multiple="multiple" style="width: 100%;">
              </select>
              <span class="input-group-btn">
              	<button class="btn btn-md btn-primary pull-right" id="next2"><i class="fa fa-arrow-circle-down"></i> Next</button>
           	  </span>
			  </div>
            </div>
        </div>
    </form>
    </div><!-- End Row 2 -->
    
    <div class="row">
	<form role="form" id="pp_category_form3">    
        <div class="col-md-4">
    		<div class="form-group">
              <label for="desg">Designation:</label>
			  <div class="input-group">
              <span class="input-group-addon">
                  <input type="checkbox" class="minimal-red" id="not_designation"> <i class="fa fa-exclamation text-yellow"></i>
              </span>
              <select id="desg" class="form-control select2" multiple="multiple" style="width: 100%;">
              </select>
			  </div>
            </div>
        </div>
        <div class="col-md-4">
    		<div class="form-group">
              <label for="gender">Gender:</label>
			  <div>
              <select id="gender" class="form-control select2" style="width: 100%;">
              	<option value="ALL">ALL</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
              </select>
			  </div>
            </div>
        </div>
        <div class="col-md-4">
    		<div class="form-group">
              <label for="age">Age:</label>
			  <div class="input-group">
              <select id="age" class="form-control select2" style="width: 100%;">
              	<option value="< 60">Less than 60</option>
              </select>
              <span class="input-group-btn">
              	<button class="btn btn-md btn-primary pull-right" id="next3"><i class="fa fa-arrow-circle-down"></i> Next</button>
           	  </span>
			  </div>
            </div>
        </div>
	</form>
    </div><!-- End Row 3 -->
    	
    <div class="row">
	<form role="form" id="pp_category_form4">
    	<div class="col-md-4">
            <div class="form-group">
              <label for="remarks">Remarks:</label>
              <div class="input-group">
              <span class="input-group-addon">
                  <input type="checkbox" class="minimal-red" id="not_remarks"> <i class="fa fa-exclamation text-yellow"></i>
              </span>
              <select id="remarks" class="form-control select2" multiple="multiple" style="width: 100%;">
              </select>
              </div>
            </div>
        </div> 
    	<div class="col-md-4">
            <div class="form-group">
              <label for="post_stat_from">Post Status (From):</label>
              <select id="post_stat_from" class="form-control select2" style="width: 100%;">
              </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
              <label for="post_stat_to">Post Status (To):</label>
              <div class="input-group">
              <select id="post_stat_to" class="form-control select2" style="width: 100%;">
              </select>
              <span class="input-group-btn">
              	<button class="btn btn-md btn-success pull-right" id="setrule"><i class="fa fa-check-square"></i> Set Rule</button>
           	  </span>
              </div>
            </div>
        </div>
    </div><!-- End Row 4 -->
    	
	</div><!-- BOX BODY-->
   
	</div><!--BOX-->
	</div><!-- COLUMN-->
</div><!--ROW-->

<script>
var not_qualification=0;
var not_designation=0;
var not_remarks=0;

$(document).ready(function(){
	
	$(function(){
		loadSubdivision();
		loadOfficeCategory();

	});
	
	$('#office_govt').change(function(e) {
        e.preventDefault();
		$('#office_code').empty();
		$('#office_code').select2({placeholder: 'Select Office'});
    });
	
	$('#loadOffice').click(function(e) {
        e.preventDefault();
		loadOfficeByCategory();
    });
	
	$('#next1').click(function(e) {
		e.preventDefault();
		if(validateForm('pp_category_form1')){
			$('#subdiv').prop('disabled',true);
			$('#office_govt').prop('disabled',true);
			$('#office_code').prop('disabled',true);
			$('#next1').prop('disabled',true);
			
			$('#basic_pay').prop('disabled',false);
			$('#grade_pay').prop('disabled',false);
			$('#qualification_code').prop('disabled',false);
			$('#not_qualification').iCheck('enable');
			$('#next2').prop('disabled',false);
			
			var subdiv=$('#subdiv').val();
			var govt=$('#office_govt').val();
			var officecd=$('#office_code').val();
			
			loadPPCategoryForm2(subdiv, govt, officecd);
		}
    });
	
	$('#next2').click(function(e) {
        e.preventDefault();
		if(validateForm('pp_category_form2')){
			$('#basic_pay').prop('disabled',true);
			$('#grade_pay').prop('disabled',true);
			$('#qualification_code').prop('disabled',true);
			$('#not_qualification').iCheck('disable');
			$('#next2').prop('disabled',true);
			
			$('#desg').prop('disabled',false);
			$('#not_designation').iCheck('enable');
			$('#gender').prop('disabled',false);
			$('#age').prop('disabled',false);
			$('#next3').prop('disabled',false);
			
			var subdiv=$('#subdiv').val();
			var govt=$('#office_govt').val();
			var officecd=$('#office_code').val();
			var basic_pay=$('#basic_pay').val();
			var grade_pay=$('#grade_pay').val();
			var qualification=$('#qualification_code').val();
			
			loadPPCategoryForm3(subdiv, govt, officecd, basic_pay, grade_pay, qualification);
		}
    });
	
	$('#next3').click(function(e) {
        e.preventDefault();
		if(validateForm('pp_category_form3')){
			$('#desg').prop('disabled',true);
			$('#not_designation').iCheck('disable');
			$('#gender').prop('disabled',true);
			$('#age').prop('disabled',true);
			$('#next3').prop('disabled',true);
			
			$('#remarks').prop('disabled',false);
			$('#not_remarks').iCheck('enable');
			$('#post_stat_from').prop('disabled',false);
			$('#post_stat_to').prop('disabled',false);
			$('#setrule').prop('disabled',false);
			
			loadPPCategoryForm4();
		}
    });
	
	$('#setrule').click(function(e) {
        e.preventDefault();
		saveRule();
	});
	
	$('#not_qualification').on('ifChecked', function(event){
  		not_qualification=1;
	});
	$('#not_qualification').on('ifUnchecked', function(event){
  		not_qualification=0;
	});
	
	$('#not_designation').on('ifChecked', function(event){
  		not_designation=1;
	});
	$('#not_designation').on('ifUnchecked', function(event){
  		not_designation=0;
	});
	
	$('#not_remarks').on('ifChecked', function(event){
  		not_remarks=1;
	});
	$('#not_remarks').on('ifUnchecked', function(event){
  		not_remarks=0;
	});

});

function loadSubdivision(){
	var subdiv;
	$('#subdiv').empty();
	$('#subdiv').select2({placeholder: 'Loading Subdivision...'});
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/subdivision_details.php',
		success: function(data) {
			subdiv=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	$('#subdiv').empty();
	$('#subdiv').append("<option value=''>Select Subdivsion</option>");
	$('#subdiv').append("<option value='ALL'>ALL</option>");
	$.each(subdiv,function(i){
		$('#subdiv').append("<option value='"+subdiv[i].SubdivisionCode+"'>"+subdiv[i].Subdivision+"</option>");
	});
	$('#subdiv').select2();
}

function loadOfficeCategory(){
	var govt;
	$('#office_govt').empty();
	$('#office_govt').select2({placeholder: 'Loading Office Category...'});
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/office_category.php',
		success: function(data) {
			govt=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	$('#office_govt').empty();
	$('#office_govt').append("<option value='ALL'>ALL</option>");
	$.each(govt,function(i){
		$('#office_govt').append("<option value='"+govt[i].CategoryCode+"'>"+govt[i].Category+"</option>");
	});
	$('#office_govt').select2({placeholder: 'Select Office Category'});
}

function loadOfficeByCategory(){
	var govt=$('#office_govt').val();
	var office;
	$('#office_code').empty();
	$('#office_code').select2({placeholder: 'Loading Office...'});
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'pp_category/office_by_category.php',
		type: 'POST',
		data: {govt: govt},
		success: function(data) {
			office=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	$('#office_code').empty();
	$('#office_code').append("<option value='ALL'>ALL</option>");
	$.each(office,function(i){
		$('#office_code').append("<option value='"+office[i].OfficeCode+"'>"+office[i].OfficeCode+' - '+office[i].OfficeName+"</option>");
	});
	$('#office_code').select2({placeholder: 'Select Office'});
}

function loadPPCategoryForm2(subdiv, govt, officecd){
	var qualification;
	$('#qualification_code').select2({placeholder: 'Loading Qualification...'});
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'pp_category/qualification_by_clause.php',
		type: 'POST',
		data: {
				subdiv: subdiv,
				govt: govt,
				officecd: officecd
			  },
		success: function(data) {
			qualification=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	$('#qualification_code').empty();
	$('#qualification_code').append("<option value='ALL'>All Available</option>");
	$.each(qualification,function(i){
		$('#qualification_code').append("<option value='"+qualification[i].QualificationCode+"'>"+qualification[i].QualificationName+"</option>");
	});
	$('#qualification_code').select2({placeholder: 'Select Qualification'});
	
	//Basic and Grade Pay
	var pay;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'pp_category/pay_details_by_clause.php',
		type: 'POST',
		data: {
				subdiv: subdiv,
				govt: govt,
				officecd: officecd
			  },
		success: function(data) {
			pay=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	
	$("#basic_pay").ionRangeSlider({
          min: pay.MinBasic,
          max: pay.MaxBasic,
          from: pay.MinBasic,
          to: pay.MaxBasic,
          type: 'double',
          step: 1000,
          prefix: "$ ",
          prettify: false,
          hasGrid: true
    });
	
	$("#grade_pay").ionRangeSlider({
          min: pay.MinGrade,
          max: pay.MaxGrade,
          from: pay.MinGrade,
          to: pay.MaxGrade,
          type: 'double',
          step: 100,
          prefix: "$ ",
          prettify: false,
          hasGrid: true
    });
}

function loadPPCategoryForm3(subdiv, govt, officecd, basic_pay, grade_pay, qualification){
	//Designation
	var desg;
	$('#desg').select2({placeholder: 'Loading Designation...'});
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'pp_category/designation_by_clause.php',
		type: 'POST',
		data: {
				subdiv: subdiv,
				govt: govt,
				officecd: officecd,
				basic_pay: basic_pay,
				grade_pay: grade_pay,
				qualification: qualification,
				not_qualification: not_qualification
			  },
		success: function(data) {
			desg=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	
	if(desg.length > 0){
		$('#desg').empty();
		$('#desg').append("<option value='ALL'>All Available</option>");
		$.each(desg,function(i){
			$('#desg').append("<option value='"+desg[i].Designation+"'>"+desg[i].Designation+"</option>");
		});
		$('#desg').select2({placeholder: 'Select Designation'});
	}
	else{
		$('#desg').select2({placeholder: 'Error in Designation !!!'});
	}
}

function loadPPCategoryForm4(){
	var post_stat;
	var remarks;
	$('#post_stat_from').select2({placeholder: 'Loading Post Status...'});
	$('#post_stat_to').select2({placeholder: 'Loading Post Status...'});
	$('#remarks').select2({placeholder: 'Loading Remarks...'});
	
	//For Remarks
	var subdiv=$('#subdiv').val();
	var govt=$('#office_govt').val();
	var officecd=$('#office_code').val();
	var basic_pay=$('#basic_pay').val();
	var grade_pay=$('#grade_pay').val();
	var qualification=$('#qualification_code').val();
	var desg=$('#desg').val();
	var gender=$('#gender').val();
	var age=$('#age').val();
	
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'pp_category/remarks_by_clause.php',
		type: 'POST',
		data: {
				subdiv: subdiv,
				govt: govt,
				officecd: officecd,
				basic_pay: basic_pay,
				grade_pay: grade_pay,
				qualification: qualification,
				not_qualification: not_qualification,
				desg: desg,
				not_designation: not_designation,
				gender: gender,
				age: age
			  },
		success: function(data) {
			remarks=JSON.parse(JSON.stringify(data));//alert(remarks.status);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	$('#remarks').empty();
	$.each(remarks,function(i){
		$('#remarks').append("<option value='"+remarks[i].RemarksCode+"'>"+remarks[i].RemarksName+"</option>");
	});
	$('#remarks').select2();
	
	//For Post Status
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'pp_category/poststat_details.php',
		success: function(data) {
			post_stat=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	
	$('#post_stat_from').empty();
	$('#post_stat_from').append("<option value='NA'>Not Assigned</option>");
	$('#post_stat_to').empty();
	$.each(post_stat,function(i){
		$('#post_stat_from').append("<option value='"+post_stat[i].PostCode+"'>"+post_stat[i].PostName+"</option>");
		$('#post_stat_to').append("<option value='"+post_stat[i].PostCode+"'>"+post_stat[i].PostName+"</option>");
	});
	$('#post_stat_from').select2();
	$('#post_stat_to').select2();
}

function saveRule(){
	var subdiv=$('#subdiv').val();
	var govt=$('#office_govt').val();
	var officecd=$('#office_code').val();
	var basic_pay=$('#basic_pay').val();
	var grade_pay=$('#grade_pay').val();
	var qualification=$('#qualification_code').val();
	var desg=$('#desg').val();
	var gender=$('#gender').val();
	var age=$('#age').val();
	var post_stat_from=$('#post_stat_from').val();
	var post_stat_to=$('#post_stat_to').val();
	var remarks=$('#remarks').val();
	
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'pp_category/set_rule.php',
		type: 'POST',
		data: {
				subdiv: subdiv,
				govt: govt,
				officecd: officecd,
				basic_pay: basic_pay,
				grade_pay: grade_pay,
				qualification: qualification,
				not_qualification: not_qualification,
				desg: desg,
				not_designation: not_designation,
				gender: gender,
				age: age,
				remarks: remarks,
				not_remarks: not_remarks,
				post_stat_from: post_stat_from,
				post_stat_to: post_stat_to
			  },
		success: function(data) {
			var result=JSON.parse(JSON.stringify(data));
			alert(result.Status);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}
</script>