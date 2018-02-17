// JavaScript Document
function LoadPPCategoryDetails(SelectID, SelectParameterID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/ppcategorization_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Bank Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].id==SelectParameterID && SelectParameterID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].id+"' selected>"+ retObj[i].parameter + "</option>");
				}
				else
				{
				$('#'+SelectID).append("<option value='"+retObj[i].id+"'>"+retObj[i].parameter + "</option>");
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


function LoadPPSelectedCatagorization_Details(id)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/commonppcategory_details.php',
		type: 'POST',
		data: {Id:id},
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Remarks Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				$('#'+id).append( "<option value='"+retObj[i].parametervalue+"'>"+ retObj[i].parametervalue+ "</option>");
			}
			$.getScript('plugins/select2/select2.min.js');
			$('#'+id).select2();
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}


function LoadPostStatus_Details(id)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/poststatus_details.php',
		type: 'POST',
		data: {},
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Remarks Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				$('#'+id).append( "<option value='"+retObj[i].post_stat+"'>"+ retObj[i].poststatus + "</option>");
			}
			$.getScript('plugins/select2/select2.min.js');
			$('#'+id).select2();
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}


function LoadPostStatusUpdate_Details(id)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/poststatusupdate_details.php',
		type: 'POST',
		data: {},
		success: function(data) {
			alert(data);
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "html",
		async: false
	});
}
