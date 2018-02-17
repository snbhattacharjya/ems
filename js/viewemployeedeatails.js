// JavaScript Document
//Defination of LoadPersonnelDetailsForm
function LoadPersonnelDetailsForm(eid)
{
	//var x = document.getAttribute("onclick").getElementById("eid");
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'forms/viewemployee.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Office Update Form*/
			$('#EmployeeName').val(retObj.officer_name);
			$('#Designation').val(retObj.off_desg);
			$('#DateOfBirth').val(retObj.dateofbirth);
			$('#ScaleOfPay').val(retObj.scale);
			$('#BasicPay').val(retObj.basic_pay);
			$('#GradePay').val(retObj.grade_pay);
			$('#Qualification').val(retObj.qualificationcd);
			$('#LanguageKnown').val(retObj.languagecd);
			$('#Remarks').val(retObj.remarks);
			$('#PresentAddress1').val(retObj.present_addr1);
			$('#PresentAddress2').val(retObj.present_addr2);
			$('#PermanentAddress1').val(retObj.perm_addr1);
			$('#PermanentAddress2').val(retObj.perm_addr2);
			$('#EmailId').val(retObj.email);
			$('#PhoneNumber').val(retObj.resi_no);
			$('#MobileNumber').val(retObj.mob_no);
			$('#Bank').val(retObj.bank_cd);
			$('#BranchName').val(retObj.branchname);
			$('#BranchIFSCCode').val(retObj.branchcd);
			$('#BankAcNo').val(retObj.bank_acc_no);
			$('#EpicNo').val(retObj.epic);
			$('#PartNo').val(retObj.partno);
			$('#SerialNo').val(retObj.slno);
			$('#Assembly1').val(retObj.poststat);
			$('#Assembly2').val(retObj.assembly_temp);
			$('#Assembly3').val(retObj.assembly_off);
			$('#VoterOfAssembly').val(retObj.assembly_perm);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
		
	});
}