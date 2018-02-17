<?php
session_start();
?>
<script>
$(document).ready(function(){
	$('.select2').select2('data', {text: 'Loading...'});
	//$('#add_image').hide();
	$('#skip').hide();

	if(checkSubdivSession()=="TRUE")
	{
		if(checkOfficeSession()=="TRUE")
		{
			$('#div_message').hide();
			$('#personnel_form').show();
			$('.box-footer').show();
			$('#confirm').show();
			$('#show_office_name').html("&nbsp;OF&nbsp;"+getOfficeNamefromSession());
			LoadQualificationDetails('Qualification');
	
			LoadLanguageDetails('LanguageKnown');
			LoadRemarksDetails('Remarks');
			$('#Remarks').select2("val",'99');
			LoadBankDetails('Bank');
		
			LoadAssemblyDetails('Assembly_perm');
			LoadAssemblyDetails('Assembly_temp');
			LoadAssemblyDetails('VoterOfAssembly');
			
			LoadAssemblyDetails();
			$('#DateOfBirth').daterangepicker({
				singleDatePicker: true,
				showDropdowns: true,
				"locale": {
				"format": "YYYY/MM/DD"
				},
				"minDate": "1950/01/01",
				"maxDate": "1997/12/31",
				startDate: 'XXXX/XX/XX',
		
			});
		}
		else
		{
			$('#div_message').show();
			$('#div_message').html("<h4>Please Set Office Code.</h4>");
			$('#personnel_form').hide();
			$('#confirm').hide();
			$('.box-footer').hide();
	
		}
	}
	else
	{
			$('#div_message').show();
			$('#div_message').html("<h4>Please Set Subdivision first.</h4>");
			$('#personnel_form').hide();
			$('#confirm').hide();
			$('.box-footer').hide();
	}
	
	$('#SameAddress').click(function(e) {
		if($('#SameAddress').prop('checked'))
		{
			$('#PermanentAddress1').val(document.getElementById('PresentAddress1').value);
			$('#PermanentAddress1').prop('readonly', true);
			$('#PermanentAddress2').val(document.getElementById('PresentAddress2').value);
			$('#PermanentAddress2').prop('readonly', true);
		}
		else
		{
			$('#PermanentAddress1').val("");
			$('#PermanentAddress1').prop('readonly', false);
			$('#PermanentAddress2').val("");
			$('#PermanentAddress2').prop('readonly', false);
		}
		
    });
	
		$('#confirm').attr('data-toggle', 'modal');
		$('#confirm').attr('data-target', '#pageModal');
$("#confirm").click(function(){
//alert($('#DateOfBirth').val());

if(validateForm('personnel_add_form'))
{
	if(check_accno())
	{
			$('#confirmBankAcNo').parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
			$('#BankAcNo').parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
			$('#pageModal').removeClass('modal-danger').removeClass('modal-success').addClass('modal-warning');
			$('#warning_msg').show();
			$('#error_msg').hide();
			$('#success_msg').hide();
			$('.modal-footer').show();
	}
	else
	{
		$('#confirmBankAcNo').parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");	
		$('#BankAcNo').parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");	
		$('#pageModal').removeClass('modal-warning').removeClass('modal-success').addClass('modal-danger');
		$('#warning_msg').hide();
		$('#error_msg').show();
		$('#success_msg').hide();
		$('.modal-footer').hide();	
	}
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

function check_accno()
{
	var ret=0;
	if($('#confirmBankAcNo').val()==$('#BankAcNo').val())
	{
		ret=1;	
	}
	return ret;	
}
$("#ok").click(function(){
	//alert(AddEmployee());
$(this).prop( "disabled", true );
	var msg=AddEmployee();
	$('#show_emp_cd').html("<b>"+msg+"</b>");
	$('#personnel_form').hide();
	$('#confirm').hide();
	$('#add_image_form').show();
	$('#add_image').show();
	$('#skip').show();
	$('#pageModal').modal('hide');
});

/*function data_copy()
{
	alert();
	$('#PermanentAddress1').value=$('#PresentAddress1').val();
	$('#PermanentAddress2').value=$('#PresentAddress2').val();
}
/*

var bar = $('.bar');
var percent = $('.percent');
var image_preview = $('#image_preview');

$('#add_image').click(function(e) {
	$('#upload_file_form').ajaxForm({
		beforeSend: function() {
			image_preview.empty();
			var percentVal = '0%';
			bar.width(percentVal)
			percent.html(percentVal);
			alert();
		},
		//target:"#image_preview",
		uploadProgress: function(event, position, total, percentComplete) {
			var percentVal = percentComplete + '%';
			bar.width(percentVal)
			percent.html(percentVal);
	//console.log(percentVal, position, total);
		},
		success: function() {
			var percentVal = '100%';
			bar.width(percentVal)
			percent.html(percentVal);
		},
		complete:function(xhr) { 
			$("#image_preview").html(xhr.responseText); 
			//$("#image_preview").slideDown(10000);
		}
	});
    
});
*/

$('#add_image').click(function(e) {
	if(validateForm('upload_image_form'))
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
$("#skip").click(function(e) {
    
	$('#page_content').load('forms/personnel_form.php');
});



});

</script>
<div class="row">
	<div class="col-md-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
    		<h3 class="box-title">ADD EMPLOYEE 
			<span id="show_office_name"></span>
			<?php
				if(isset($_SESSION['Office']))
				{
					echo "( Code: ".$_SESSION['Office']." )"; 
				}
				?></h3>
            
            <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                 </div>
         	</div><!-- /.box-header -->


	<div class="box-body">
   	<div id="div_message" class="callout callout-danger" hidden="">												
    </div>
    
    <div id="personnel_form" hidden="">
	<form class="form-horizontal" role="form" id="personnel_add_form">
    <div class="col-sm-6">
    <!-- employee details-->
          <div class="callout bg-info" style="margin-bottom: 0!important;">												
            <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;Employee Details
          </div>

    	 	<div class="form-group col-sm-12" id="div_EmployeeName">
           	<label class="control-label"><font color="red">*</font>Employee Name</label>
			<div>
			<input type="text" class="form-control check-string" placeholder="Employee Name" data-toggle="tooltip" data-placement="bottom" title="Enter Employee Name" id="EmployeeName" maxlength="50">
            </div>
			</div>
            
            
            <!--
            <div class="form-group col-sm-12">
            <label class="control-label"><font color="red">*</font>CHECKBOX</label>
            <div class="toggle-switch toggle-switch-success">
            	<label>
            	<input type="checkbox">
            	<div class="toggle-switch-inner"></div>
            		<div class="toggle-switch-switch"><i class="fa fa-check"></i></div>
            	</label>
            </div>
            </div>
            -->
            
            <div class="form-group col-sm-12" id="div_Designation">
           	<label class="control-label"><font color="red">*</font>Employee Designation</label>
			<div>
			<input type="text" class="form-control check-required" placeholder="Employee Designation" data-toggle="tooltip" data-placement="bottom" title="Enter Employee Designation" id="Designation" maxlength="50"\>
            </div>
			</div>
            
            <div class="form-group col-sm-12" id="div_sex">
           	<label class="control-label"><font color="red">*</font>Sex</label>
            <div class="row">
					<div class="col-sm-6">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="radio" name="radio_sex" id="Sexm" value="M" checked="checked">
                        </span>
                        <input type="text" class="form-control" disabled="disabled" value="Male">
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="radio" name="radio_sex" id="Sexf" value="F">
                        </span>
                        <input type="text" class="form-control" disabled="disabled" value="Female">
                      </div>
                      </div>
                 </div>
			
			</div>
            
            
            <div class="form-group col-sm-12" id="div_DateOfBirth">
           	<label class="control-label"><font color="red">*</font>Date Of Birth</label>
			<div>
			<input type="text" class="form-control check-dob" value="" placeholder="Date Of Birth" data-toggle="tooltip" data-placement="bottom" title="Enter Date Of Birth" id="DateOfBirth" readonly="readonly"\>
            </div>
			</div>
            
            <div class="form-group col-sm-12" id="div_ScaleOfPay">
           	<label class="control-label"><font color="red">*</font>Scale Of Pay&nbsp;&nbsp;e.g. 10,000 - 20,000</label>
			<div>
			<input type="text" class="form-control check-required" placeholder="Pay of Scale" maxlength="50" data-toggle="tooltip" data-placement="bottom" title="Enter pay of scale" id="ScaleOfPay"\>
            </div>
			</div>
            
            <div class="form-group col-sm-12" id="div_BasicPay">
           	<label class="control-label"><font color="red">*</font>Basic Pay</label>
			<div>
			<input type="text" class="form-control check-total" placeholder="Basic Pay" maxlength="6" data-toggle="tooltip" data-placement="bottom" title="Enter Basic Pay" id="BasicPay"\>
            </div>
			</div>
            
            <div class="form-group col-sm-12" id="div_GradePay">
           	<label class="control-label">Grade Pay (if not available, do not provide zero(0), leave it blank.)</label>
			<div>
			<input type="text" class="form-control check-number if-available" placeholder="Grade Pay" maxlength="6" data-toggle="tooltip" data-placement="bottom" title="Enter Grade Pay" id="GradePay"\>
            </div>
			</div>
            
            
         <!-- end of employee details-->
    
    </div>  <!-- end of col1-->
    
    <div class="col-sm-6">
          <div class="callout bg-info" style="margin-bottom: 0!important;">												
            <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;Contact Details
          </div>

        <div class="form-group col-sm-12" id="div_PresentAddress1">
			<label class="control-label"><font color="red">*</font>Present Address 1</label>
			<div>
				<input type="text" class="form-control check-required" placeholder="Address Line 1" name="PresentAddress1" id="PresentAddress1" data-toggle="tooltip" data-placement="bottom" title="Enter Present Address Line1" maxlength="50">  
           	</div>    
        </div>
        
        <div class="form-group col-sm-12" id="div_PresentAddress2">
			<label class="control-label"><font color="red">*</font>Present Address 2</label>
            <div>
				<input type="text" class="form-control check-required" placeholder="Address Line 2" name="PresentAddress2" id="PresentAddress2" data-toggle="tooltip" data-placement="bottom" title="Enter Present Address Line2" maxlength="50">  
                </div>    
        </div>
        
        <div class="form-group col-sm-12" id="div_SameAddress">
		<div class="input-group">
                <span class="input-group-addon">
                  <input type="checkbox" id="SameAddress" name="SameAddress">
                </span>
                <input type="text" class="form-control" disabled="disabled" value="Check if Present and Permanent Address is same">
      	</div>
        </div>
        
        <div class="form-group col-sm-12" id="div_PermanentAddress1">
			<label class="control-label"><font color="red">*</font>Permanent Address 1</label>
            <div>
				<input type="text" class="form-control check-required" placeholder="Address Line 2" name="PermanentAddress1" id="PermanentAddress1" data-toggle="tooltip" data-placement="bottom" title="Enter Permanent Address Line1" maxlength="50">  
           	</div>    
        </div>
        
        <div class="form-group col-sm-12" id="div_PermanentAddress2">
			<label class="control-label"><font color="red">*</font>Permanent Address 2</label>
            <div>
				<input type="text" class="form-control check-required" placeholder="Address Line 2" name="PermanentAddress2" id="PermanentAddress2" data-toggle="tooltip" data-placement="bottom" title="Enter Permanent Address Line2" maxlength="50">  
           	</div>    
        </div>
        
        
        
        <div class="form-group col-sm-12" id="div_EmailId">
        
        	<label class="control-label">Email ID</label>
            <div>
				<input type="text" class="form-control check-mail-if-available" placeholder="Email Id" name="EmailId" id="EmailId" data-toggle="tooltip" data-placement="bottom" title="Enter Email Id" maxlength="30"/>
           	</div>
        </div>
 
		<div class="form-group col-sm-12" id="div_PhoneNumber">
			<label class="control-label"><font color="red"></font>Phone No</label>
            <div>
				<input type="text" class="form-control check-phone-if-available" placeholder="Phone Number" name="PhoneNumber" id="PhoneNumber" data-toggle="tooltip" data-placement="bottom" title="Enter Phone Number" maxlength="13"/>
           	</div>
       </div>

  		<div class="form-group col-sm-12" id="div_MobileNumber">
			<label class="control-label"><font color="red">*</font>Mobile No - Essential for Payment, Training and Other Election Related Matters</label>
            <div>
				<input type="text" class="form-control check-mobile" placeholder="Mobile Number" name="MobileNumber" id="MobileNumber" data-toggle="tooltip" data-placement="bottom" title="Enter Mobile Number" maxlength="10">
           	</div>
       </div>

    </div><!-- end of col2-->       

    <div class="col-sm-6">
             <!-- start of additional detials-->
          <div class="callout bg-info" style="margin-bottom: 0!important;">												
            <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;Additional Details
          </div>

        
        <div class="form-group col-sm-12" id="div_Qualification">
			<label class="control-label"><font color="red">*</font>Qualification</label>
            <div>
			<select name="Qualification" id="Qualification" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Qualification">
            <option value="">Select Qualification</option>
          </select>
          </div>
     	</div>
       	
        <div class="form-group col-sm-12" id="div_LanguageKnown">
			<label class="control-label"><font color="red">*</font>Languages Known (Other Than Bengali)</label>
            <div>
			<select name="LanguageKnown" id="LanguageKnown" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Known Language">
            <option value="">Select Language</option>
          </select>
        	</div>
       </div>
          
       <div class="form-group col-sm-12">
			<label class="control-label">Working in the District for more than 3 Years as on 31.12.2015</label>
            
            <div class="row">
					<div class="col-sm-6">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="radio" name="radio_exp" id="WorkExperienceY" value="Yes" checked="checked">
                        </span>
                        <input type="text" class="form-control" disabled="disabled" value="Yes">
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="radio" name="radio_exp" id="WorkExperienceN" value="No">
                        </span>
                        <input type="text" class="form-control" disabled="disabled" value="No">
                      </div>
            	</div>
         	</div>
       </div>

		<div class="form-group col-sm-12" id="div_Remarks">
			<label class="control-label"><font color="red">*</font>Remarks</label>
            <div>
				<select name="Remarks" id="Remarks" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Remarks">
            <option value="">Select Remarks</option>
          </select>
          </div>
       </div>
         
         <!-- end of additional details-->
     </div>
     
      <div class="col-sm-6">
             <!-- start of bank detials-->
          <div class="callout bg-info" style="margin-bottom: 0!important;">												
            <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;Bank Details
          </div>

        
        <div class="form-group col-sm-12" id="div_Bank">
			<label class="control-label"><font color="red">*</font>Bank / Post Office</label>
            <div>
				<select class="form-control select2" placeholder="Bank Name" name="Bank" id="Bank" data-toggle="tooltip" data-placement="bottom" title="Enter Bank Name">
                <option value="">Select Bank</option>
                </select>
          	</div>
       	</div>
   		<div class="form-group col-sm-12" id="div_BranchName">
			<label class="control-label"><font color="red">*</font>Branch Name</label>
            <div>
				<input type="text" class="form-control check-required" placeholder="BranchName" name="BranchName" id="BranchName" data-toggle="tooltip" data-placement="bottom" title="Enter Branch Name" maxlength="40">
           	</div>
		</div>
       <div class="form-group col-sm-12" id="div_BranchIFSCCode">
			<label class="control-label"><font color="red">*</font>Branch IFSC Code</label>
            <div>
				<input type="text" class="form-control check-required" placeholder="Branch IFSC Code" name="BranchIFSCCode" id="BranchIFSCCode" data-toggle="tooltip" data-placement="bottom" title="Enter Branch IFSC Code" maxlength="11">
          	</div>
		</div>
        <div class="form-group col-sm-12" id="div_BankAcNo">
			<label class="control-label"><font color="red">*</font>Account Number</label>
            <div>
				<input type="text" class="form-control check-acc-no" placeholder="Account Number" name="BankAcNo" id="BankAcNo" data-toggle="tooltip" data-placement="bottom" title="Enter Bank Account Number"  maxlength="20" >
           	</div>
		</div>
       <div class="form-group col-sm-12" id="div_confirmBankAcNo">
			<label class="control-label"><font color="red">*</font>Confirm Account Number</label>
            <div>
				<input type="text" class="form-control check-acc-no" placeholder="Confirm Account Number" name="confirmBankAcNo" id="confirmBankAcNo" data-toggle="tooltip" data-placement="bottom" title="Confirm Bank Account Number"  maxlength="25">
          	</div>
		</div>
        
   	</div>

    <div class="col-sm-6">
             <!-- start of epic detials-->
          <div class="callout bg-info" style="margin-bottom: 0!important;">												
            <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;Epic Details
          </div>

        
        <div class="form-group col-sm-12" id="div_EpicNo">
			<label class="control-label"><font color="red">*</font>EPIC No. (Please refer the actual EPIC card to avoid any mistake)</label>
            <div>
			      <input type="text" class="form-control check-required" placeholder="Epic No." name="EpicNo" id="EpicNo" data-toggle="tooltip" data-placement="bottom" title="Enter Epic No." maxlength="25">
           	</div>
  		</div>
        <div class="form-group col-sm-12" id="div_PartNo">
			<label class="control-label"><font color="red">*</font>Part No.</label>
            <div>
				<input type="text" class="form-control check-required" placeholder="Part No." name="PartNo" id="PartNo" data-toggle="tooltip" data-placement="bottom" title="Enter Part No." maxlength="5">
			</div>
      </div>
      <div class="form-group col-sm-12" id="div_SerialNo">
			<label class="control-label"><font color="red"></font>Serial No.</label>
            <div>
				<input type="text" class="form-control" placeholder="Serial No." name="SerialNo" id="SerialNo" data-toggle="tooltip" data-placement="bottom" title="Enter Serial No" maxlength="5">
           	</div>
		</div>
 
     </div>
     <div class="col-sm-6">
         <!-- start of assembly detials-->
          <div class="callout bg-info" style="margin-bottom: 0!important;">												
            <i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;Assempbly Details
          </div>
<!--
     <div class="form-group col-sm-12" id="div_Assembly1">
		<label class="control-label"><font color="red">*</font>Present Address</label>					
        	<select name="Assembly1" id="Assembly1" class="form-control" data-toggle="tooltip" data-placement="bottom" title="Enter Assembly Name">
             	<option>Select Assembly</option>
   			</select>
	</div>
    
 -->
       <div class="form-group col-sm-12" id="div_Assembly_temp">
    	<label class="control-label"><font color="red">*</font>Assembly for Present/Temporary Address</label>
        <div>
			<select name="Assembly_temp" id="Assembly_temp" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Assembly Name">
            <option value="">Select Assembly</option>
      		</select>
      	</div>
	</div>
           
   <div class="form-group col-sm-12" id="div_Assembly_perm">
		<label class="control-label"><font color="red">*</font>Assembly for Permanent Address/Voter Assembly</label>
        <div>
			<select name="Assembly_perm" id="Assembly_perm" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Assembly Name">
            <option value="">Select Assembly</option>
        	 </select>
      	</div>
	</div>

    <div class="form-group col-sm-12" id="div_Assembly_off">
    	<label class="control-label"><font color="red">*</font>Assembly for Place of Posting/Office</label>
       	<div>
        	<select name="VoterOfAssembly" id="Assembly_off" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Voter Of Assembly">
            <option value="">Select Assembly</option>
        	</select>
       	</div>
	</div>
    </div>
	   <div class="form-group col-sm-12">
       <div class="callout callout-info">	
			<i class="fa fa-star"></i><b style="color:#000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Certified that the detail information furnished earlier in PP-1 format and also PP-2 format are verified with office record and genuine. Names of all officials have been included in the PP-2 format and no information has been concealed.</b>
        </div>
      	</div>
     </form>
    </div><!-- END OF PERSONNEL FORM-->
    
		<div id="add_image_form" hidden="">

       		<div class="alert bg-success">												
            	<H3><i class="fa fa-info"></i>&nbsp;&nbsp;&nbsp;
                <span id="show_emp_cd"></span></H3>
        	</div>
        </div>
            <!--
        <div class="col-sm-12">
        <form class="form-horizontal" role="form"  id="upload_image_form"> 
        	<div class="form-group" id="div_AadharNumber">
            	<label class="col-sm-4 control-label">Aadhar Number</label>
            	<div class="col-sm-5">
                	<input type="text" class="form-control check-required" placeholder="Aadhar Number" data-toggle="tooltip" data-placement="bottom" title="Enter Aadhar Number" id="AadharNumber" name="AadharNumber" maxlength="12">
            	</div>
        	</div>
        	<div class="form-group" id="div_Image">
            	<label class="col-sm-4 control-label">Image of the Employee</label>
            	<div class="col-sm-5">
               	<input data-toggle="tooltip" title="Select Image" type="file" name="upload_file">
            	</div>
        	</div>
        </form>
        </div>
        -->
        <!--
        <div class="col-sm-4">

            <div class="form-group" id="image_preview" style="height:120px; width:100px; border:inset #666;"> Image Preview</div>
           	<div class="progress">
            <div class="bar"></div >
            <div class="percent">0%</div >
            </div>
        </div>
        </div>
-->
	</div><!-- BOX BODY-->
    <div class="box-footer text-center" hidden="">
    	<button type="button" class="btn btn-success btn-lg"  id="confirm" ><span><i class="fa fa-save"></i></span>&nbsp;&nbsp;Save</button>
        
        <!-- buttons for adding image
        
        <button type="button" class="btn btn-app bg-green" id="add_image" ><span><i class="fa fa-save"></i></span>&nbsp;&nbsp;Save</button>-->

    	<button type="button" class="btn btn-app bg-maroon" id="skip"><span><i class="fa fa-forward"></i></span>&nbsp;&nbsp;And New Employee</button>    
    </div>
	</div><!--BOX-->
	</div><!-- COLUMN-->
</div><!--ROW-->
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
