// JavaScript Document
function validate(){
if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	   	xmlhttp1=new XMLHttpRequest();
		xmlhttp2=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	   	xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  /*if (xmlhttp.readyState==1)
	  {
		 document.getElementById("loadingDiv").innerHTML = "<img src='images/loading.gif'/>";
	  }*/
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("Block_result").innerHTML=xmlhttp.responseText;
		}
	  }
	  xmlhttp1.onreadystatechange=function()
	  {
	  if (xmlhttp1.readyState==4 && xmlhttp1.status==200)
		{
			document.getElementById("Police_Station").innerHTML=xmlhttp1.responseText;
		}
	  }
	  xmlhttp2.onreadystatechange=function()
	  {
	  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			document.getElementById("ofcid").innerHTML=xmlhttp2.responseText;
		}
	  }
	xmlhttp.open("GET","ajaxfun.php?subdiv="+str,true);
	xmlhttp1.open("GET","ajaxfun.php?subdiv="+str+"&pol=n",true);
	xmlhttp2.open("GET","ajaxfun.php?subdiv="+str+"&ofcid=n",true);
	xmlhttp.send();
	xmlhttp1.send();
	xmlhttp2.send();
}

function email_valid()
{
	var EmailId = document.getElementById('email').value;
	var emailfilter = /(([a-zA-Z0-9\-?\.?]+)@(([a-zA-Z0-9\-_]+\.)+)([a-z]{2,3}))+$/;
	if((EmailId != "") && (!(emailfilter.test(EmailId ) ) )) {
    //alert("Enter valid email address!");
	document.getElementById('email').style.borderColor="#F00";
	document.getElementById('email').style.backgroundColor="#FCF";
	return false;
	}
}
function count_totalstaff()
{
	var ExistingStaff=document.getElementById("ExistingStaff").value;
	var malestaff=document.getElementById("MaleStaff").value;
	var femalestaff=document.getElementById("FemaleStaff").value;
	if(malestaff=="")
		document.getElementById("MaleStaff").value=0;
	if(femalestaff=="")
		document.getElementById("FemaleStaff").value=0;
	document.getElementById("ExistingStaff").value=(parseInt(document.getElementById("MaleStaff").value,10) + parseInt(document.getElementById("FemaleStaff").value,10));
}
function validate()
{
	var EmployeeName=document.getElementById("EmployeeName").value;
	var Designation=document.getElementById("Designation").value;
	var Dob=document.getElementById("DateOfBirth").value;
	var Sex=document.getElementById("Sex").value;
	var ScaleOfPay=document.getElementById("ScaleOfPay").value;
	var BasicPay=document.getElementById("BasicPay").value;
	var GradePay=document.getElementById("GradePay").value;
	var PresentAddress1=document.getElementById("PresentAddress1").value;
	var PresentAddress2=document.getElementById("PresentAddress2").value;
	var PresentAddress3=document.getElementById("PresentAddress3").value;
	var PermanentAddress1=document.getElementById("PermanentAddress1").value;
	var PermanentAddress2=document.getElementById("PermanentAddress2").value;
	var PermanentAddress3=document.getElementById("PermanentAddress3").value;
	var EmailId=document.getElementById("EmailId").value;
    var PhoneNumber=document.getElementById("PhoneNumber").value;
	var MobileNumber=document.getElementById("MobileNumber").value;
	var Bank=document.getElementById("Bank").value;
	var BranchName=document.getElementById("BranchName").value;
	var BankAcNo=document.getElementById("BankAcNo").value;
	var BranchIFSCCOde=document.getElementById("BranchIFSCCode").value;
	var EpicNo=document.getElementById("EpicNo").value;
	var PartNo=document.getElementById("PartNo.").value;
	var SerialNo=document.getElementById("SerialNo.").value;
	//var Assembly1=document.getElementById("Assembly1").value;
	var Assembly2=document.getElementById("Assembly2.").value;
	var Assembly3=document.getElementById("Assembly3.").value;
	var EpicNo=document.getElementById("EpicNo.").value;
	

	if(officename=="")
	{
		document.getElementById("msg").innerHTML="Enter Name Of Office";
		document.getElementById("officename").focus();
		return false;
	}
	if(designationOic=="")
	{
		document.getElementById("msg").innerHTML="Enter Designation of office-in-charge";
		document.getElementById("designationOic").focus();
		return false;
	}
	if(Street=="")
	{
		document.getElementById("msg").innerHTML="Enter the name of Para/Tola/Street";
		document.getElementById("Street").focus();
		return false;
	}
	if(Town=="")
	{
		document.getElementById("msg").innerHTML="Enter the name of Vill/Town/Metro";
		document.getElementById("Town").focus();
		return false;
	}
	if(PostOffice=="")
	{
		document.getElementById("msg").innerHTML="Enter the name of Post Ofice";
		document.getElementById("PostOffice").focus();
		return false;
	}

	if(Subdivision=="0")
	{
		document.getElementById("msg").innerHTML="Select Subdivision name";
		document.getElementById("Subdivision").focus();
		return false;
	}
	if(PoliceStation=="0")
	{
		document.getElementById("msg").innerHTML="Select Police Station name";
		document.getElementById("PoliceStation").focus();
		return false;
	}
	if(Municipality=="0")
	{
		document.getElementById("msg").innerHTML="Select Municipality name";
		document.getElementById("Municipality").focus();
		return false;
	}
	if(District=="")
	{
		document.getElementById("msg").innerHTML="Enter the name of District";
		document.getElementById("District").focus();
		return false;
	}
	if(Pincode=="")
	{
		document.getElementById("msg").innerHTML="Enter the Pin Code";
		document.getElementById("Pincode").focus();
		return false;
	}
	if(Pincode.length<6)
	{
		document.getElementById("msg").innerHTML="Check the Pin Code";
		document.getElementById("Pincode").focus();
		return false;
	}
	if(Statusofoffice=="0")
	{
		document.getElementById("msg").innerHTML="Select the Status of office";
		document.getElementById("Statusofoffice").focus();
		return false;
	}
	if(Natureofoffice=="0")
	{
		document.getElementById("msg").innerHTML="Select Nature of office";
		document.getElementById("Natureofoffice").focus();
		return false;
	}

	var EmailId = document.getElementById('email').value;
	var emailfilter = /(([a-zA-Z0-9\-?\.?]+)@(([a-zA-Z0-9\-_]+\.)+)([a-z]{2,3}))+$/;
	if((EmailId != "") && (!(emailfilter.test(EmailId ) ) )) {
    document.getElementById("msg").innerHTML="Enter valid email address";
	document.getElementById("msg").focus();
	return false;
	}

	if(Mb_no=="")
	{
		document.getElementById("msg").innerHTML="Enter Mobile No";
		document.getElementById("Mb_no").focus();
		return false;
	}
	if(ExistingStaff=="")
	{
		document.getElementById("msg").innerHTML="Enter Number of Existing Staff";
		document.getElementById("ExistingStaff").focus();
		return false;
	}
	if(malestaff!="0" || femalestaff!="0")
	{
		if((+malestaff + +femalestaff)!=ExistingStaff)
		{
			document.getElementById("msg").innerHTML="Male, Female & Total Existing Staff No not matching";
			document.getElementById("ExistingStaff").focus();
			return false;
		}
	}
}
