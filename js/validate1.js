// JavaScript Document
function validateOffice()
{
			OfficeName= $('#OfficeName').val();
			OfficeId= $('#OfficeId').val();
			Designation= $('#Designation').val();
			Street= $('#Street').val();
			Town= $('#Town').val(); 
			PostOffice= $('#PostOffice').val();
			PoliceStation= $('#PoliceStation').val();
			Municipality= $('#Municipality').val();
			District= $('#District').val();
			PinCode= $('#PinCode').val();
			StatusOfOffice= $('#StatusOfOffice').val();
			NatureOfOffice= $('#NatureOfOffice').val();
			EmailId= $('#EmailId').val();
			PhoneNumber= $('#PhoneNumber').val();
			MobileNumber= $('#MobileNumber').val();
			FaxNo= $('#FaxNo').val();
			TotalMaleStaffs= $('#TotalMaleStaffs').val();
			TotalFemaleStaffs= $('#TotalFemaleStaffs').val();
			TotalNumberofStaffs= $('#TotalNumberofStaffs').val();
			
	if(OfficeName=="")
	{
		$('#div_OfficeName').removeClass('has-success').addClass('has-error');
		$('#OfficeName').focus();
		return false;
	}
	else
	{
		$('#div_OfficeName').removeClass('has-error').addClass('has-success');	
	}
	
	if(OfficeId!="")
	{
		$('#div_OfficeId').removeClass('has-error').addClass('has-success');	
			
	}
	
	if(Designation=="")
	{
		$('#div_Designation').removeClass('has-success').addClass('has-error');
		$('#Designation').focus();
		return false;
	}
	else
	{
		$('#div_Designation').removeClass('has-error').addClass('has-success');	
	}
	if(Street=="")
	{
		$('#div_Street').removeClass('has-success').addClass('has-error');
		$('#Street').focus();
		return false;
	}
	else
	{
		$('#div_Street').removeClass('has-error').addClass('has-success');	
	}
	if(Town=="")
	{
		$('#div_Town').removeClass('has-success').addClass('has-error');
		$('#Town').focus();
		return false;
	}
	else
	{
		$('#div_Town').removeClass('has-error').addClass('has-success');	
	}
	if(PostOffice=="")
	{
		$('#div_PostOffice').removeClass('has-success').addClass('has-error');
		$('#PostOffice').focus();
		return false;
	}
	else
	{
		//if(numbercheck('PostOffice')){return false;}
		$('#div_PostOffice').removeClass('has-error').addClass('has-success');
	}

	if(PoliceStation=="")
	{
		$('#div_PoliceStation').removeClass('has-success').addClass('has-error');
		$('#PoliceStation').focus();
		return false;
	}
	else
	{
		$('#div_PoliceStation').removeClass('has-error').addClass('has-success');
	}
	if(Municipality=="")
	{
		$('#div_Municipality').removeClass('has-success').addClass('has-error');
		$('#Municipality').focus();
		return false;
	}
	else
	{
		$('#div_Municipality').removeClass('has-error').addClass('has-success');
	}
	if(District=="")
	{
		$('#div_District').removeClass('has-success').addClass('has-error');
		$('#District').focus();
		return false;
	}
	else
	{
		$('#div_District').removeClass('has-error').addClass('has-success');
	}
	
	if(PinCode=="")
	{
		$('#div_PinCode').removeClass('has-success').addClass('has-error');
		$('#PinCode').focus();
		return false;
	}
	else
	{
		var ckpin= /^([0-9]{6})$/;
		if(!(ckpin.test(PinCode) )){
		$('#div_PinCode').removeClass('has-success').addClass('has-error');
		$('#PinCode').focus();
		return false;
		}
		$('#div_PinCode').removeClass('has-error').addClass('has-success');
	}
	
	

	
	if(StatusOfOffice=="")
	{
		$('#div_StatusOfOffice').removeClass('has-success').addClass('has-error');
		$('#StatusOfOffice').focus();
		return false;
	}
	else
	{
		$('#div_StatusOfOffice').removeClass('has-error').addClass('has-success');	
	}
	if(NatureOfOffice=="")
	{
		$('#div_NatureOfOffice').removeClass('has-success').addClass('has-error');
		$('#NatureOfOffice').focus();
		return false;
	}
	else
	{
		$('#div_NatureOfOffice').removeClass('has-error').addClass('has-success');	
	}

	
	if(!emailaddresscheck('EmailId')){return false;}
	
	if(PhoneNumber!="")
	{
		if(!lengthcheckforphone('PhoneNumber')){return false;}
		
		if(!charactercheck('PhoneNumber')){return false;}
		
	}
	
	if(MobileNumber=="")
	{
		$('#div_MobileNumber').removeClass('has-success').addClass('has-error');
		$('#MobileNumber').focus();
		return false;
	}
	else
	{
		if(!lengthcheckformobile('MobileNumber')){return false;}
		if(!charactercheck('MobileNumber')){return false;}
	}
	

	if(TotalNumberofStaffs=="")
	{
		$('#div_TotalNumberofStaffs').removeClass('has-success').addClass('has-error');
		$('#TotalNumberofStaffs').focus();
		return false;
	}
	else
	{
		if(!charactercheck('TotalNumberofStaffs')){return false;}
		if(!charactercheck('TotalMaleStaffs')){return false;}
		if(!charactercheck('TotalFemaleStaffs')){return false;}
	if((+TotalMaleStaffs + +TotalFemaleStaffs)==TotalNumberofStaffs)
	{
		$('#div_TotalMaleStaffs').removeClass('has-error').addClass('has-success');
			$('#div_TotalFemaleStaffs').removeClass('has-error').addClass('has-success');
			$('#div_TotalNumberofStaffs').removeClass('has-error').addClass('has-success');	
		return 1;
	}
	else{
			
			$('#div_TotalMaleStaffs').removeClass('has-success').addClass('has-error');
			$('#div_TotalFemaleStaffs').removeClass('has-success').addClass('has-error');
			$('#div_TotalNumberofStaffs').removeClass('has-success').addClass('has-error');
			$('#TotalNumberofStaffs').focus();
			return false;
	}
	}
}
// JavaScript Document

function validateemp()
{
	
	var EmployeeName=$("#EmployeeName").val();
	var Designation=$("#Designation").val();
	var DateOfBirth=$("#DateOfBirth").val();
	
	//var Scaleofpay=document.getElementById("Sex1").value;
	
	var ScaleOfPay=$("#ScaleOfPay").val();
	var BasicPay=$("#BasicPay").val();
	var GradePay=$("#GradePay").val();
	
	
	var PresentAddress1=$("#PresentAddress1").val();
	var PresentAddress2=$("#PresentAddress2").val();
	var SameAddress=$("#SameAddress").checked;
	var PermanentAddress1=$("#PermanentAddress1").val();
	var PermanentAddress2=$("#PermanentAddress2").val();
	
	
	var PhoneNumber=$("#PhoneNumber").val();
	var MobileNumber=$("#MobileNumber").val();
	var EmailId=$("#EmailId").value;
	
	
	var Qualification=$("#Qualification").value;
	var LanguageKnown=$("#LanguageKnown").value;	
	var Remarks=$("#Remarks").value;
		

	var Bank=$("#Bank");
	var BranchName=$("#BranchName").value;
	var BankAcNo=$("#BankAcNo").value;
	var BranchIFSCCode=$("#BranchIFSCCode").value;
	
	
	var EpicNo=$("#EpicNo").value;
	var PartNo=$("#PartNo").value;
	var SerialNo=$("#SerialNo").value;
	
	var Assembly1=$("#Assembly1").value;
	var Assembly2=$("#Assembly2").value;
	var Assembly3=$("#Assembly3").value;
	var VoterOfAssembly=$("#VoterOfAssembly").value;
	//var District=$("#District").value;
	//var Subdivision=$("#Subdivision").value;

/*
	if(EmployeeName=="")
	{
		$('#div_EmployeeName').removeClass('has-success').addClass('has-error');
		$('#EmployeeName').focus();
		return false;
	}
	else{
		if(!namecheck('EmployeeName')){return false;}
	}
	if(Designation=="")
	{
		$('#div_Designation').removeClass('has-success').addClass('has-error');
		$('#Designation').focus();
		return false;
	}
	else{
		$('#div_Designation').removeClass('has-error').addClass('has-success');
	}
	if(DateOfBirth=="")
	{
		$('#div_DateOfBirth').removeClass('has-success').addClass('has-error');
		$('#DateOfBirth').focus();
		return false;
	}
	else{
		$('#div_DateOfBirth').removeClass('has-error').addClass('has-success');
	}
	if(ScaleOfPay=="")
	{
		$('#div_ScaleOfPay').removeClass('has-success').addClass('has-error');
		$('#ScaleOfPay').focus();
		return false;
	}
	else{
		if(!blankcheck('ScaleOfPay')){return false;}
		//$('#div_ScaleOfPay').removeClass('has-error').addClass('has-success');
	}
	if(BasicPay=="")
	{
		$('#div_BasicPay').removeClass('has-success').addClass('has-error');
		$('#BasicPay').focus();
		return false;
	}
     else{
		 if(!blankcheck('BasicPay')){return false;}
		 if(!charactercheck('BasicPay')){return false;}
	}
	if(GradePay=="")
	{
		$('#div_GradePay').removeClass('has-success').addClass('has-error');
		$('#GradePay').focus();
		return false;
	}
	else{
		 if(!blankcheck('GradePay')){return false;}
		 if(!charactercheck('GradePay')){return false;}
	}
	
	
	if(PresentAddress1=="")
	{
		$('#div_PresentAddress1').removeClass('has-success').addClass('has-error');
		$('#PresentAddress1').focus();
		return false;
	}
	else{
		$('#div_PresentAddress1').removeClass('has-error').addClass('has-success');
	}
	if(PresentAddress2=="")
	{
		$('#div_PresentAddress2').removeClass('has-success').addClass('has-error');
		$('#PresentAddress2').focus();
		return false;
	}
	else{
		$('#div_PresentAddress2').removeClass('has-error').addClass('has-success');
	}
	
	if(PermanentAddress1=="")
	{
		$('#div_PermanentAddress1').removeClass('has-success').addClass('has-error');
		$('#PermanentAddress1').focus();
		return false;
	}
	else{
		$('#div_PermanentAddress1').removeClass('has-error').addClass('has-success');
	}
	if(PermanentAddress2=="")
	{
		$('#div_PermanentAddress2').removeClass('has-success').addClass('has-error');
		$('#PermanentAddress2').focus();
		return false;
	}
	else{
		$('#div_PermanentAddress2').removeClass('has-error').addClass('has-success');
	}

	
	
	
	if(Qualification=="Select Qualification")
	{
		alert("Select Qualification");
		$("#EmployeeQualification").addClass("form-group has-error has-feedback");
		$("Qualification").focus();
		return 0;
	}
	else{
		$("#EmployeeQualification").removeClass("form-group has-error has-feedback");
		$("#EmployeeQualification").addClass("form-group has-success has-feedback");
	}
	if(LanguageKnown=="Select Language")
	{
		alert("Select Language");
		$("#EmployeeLanguageKnown").addClass("form-group has-error has-feedback");
		$("LanguageKnown").focus();
		return 0;
	}
	else{
		$("#EmployeeLanguageKnown").removeClass("form-group has-error has-feedback");
		$("#EmployeeLanguageKnown").addClass("form-group has-success has-feedback");
	}
	
	if(Remarks=="Select Remarks")
	{
		alert("Select Remarks");
		$("#EmployeeRemarks").addClass("form-group has-error has-feedback");
		$("Remarks").focus();
		return 0;
	}
	else{
		$("#EmployeeRemarks").removeClass("form-group has-error has-feedback");
		$("#EmployeeRemarks").addClass("form-group has-success has-feedback");
	}
	
	
	/*if(EmailId=="")
	{
		alert("Enter Email address");
		$("#EmailId").addClass("form-group has-error has-feedback");
		$("EmailId").focus();
		return 0;
	}
	else{
		$("#EmailId").removeClass("form-group has-error has-feedback");
		$("#EmailId").addClass("form-group has-success has-feedback");
	}
 
    if((PhoneNumber == "") && PhoneNumber != /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/){
    alert("Enter valid phone no");
	$("#PhoneNumber").addClass("form-group has-error has-feedback");
	$("PhoneNumber").focus();
	return 0;
    }
	
	else{
		$("#PhoneNumber").removeClass("form-group has-error has-feedback");
		$("#PhoneNumber").addClass("form-group has-success has-feedback");
	}
	if(MobileNumber=="")
	{
		alert("Enter Mobile Number");
		$("#MobileNumber").addClass("form-group has-error has-feedback");
		$("MobileNumber").focus();
		return 0;
	}
	else{
		$("#MobileNumber").removeClass("form-group has-error has-feedback");
		$("#MobileNumber").addClass("form-group has-success has-feedback");
	}

	if(Bank=="Select Bank")
	{
		alert("Select Bank");
		$("#Bank").addClass("form-group has-error has-feedback");
		$("Bank").focus();
		return 0;
	}
	else{
		$("#Bank").removeClass("form-group has-error has-feedback");
		$("#Bank").addClass("form-group has-success has-feedback");
	}
	
	if(BranchName=="")
	{
		alert("Enter Branch Name");
		$("#BranchName").addClass("form-group has-error has-feedback");
		$("BranchName").focus();
		return 0;
	}
	else{
		$("#BranchName").removeClass("form-group has-error has-feedback");
		$("#BranchName").addClass("form-group has-success has-feedback");
	}
	if(BranchIFSCCode=="")
	{
		alert("Enter Branch IFSC Code");
		$("#BranchIFSCCode").addClass("form-group has-error has-feedback");
		$("BranchIFSCCode").focus();
		return 0;
		
	}
	else{
		$("#BranchIFSCCode").removeClass("form-group has-error has-feedback");
		$("#BranchIFSCCode").addClass("form-group has-success has-feedback");
	}
	if(BankAcNo=="")
	{
		alert("Enter Bank Account Number");
		$("#BankAcNo").addClass("form-group has-error has-feedback");
		$("BankAcNo").focus();
		return 0;
		
	}
	else{
		$("#BankAcNo").removeClass("form-group has-error has-feedback");
		$("#BankAcNo").addClass("form-group has-success has-feedback");
	}
	if(EpicNo=="")
	{
		alert("Enter Epic Number");
		$("#EpicNo").addClass("form-group has-error has-feedback");
		$("EpicNo").focus();
		return 0;
	}
	else{
		$("#EpicNo").removeClass("form-group has-error has-feedback");
		$("#EpicNo").addClass("form-group has-success has-feedback");
	}
	if(PartNo=="")
	{
		alert("Enter Part Number");
		$("#PartNo").addClass("form-group has-error has-feedback");
		$("PartNo").focus();
		return 0;
	}
	else{
		$("#PartNo").removeClass("form-group has-error has-feedback");
		$("#PartNo").addClass("form-group has-success has-feedback");
	}
	if(SerialNo=="")
	{
		alert("Enter Serial Number");
		$("#SerialNo").addClass("form-group has-error has-feedback");
		$("SerialNo").focus();
		return 0;
	}
	else{
		$("#SerialNo").removeClass("form-group has-error has-feedback");
		$("#SerialNo").addClass("form-group has-success has-feedback");
	}
	if(Assembly1=="Select Assembly")
	{
		alert("Select Present Address");
		$("#Assembly1").addClass("form-group has-error has-feedback");
		$("Assembly1").focus();
		return 0;
		
	}
	else{
		$("#Assembly1").removeClass("form-group has-error has-feedback");
		$("#Assembly1").addClass("form-group has-success has-feedback");
	}
	if(Assembly2=="Select Assembly")
	{
		alert("Select Permanent Address");
		$("#Assembly2").addClass("form-group has-error has-feedback");
		$("Assembly2").focus();
		return 0;
		
	}
	else{
		$("#Assembly2").removeClass("form-group has-error has-feedback");
		$("#Assembly2").addClass("form-group has-success has-feedback");
	}
	if(Assembly3=="Select Assembly")
	{
		alert("Select Place Of Posting");
		$("#Assembly3").addClass("form-group has-error has-feedback");
		$("Assembly3").focus();
		return 0;
		
	}
	else{
		$("#Assembly3").removeClass("form-group has-error has-feedback");
		$("#Assembly3").addClass("form-group has-success has-feedback");
	}
	if(VoterOfAssembly=="Select Assembly")
	{
		alert("Select Voter Of Assembly");
		$("#VoterOfAssembly").addClass("form-group has-error has-feedback");
		$("VoterOfAssembly").focus();
		return 0;
		
	}
	else{
		$("#VoterOfAssembly").removeClass("form-group has-error has-feedback");
		$("#VoterOfAssembly").addClass("form-group has-success has-feedback");
	}
*/
	return 1;
}




function validateofficesdo()
{
	var officename=document.getElementById("OfficeName").value;
	var designationOic=document.getElementById("Designation").value;
	var Street=document.getElementById("Street").value;
	var Town=document.getElementById("Town").value;
	var PostOffice=document.getElementById("PostOffice").value;
	var PoliceStation=document.getElementById("PoliceStation").value;
	var Municipality=document.getElementById("Municipality").value;
	var District=document.getElementById("District").value;
	var Pincode=document.getElementById("PinCode").value;
	var Statusofoffice=document.getElementById("StatusOfOffice").value;
	var Natureofoffice=document.getElementById("NatureOfOffice").value;
	var ExistingStaff=document.getElementById("TotalNumberofStaffs").value;
	var MaleStaff=document.getElementById("TotalMaleStaffs").value;
	var FemaleStaff=document.getElementById("TotalFemaleStaffs").value;
	var EmailId=document.getElementById("EmailId").value;
	if(officename=="")
	{
		alert("Enter the office name");
	    $("#OfficeName").addClass("form-group has-error has-feedback");
		document.getElementById("OfficeName").focus();
		return 0;
	}
	else{
		$("#OfficeName").removeClass("form-group has-error has-feedback");
		$("#OfficeName").addClass("form-group has-success has-feedback");
	}
	if(designationOic=="")
	{
		alert("Enter the designation Of Office In Charge");
		document.getElementById("Designation").focus();
		return 0;
	}
	if(Street=="")
	{
		alert("Enter the Para/Tola/Street");
		document.getElementById("Street").focus();
		return 0;
	}
	if(Town=="")
	{
		alert("Enter the Town");
		document.getElementById("Town").focus();
		return 0;
	}
	if(PostOffice=="")
	{
		alert("Enter the name of the post office");
		document.getElementById("PostOffice").focus();
		return 0;
	}

	if(Subdivision=="Select Subdivision Name")
	{
		alert("Select Subdivision name");
		document.getElementById("Subdivision").focus();
		return 0;
	}
	if(PoliceStation=="Select Police Station Name")
	{
		alert("Select Police Station name");
		document.getElementById("PoliceStation").focus();
		return 0;
	}
	if(Municipality=="Select Block/Municipality Name")
	{
		alert("Select Municipality name");
		document.getElementById("Municipality").focus();
		return 0;
	}
	if(District=="")
	{
		alert("Enter the name of District");
		document.getElementById("District").focus();
		return 0;
	}
	if(Pincode=="")
	{
		alert("Enter the Pin Code");
		document.getElementById("PinCode").focus();
		return 0;
	}
	
	var ckpin= /^([0-9]{6})$/;
	if(!(ckpin.test(Pincode) )){
		alert("Enter valid pin code");
		document.getElementById("PinCode").focus();
		return 0;
	}
	
	if(Statusofoffice=="Select Status Of Office")
	{
		alert("Select the Status of office");
		document.getElementById("StatusOfOffice").focus();
		return 0;
	}
	if(Natureofoffice=="Select Nature Of Office")
	{
		alert("Select Nature of office");
		document.getElementById("NatureOfOffice").focus();
		return 0;
	}
	var emailfilter = /(([a-zA-Z0-9\-?\.?]+)@(([a-zA-Z0-9\-_]+\.)+)([a-z]{2,3}))+$/;
	if((EmailId != "") && (!(emailfilter.test(EmailId ) ) )) {
    alert("Enter valid email address");
	document.getElementById("EmailId").focus();
	return 0;
	}
	if(ExistingStaff=="")
	{
		alert("Enter Number of Existing Staff");
		document.getElementById("ExistingStaff").focus();
		return 0;
	}
	if(MaleStaff!="0" || FemaleStaff!="0")
	{
		if((+MaleStaff + +FemaleStaff)!=ExistingStaff)
		{
			alert("Male, Female & Total Existing Staff No not matching");
			document.getElementById("TotalNumberOfStaffs").focus();
			return 0;
		}
	}
	else{
		return 1;
	}
}
