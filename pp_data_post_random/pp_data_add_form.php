<?PHP
session_start();
include("../config/config.php");
$officecd=$_POST['officecd'];
?>

<h3 class="page-header">New Employee Details for Office Code: <span class="officecd"><?php echo $officecd; ?></span></h3>

<div class="overlay text-center" align="center">
  <img src="img/ajax_loader_green_128.gif" width="50" height="50" />
  <small> Loading...</small>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-warning" id="report_panel" style="display: none">
            <div class="panel-heading text-bold"><i class="fa fa-info-circle text-blue"></i>&nbsp;&nbsp;<span id="report_result">Msg Panel</span></div>
        </div>
    </div>
</div><!-- End Row 3 -->
<form class="form-horizontal" role="form" id="personnel_add_form">
    <div class="col-sm-6">
    <!-- employee details-->
          <div class="callout bg-info" style="margin-bottom: 0!important;">												
            <i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;Employee Details
          </div>

    	 	<div class="form-group col-sm-12" id="div_EmployeeName">
           	<label class="control-label"><font color="red">*</font>Employee Name</label>
			<div>
                            <input type="text" class="form-control check-string" placeholder="Employee Name" data-toggle="tooltip" data-placement="bottom" title="Enter Employee Name" id="EmployeeName" maxlength="50">
            </div>
			</div>
            
            <div class="form-group col-sm-12" id="div_Designation">
           	<label class="control-label"><font color="red">*</font>Employee Designation</label>
			<div>
                            <input type="text" class="form-control check-required" placeholder="Employee Designation" data-toggle="tooltip" data-placement="bottom" title="Enter Employee Designation" id="Designation" maxlength="50">
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
			<input type="text" class="form-control check-dob" value="" placeholder="Date Of Birth" data-toggle="tooltip" data-placement="bottom" title="Enter Date Of Birth" id="DateOfBirth" readonly="readonly">
            </div>
			</div>
            
           
            <div class="form-group col-sm-12" id="div_ScaleOfPay">
           	<label class="control-label"><font color="red">*</font>Scale Of Pay&nbsp;&nbsp;e.g. 10,000 - 20,000</label>
			<div>
			<input type="text" class="form-control check-required" placeholder="Pay of Scale" maxlength="50" data-toggle="tooltip" data-placement="bottom" title="Enter pay of scale" id="ScaleOfPay">
            </div>
			</div>
            
            <div class="form-group col-sm-12" id="div_BasicPay">
           	<label class="control-label"><font color="red">*</font>Basic Pay</label>
			<div>
                            <input type="text" class="form-control check-total" placeholder="Basic Pay" maxlength="6" data-toggle="tooltip" data-placement="bottom" title="Enter Basic Pay" id="BasicPay">
            </div>
			</div>
            
            <div class="form-group col-sm-12" id="div_GradePay">
           	<label class="control-label">Grade Pay (if not available, do not provide zero(0), leave it blank.)</label>
			<div>
                            <input type="text" class="form-control check-number if-available" placeholder="Grade Pay" maxlength="6" data-toggle="tooltip" data-placement="bottom" title="Enter Grade Pay" id="GradePay">
            </div>
			</div>
            
            
         <!-- end of employee details-->
    
    </div>  <!-- end of col1-->
    
    <div class="col-sm-6">
          <div class="callout bg-info" style="margin-bottom: 0!important;">												
            <i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;Contact Details
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
            <i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;Additional Details
          </div>

        
        <div class="form-group col-sm-12" id="div_Qualification">
			<label class="control-label"><font color="red">*</font>Qualification</label>
            <div>
			<select name="Qualification" id="Qualification" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Qualification">
          </select>
          </div>
     	</div>
       	
        <div class="form-group col-sm-12" id="div_LanguageKnown">
			<label class="control-label"><font color="red">*</font>Languages Known (Other Than Bengali)</label>
            <div>
			<select name="LanguageKnown" id="LanguageKnown" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Known Language">
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
          </select>
          </div>
       </div>
         
         <!-- end of additional details-->
     </div>
     
      <div class="col-sm-6">
             <!-- start of bank detials-->
          <div class="callout bg-info" style="margin-bottom: 0!important;">												
            <i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;Bank Details
          </div>

        
        <div class="form-group col-sm-12" id="div_Bank">
			<label class="control-label"><font color="red">*</font>Bank / Post Office</label>
            <div>
				<select class="form-control select2" name="Bank" id="Bank" data-toggle="tooltip" data-placement="bottom" title="Enter Bank Name">
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
                <input type="text" class="form-control check-acc-no" placeholder="Account Number" name="BankAcNo" id="BankAcNo" data-toggle="tooltip" data-placement="bottom" title="Enter Bank Account Number"  maxlength="20">
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
            <i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;Epic Details
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
            <i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;Assempbly Details
          </div>

       <div class="form-group col-sm-12" id="div_Assembly_temp">
    	<label class="control-label"><font color="red">*</font>Assembly for Present/Temporary Address</label>
        <div>
			<select name="Assembly_temp" id="Assembly_temp" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Assembly Name">
      		</select>
      	</div>
	</div>
           
   <div class="form-group col-sm-12" id="div_Assembly_perm">
		<label class="control-label"><font color="red">*</font>Assembly for Permanent Address/Voter Assembly</label>
        <div>
			<select name="Assembly_perm" id="Assembly_perm" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Assembly Name">
        	 </select>
      	</div>
	</div>

    <div class="form-group col-sm-12" id="div_Assembly_off">
    	<label class="control-label"><font color="red">*</font>Assembly for Place of Posting/Office</label>
       	<div>
        	<select name="VoterOfAssembly" id="Assembly_off" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Enter Voter Of Assembly">
        	</select>
       	</div>
	</div>
    </div>
    <div class="col-sm-6">
        <div class="callout bg-info" style="margin-bottom: 0!important;">
            <i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;Post Status
        </div>
        <div class="form-group col-sm-12">
            <label class="control-label"><font color="red">*</font>Post Status</label>
            <div>
                <select name="PostStatus" id="PostStatus" class="form-control select2" data-toggle="tooltip" data-placement="bottom" title="Select Post Status">
                </select>
            </div>
        </div>
    </div>
	   <div class="form-group col-sm-12">
       <div class="callout callout-info">	
			<i class="fa fa-star"></i><b style="color:#000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Certified that the detail information furnished earlier in PP-1 format and also PP-2 format are verified with office record and genuine. Names of all officials have been included in the PP-2 format and no information has been concealed.</b>
        </div>
      	</div>
    <div class="col-sm-12 text-center">
        <button type="button" class="btn btn-success btn-lg"  id="confirm" ><span><i class="fa fa-save"></i></span>&nbsp;&nbsp;Save</button>
    </div>
     </form><!-- END OF PERSONNEL FORM-->

<script type="text/javascript">
var assembly;
var bank;
var remarks;
var language;
var qualification;
var poststat;

$(function(){
   
    loadAssemblyDetails();
    loadBankDetails();
    loadRemarks();
    loadLanguageDetails();
    loadQualificationDetails();
    loadPostStatus();
    $('#DateOfBirth').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
        format: "YYYY/MM/DD"
        },
        minDate: "1950/01/01",
        maxDate: "1997/12/31"

    });
    
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
    
    $("#confirm").click(function(){
        if(validateForm('personnel_add_form')){     
            if(check_accno()){
                $('#confirmBankAcNo').parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
                $('#BankAcNo').parent("div").parent(".form-group").removeClass("has-error").addClass("has-success");
                
                $('#personnel_add_form').hide();
                $('.overlay').show();
                $('.overlay').find('small').html(' Saving Personnel Data...');
                var result=AddEmployee();
                if(result.Status == 'Success'){
                    $('#report_panel').removeClass('panel-warning').removeClass('panel-danger').addClass('panel-success').show();
                    $('#report_result').html(result.Report);
                }
                else{
                    $('#report_panel').removeClass('panel-warning').removeClass('panel-success').addClass('panel-danger').show();
                    $('#report_result').html(result.Status);
                }
                $('.overlay').hide();
            }
            else{
                $('#confirmBankAcNo').parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
                $('#BankAcNo').parent("div").parent(".form-group").removeClass("has-success").addClass("has-error");
                
                $('#report_panel').removeClass('panel-warning').removeClass('panel-success').addClass('panel-danger').show();
                $('#report_result').html("Mismatch in Bank Account Number. Please Check!!!");
            }
        }
        else{
            $('#report_panel').removeClass('panel-warning').removeClass('panel-success').addClass('panel-danger').show();
            $('#report_result').html("Error in Data Fields. Please Check!!!");
        }
        
        $('#report_result').append("<span class='pull-right'><a href='#' class='show-form'><i class='fa fa-binoculars'></i> Show Form | </a><a href='#' class='new-form'><i class='fa fa-plus-square'></i> Add New PP</a></span>");
                    
        $('.show-form').click(function(e){
            e.preventDefault();
            $('#report_panel').hide();
            $('#personnel_add_form').find('.form-group').removeClass('has-success').removeClass('has-error');
            $('#personnel_add_form').show();
        });

        $('.new-form').click(function(e){
            e.preventDefault();
            $('#report_panel').hide();
            $('#personnel_add_form').find('input').val('');
            $('#personnel_add_form').find('.form-group').removeClass('has-success').removeClass('has-error');
            $('#personnel_add_form').show();
        });
    });
});	

function loadAssemblyDetails(){
    $('.overlay').find('small').html(' Loading Assembly Data...');
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/assembly_details.php',
            success: function(data) {
                    assembly=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "json",
            async: false
    });
    //assembly_combo="<select class='assembly_combo'>";
    for(var i=0; i<assembly.length; i++){
            $('#Assembly_temp').append("<option value='"+assembly[i].AssemblyCode+"'>"+assembly[i].AssemblyName+"</option>");
            $('#Assembly_perm').append("<option value='"+assembly[i].AssemblyCode+"'>"+assembly[i].AssemblyName+"</option>");
            $('#Assembly_off').append("<option value='"+assembly[i].AssemblyCode+"'>"+assembly[i].AssemblyName+"</option>");
    }
    //assembly_combo+="</select>";
    $('#Assembly_temp').select2();
    $('#Assembly_perm').select2();
    $('#Assembly_off').select2();
}

function loadBankDetails(){
    $('.overlay').find('small').html(' Loading Bank Data...');
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/bank_details.php',
            success: function(data) {
                    bank=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "json",
            async: false
    });
    //bank_combo="<select class='bank_combo'>";
    for(var i=0; i<bank.length; i++){
            $('#Bank').append("<option value='"+bank[i].BankCode+"'>"+bank[i].BankName+"</option>");
    }
    $('#Bank').select2();
    //bank_combo+="</select>";
}

function loadRemarks(){
    $('.overlay').find('small').html(' Loading Remarks...');
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/remarks_details.php',
            success: function(data) {
                    remarks=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "json",
            async: false
    });
    //remarks_combo="<select class='remarks_combo'>";
    for(var i=0; i<remarks.length; i++){
            $('#Remarks').append("<option value='"+remarks[i].RemarksCode+"'>"+remarks[i].RemarksName+"</option>");
    }
    //remarks_combo+="</select>";
    $('#Remarks').select2();
}

function loadLanguageDetails(){
    $('.overlay').find('small').html(' Loading Language Details...');
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/language_details.php',
            success: function(data) {
                    language=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "json",
            async: false
    });
    //language_combo="<select class='language_combo'>";
    for(var i=0; i<language.length; i++){
            $('#LanguageKnown').append("<option value='"+language[i].LanguageCode+"'>"+language[i].Language+"</option>");
    }
    //language_combo+="</select>";
    $('#LanguageKnown').select2();
}

function loadQualificationDetails(){
    $('.overlay').find('small').html(' Loading Remarks...');
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/qualification_details.php',
            success: function(data) {
                    qualification=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "json",
            async: false
    });
    //qualification_combo="<select class='qualification_combo'>";
    for(var i=0; i<qualification.length; i++){
            $('#Qualification').append("<option value='"+qualification[i].QualificationCode+"'>"+qualification[i].QualificationName+"</option>");
    }
    //qualification_combo+="</select>";
    $('#Qualification').select2();
        
}

function loadPostStatus(){
    $('.overlay').find('small').html(' Loading Post Status...');
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/poststatus_details.php',
            success: function(data) {
                    poststat=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "json",
            async: false
    });
    //qualification_combo="<select class='qualification_combo'>";
    for(var i=0; i<poststat.length; i++){
            $('#PostStatus').append("<option value='"+poststat[i].post_stat+"'>"+poststat[i].poststatus+"</option>");
    }
    //qualification_combo+="</select>";
    $('#PostStatus').select2();
    $('.overlay').hide();
}

function check_accno()
{
    var ret=0;
    if($('#confirmBankAcNo').val()==$('#BankAcNo').val())
    {
            ret=1;	
    }
    return ret;	
}

function AddEmployee(){
    var result;
    if (document.getElementById("Sexm").checked){
        var sex="M";
    }
    
    if (document.getElementById("Sexf").checked){
        var sex="F";
    }
    
    if (document.getElementById('WorkExperienceY').checked){
        var WorkExperience="YES";
    }
    
    if (document.getElementById('WorkExperienceN').checked){
        var WorkExperience="NO";
    }

    $.ajax({
        url: 'pp_data_post_random/pp_data_add.php',
        type: 'POST',
        data: {
            officecd: $('.officecd').html().toString(),
            EmployeeName: $('#EmployeeName').val(),
            Designation: $('#Designation').val(),
            Sex: sex,
            DateOfBirth: $('#DateOfBirth').val(),
            ScaleOfPay: $('#ScaleOfPay').val(),
            BasicPay: $('#BasicPay').val(),
            GradePay: $('#GradePay').val(),
            Qualification: $('#Qualification').val(),
            LanguageKnown: $('#LanguageKnown').val(),
            WorkExperience: WorkExperience,
            Remarks: $('#Remarks').val(),
            PresentAddress1: $('#PresentAddress1').val(),
            PresentAddress2: $('#PresentAddress2').val(),
            PermanentAddress1: $('#PermanentAddress1').val(),
            PermanentAddress2: $('#PermanentAddress2').val(),
            EmailId: $('#EmailId').val(),
            PhoneNumber: $('#PhoneNumber').val(),
            MobileNumber: $('#MobileNumber').val(),
            Bank: $('#Bank').val(),
            BranchName: $('#BranchName').val(),
            BranchIFSCCode: $('#BranchIFSCCode').val(),
            BankAcNo: $('#BankAcNo').val(),
            EpicNo: $('#EpicNo').val(),
            PartNo: $('#PartNo').val(),
            SerialNo: $('#SerialNo').val(),
            Assembly_perm: $('#Assembly_perm').val(),
            Assembly_temp: $('#Assembly_temp').val(),
            Assembly_off: $('#Assembly_off').val(),
            PostStatus: $('#PostStatus').val()

        },
        success: function(data) {
           result=JSON.parse(JSON.stringify(data));
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Secure insert Error");
        },
        dataType: "json",
        async: false
    });
    return result;
}
</script>