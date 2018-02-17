function LoadOfficeDetailsSDOForm()
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/officesdo_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Office Update Form*/
			$('#officecd').val(retObj.officecd);
			$('#OfficeName').val(retObj.office);
			$('#OfficeId').val(retObj.office_unique_id);
			$('#Designation').val(retObj.officer_desg);	
			$('#Street').val(retObj.address1);
			$('#Town').val(retObj.address2);
			$('#PostOffice').val(retObj.postoffice);
			$('#PinCode').val(retObj.pin);
			$('#EmailId').val(retObj.email);
			$('#PhoneNumber').val(retObj.phone);
			$('#MobileNumber').val(retObj.mobile);
			$('#FaxNo').val(retObj.fax);
			$('#TotalMaleStaffs').val(retObj.male_staff);
			$('#TotalFemaleStaffs').val(retObj.female_staff);
			$('#TotalNumberofStaffs').val(retObj.tot_staff);
			
			//$.getScript('js/Subdivision.js');
			LoadSubdivisionDetails('Subdivision',retObj.subdivisioncd);
			//$.getScript('js/PoliceStation.js');
			LoadPoliceStationDetails('PoliceStation',retObj.policestn_cd);
			//$.getScript('js/Municipality.js');
			LoadMunicipalityDetails('Municipality',retObj.blockormuni_cd);
			//$.getScript('js/Category.js');
			LoadGovtCattegoryDetails('StatusOfOffice',retObj.govt);
			//$.getScript('js/Nature.js');
			LoadNatureDetails('NatureOfOffice',retObj.institutecd);
			LoadAssemblyDetailsBypc('Assembly_dtls',retObj.pccd,retObj.assemblycd);
			LoadPCDetails('pc_dtls',retObj.pccd);
					},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}
