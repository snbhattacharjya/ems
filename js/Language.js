// JavaScript Document
function LoadLanguageDetails(SelectID,LanguageID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/language_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Language Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].LanguageCode==LanguageID && LanguageID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].LanguageCode+"' selected>"+ retObj[i].Language  + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].LanguageCode+"'>"+ retObj[i].Language + "</option>");
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