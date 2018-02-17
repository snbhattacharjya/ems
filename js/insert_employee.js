function AddEmployee()
{
	var ret_empcode;
		if (document.getElementById("Sexm").checked) {
        	var sex="M";
		
    	}
    	if (document.getElementById("Sexf").checked) {
        	var sex="F";
    	}
		
		if (document.getElementById('WorkExperienceY').checked) {
        	var WorkExperience="YES";
    	}
    	if (document.getElementById('WorkExperienceN').checked) {
        	var WorkExperience="NO";
   	    }

	$.ajax({
		url: 'php/insertpersonnel.php',
		type: 'POST',
		data: {
			//OfficeCD: $('#OfficeCode').val(),
			request_type:1,
			EmployeeName: $('#EmployeeName').val(),
			Designation: $('#Designation').val(),
			//AdharNumber: $('#AdharNo').val(),
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
			//District: $('#District').val(),
			//Subdivision: $('#Subdivision').val(),
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
			//Assembly1: $('#Assembly1').val(),
			Assembly_perm: $('#Assembly_perm').val(),
			Assembly_temp: $('#Assembly_temp').val(),
			Assembly_off: $('#Assembly_off').val(),
			//Photo: $('#photo').val()
			
		},
		success: function(data) {
			//var retObj = JSON.parse(JSON.stringify(data));
	        //LoadBankDetails('Bank',retObj.bank_cd);
			ret_empcode=data;
			//$('#confirm').hide();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Secure insert Error");
		},
		dataType: "html",
		async: false
	});
	return ret_empcode;
}
//Update employee ajax function definition
function UpdateEmployee(empid)
	{
		if (document.getElementById("Sexm").checked) {
        	var sex="M";
		
    	}
    	if (document.getElementById("Sexf").checked) {
        	var sex="F";
    	}
		if (document.getElementById('WorkExperienceY').checked) {
        	var WorkExperience="YES";
    	}
    	if (document.getElementById('WorkExperienceN').checked) {
        	var WorkExperience="NO";
   	    }
		
	$.ajax({
		url: 'php/updatepersonnel.php',
		type: 'POST',
		data: {
			request_type:1,
			EmployeeCd: empid,
			EmployeeName: $('#EmployeeName').val(),
			Designation: $('#Designation').val(),
			//AdharNumber: $('#AdharNo').val(),
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
			//District: $('#District').val(),
			//Subdivision: $('#Subdivision').val(),
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
			//Assembly1: $('#Assembly1').val(),
			Assembly_perm: $('#Assembly_perm').val(),
			Assembly_temp: $('#Assembly_temp').val(),
			Assembly_off: $('#Assembly_off').val(),
			//Photo: $('#photo').val()
		},
		success: function(data) {
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Secure insert Error");
		},
		dataType: "html",
		async: false
	});
}