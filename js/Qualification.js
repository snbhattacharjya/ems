// JavaScript Document
function LoadQualificationDetails(SelectID,QualificationID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/qualification_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Qualification Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].QualificationCode==QualificationID && QualificationID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].QualificationCode+"' selected>"+ retObj[i].QualificationName + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].QualificationCode+"'>"+ retObj[i].QualificationName + "</option>");
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