// JavaScript Document
function LoadGovtCattegoryDetails(SelectID,CategoryID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/office_category.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			$('#'+SelectID).empty();
			/* Populate the Remarks Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				
				if(retObj[i].CategoryCode==CategoryID && CategoryID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].CategoryCode+"' selected>"+ retObj[i].Category+ "</option>");
				}
				else
				{
					$('#'+SelectID).append( "<option value='"+retObj[i].CategoryCode+"'>"+ retObj[i].Category + "</option>");
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
