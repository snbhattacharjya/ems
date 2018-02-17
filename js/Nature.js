// JavaScript Document
function LoadNatureDetails(SelectID,NatureID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/office_nature.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			$('#'+SelectID).empty();
			/* Populate the Remarks Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].NatureCode==NatureID && NatureID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].NatureCode+"' selected>"+ retObj[i].Nature + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].NatureCode+"'>"+ retObj[i].Nature + "</option>");
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