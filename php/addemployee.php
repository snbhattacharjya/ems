<?php
session_start();
$userid=$_SESSION['UserID'];
include "../config/config.php";
$mq="SELECT MID(UserID,1,3) AS sub_div_3 FROM userlogin WHERE UserID='$userid'";
$mq1=mysql_query($mq,$DBLink) or die(mysql_error());
$mq1=mysql_fetch_assoc($mq1);
if($mq1['sub_div_3']=='130')
$OfficeCd=$userid;
else
$OfficeCd=$_POST['OfficeCode'];
?>
<script>
$(document).ready(function(){
	$.ajax({
		url: 'forms/personnel_form.php',
		type: 'POST',
		data: { OfficeCode: <?php echo $OfficeCd?>
		},
		success: function(data) {
			$("#ajax-content").html(data);
			LoadEmployeeDetails();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Secure insert Error");
		},
		dataType: "html",
		async: false
		});
	LoadPersonnelDetailsForm1(<?php echo $OfficeCd?>);
	
});
function LoadPersonnelDetailsForm1(officeCd)
{
	
	LoadBankDetails('Bank');
	LoadAssemblyDetails('Assembly1');
	LoadAssemblyDetails('Assembly2');
	LoadAssemblyDetails('Assembly3');
	LoadAssemblyDetails('VoterOfAssembly');
	LoadRemarksDetails('Remarks');	
	LoadQualificationDetails('Qualification');	
	LoadLanguageDetails('LanguageKnown');
	LoadDistrictDetails('District');
	LoadSubdivisionDetails('Subdivision');
	
}
</script>