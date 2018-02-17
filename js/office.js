// JavaScript Document

function LoadSubdivWiseOfficeDetails(SelectID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/office_by_subdiv.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Subdivision Combobox*/
			$('#'+SelectID).empty();
			
			for(var i=0; i<retObj.length; i++)
			{
				$('#'+SelectID).append( "<option value='"+retObj[i].OfficeCode+"'>"+ retObj[i].OfficeCode+ " - " +retObj[i].OfficeName + "</option>");
			}
			$('#'+SelectID).select2();
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}







function LoadOfficeDetails(SelectID,OfficeID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/office1_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Subdivision Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].OfficeCode==OfficeID && OfficeID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].OfficeCode+"' selected>"+ retObj[i].OfficeCode+ " - "+retObj[i].Office + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].OfficeCode+"'>"+ retObj[i].OfficeCode+ " - " +retObj[i].Office + "</option>");
				}
			}
			$.getScript('plugins/select2/select2.min.js');
			$('#'+SelectID).select2();
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}



function getOfficeNamefromSession()
{
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/office_name_from_session.php',
		success: function(data) {
			retObj = JSON.parse(JSON.stringify(data));
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	return retObj.OfficeName;	
}


function checkOfficeSession()
{
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/check_office_session.php',
		type: 'POST',
		success: function(data) {
			retObj = JSON.parse(JSON.stringify(data));
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	return retObj;	
}



function save_office_in_session(officecd)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/set_office_session.php',
		type: 'POST',
		data:{office:officecd},
		success: function(data) {
			//alert(data);
			//retObj = JSON.parse(JSON.stringify(data));
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "html",
		async: false
	});
}


function clear_office_from_session()
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/clear_office_session.php',
		type: 'POST',
		success: function(data) {
			//retObj = JSON.parse(JSON.stringify(data));
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "html",
		async: false
	});		
}