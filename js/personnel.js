// JavaScript Document
/*function GetOfficeEmployeeEntryStatus()
	{
		//alert($('#OfficeCode').val());
		$.ajax({
				url: 'json/office_employee_entry_status.php',
				data: {officecode: $('#OfficeCode').val()},
				type: 'POST',
				success: function(data){
						var retObj = JSON.parse(JSON.stringify(data));
						$('#OfficeEmployeeEntryStatus h4').html('Office PP Entry Status: Total Staff in PP1: '+retObj.TotalStaff+', || Total Staff in PP2: '+retObj.EntryStaff+', || Remaining: '+retObj.DiffStaff);
						if(retObj.DiffStaff > 0)
							$("#OfficeEmployeeEntryStatus h4").addClass("alert alert-danger");
						else
							$('#OfficeEmployeeEntryStatus h4').addClass('alert alert-success');
						$('#OfficeEmployeeEntryStatus').show('blind',500);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert(textStatus);
				},
				dataType: "json",
				async: false
			});	
	}
*/	
function LoadPersonnelDetailsForm(emp_id)
{
	$('#page_content').load('forms/update_personnel_form.php');
	//LoadPersonnelDataFields(emp_id);
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/personneldetails.php',
		type: 'POST',
		data: {EmpID : emp_id
	           },
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Office Update Form*/
			$('#show_emp_name').html(emp_id);
			$('#OfficeCode').val(retObj.officecd);
			//GetOfficeEmployeeEntryStatus();
			//$('#EmployeeCd').val(retObj.personcd);
			$('#EmployeeName').val(retObj.officer_name);
			$('#Designation').val(retObj.off_desg);
			
			if(retObj.gender=="M")
			{
				$('#Sexm').prop('checked',true);}
			else
			{
				$('#Sexf').prop('checked',true);}
			
			//$('#AdharNo').val(retObj.adharno);
			$('#DateOfBirth').val(retObj.dateofbirth);
			$('#ScaleOfPay').val(retObj.scale);
			$('#BasicPay').val(retObj.basic_pay);
			$('#GradePay').val(retObj.grade_pay);
			
			if(retObj.workingstatus=="YES")
			{$('#WorkExperienceY').prop('checked',true);}
			else
			{$('#WorkExperienceN').prop('checked',true);}
			//Load Selected Qualification
			    $.getScript('js/Qualification.js');
			    LoadQualificationDetails('Qualification',retObj.qualificationcd);
			//Load Selected Language
			    $.getScript('js/Language.js');
				LoadLanguageDetails('LanguageKnown',retObj.languagecd);
			//Load Selected Remarks
			    $.getScript('js/Remarks.js');
				LoadRemarksDetails('Remarks',retObj.remarks);
			$('#PresentAddress1').val(retObj.present_addr1);
			$('#PresentAddress2').val(retObj.present_addr2);
			
			$('#PermanentAddress1').val(retObj.perm_addr1);
			$('#PermanentAddress2').val(retObj.perm_addr2);
			//$.getScript('js/District.js');
			LoadDistrictDetails('District',retObj.districtcd);
			//$.getScript('js/Subdivision.js');
			LoadSubdivisionDetails('Subdivision',retObj.subdivisioncd);
		    
			$('#EmailId').val(retObj.email);
			$('#PhoneNumber').val(retObj.resi_no);
			$('#MobileNumber').val(retObj.mob_no);
			
			//Load Selected Bank
			//$.getScript('js/Bank.js');
			LoadBankDetails('Bank',retObj.bank_cd);
				
			$('#BranchName').val(retObj.branchname);
			$('#BranchIFSCCode').val(retObj.branchcd);
			
			$('#BankAcNo').val(retObj.bank_acc_no);
			$('#EpicNo').val(retObj.epic);
			$('#PartNo').val(retObj.partno);
			$('#SerialNo').val(retObj.slno);
			
			
			//$('#EmpButton').html('<span><i class="fa fa-save"></i></span>Update');
			
			//LOADING EACH ASSEMBLY
			LoadAssemblyDetails(retObj.assembly_temp,retObj.assembly_perm,retObj.assembly_off);

			$('#confirm').val(emp_id);
			//$('.preloader').hide();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
		
	});
	
}

function LoadPersonnelDataFields(emp_id)
{	//$('.preloader').show();
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/personneldetails.php',
		type: 'POST',
		data: {EmpID : emp_id
	           },
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Office Update Form*/
			$('#show_emp_name').html(emp_id);
			$('#OfficeCode').val(retObj.officecd);
			//GetOfficeEmployeeEntryStatus();
			//$('#EmployeeCd').val(retObj.personcd);
			$('#EmployeeName').val(retObj.officer_name);
			$('#Designation').val(retObj.off_desg);
			
			if(retObj.gender=="M")
			{
				$('#Sexm').prop('checked',true);}
			else
			{
				$('#Sexf').prop('checked',true);}
			
			//$('#AdharNo').val(retObj.adharno);
			$('#DateOfBirth').val(retObj.dateofbirth);
			$('#ScaleOfPay').val(retObj.scale);
			$('#BasicPay').val(retObj.basic_pay);
			$('#GradePay').val(retObj.grade_pay);
			
			if(retObj.workingstatus=="YES")
			{$('#WorkExperienceY').prop('checked',true);}
			else
			{$('#WorkExperienceN').prop('checked',true);}
			//Load Selected Qualification
			    $.getScript('js/Qualification.js');
			    LoadQualificationDetails('Qualification',retObj.qualificationcd);
			//Load Selected Language
			    $.getScript('js/Language.js');
				LoadLanguageDetails('LanguageKnown',retObj.languagecd);
			//Load Selected Remarks
			    $.getScript('js/Remarks.js');
				LoadRemarksDetails('Remarks',retObj.remarks);
			$('#PresentAddress1').val(retObj.present_addr1);
			$('#PresentAddress2').val(retObj.present_addr2);
			
			$('#PermanentAddress1').val(retObj.perm_addr1);
			$('#PermanentAddress2').val(retObj.perm_addr2);
			//$.getScript('js/District.js');
			LoadDistrictDetails('District',retObj.districtcd);
			//$.getScript('js/Subdivision.js');
			LoadSubdivisionDetails('Subdivision',retObj.subdivisioncd);
		    
			$('#EmailId').val(retObj.email);
			$('#PhoneNumber').val(retObj.resi_no);
			$('#MobileNumber').val(retObj.mob_no);
			
			//Load Selected Bank
			//$.getScript('js/Bank.js');
			LoadBankDetails('Bank',retObj.bank_cd);
				
			$('#BranchName').val(retObj.branchname);
			$('#BranchIFSCCode').val(retObj.branchcd);
			
			$('#BankAcNo').val(retObj.bank_acc_no);
			$('#EpicNo').val(retObj.epic);
			$('#PartNo').val(retObj.partno);
			$('#SerialNo').val(retObj.slno);
			
			
			//$('#EmpButton').html('<span><i class="fa fa-save"></i></span>Update');
			
			//LOADING EACH ASSEMBLY
			LoadAssemblyDetails(retObj.assembly_temp,retObj.assembly_perm,retObj.assembly_off);

			$('#confirm').val(emp_id);
			//$('.preloader').hide();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
		
	});
}

function DeletePersonnel(emp_id)
{
$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/delete_emp.php',
		data: {emp:emp_id},
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			alert(retObj);
			$('#page_content').load('php/del_emp.php');
			
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});	
}