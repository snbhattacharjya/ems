// JavaScript Document

function checkSubdivSession()
{
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/check_subdiv_session.php',
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



function setSubdivSession(subdivcd)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/set_subdiv_session.php',
		type: 'POST',
		data:{subdiv:subdivcd},
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

function clear_subdiv_office_from_session()
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/clear_subdiv_session.php',
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



function LoadSubdivisionDetails(SelectID,SubdivisionID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/subdivision_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Subdivision Combobox*/
			$('#'+SelectID).empty();
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].SubdivisionCode==SubdivisionID && SubdivisionID.length > 0)
				{
				$('#'+SelectID).html( "<option value='"+retObj[i].SubdivisionCode+"' selected>"+ retObj[i].Subdivision + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].SubdivisionCode+"'>"+ retObj[i].Subdivision + "</option>");
				}
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


function getSubdivNamefromSession()
{
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/subdiv_name_from_session.php',
		success: function(data) {
			retObj = JSON.parse(JSON.stringify(data));
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	return retObj.SubdivisionName;	
}