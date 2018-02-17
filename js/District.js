// JavaScript Document
function LoadDistrictDetails(SelectID,DistrictID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/district_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the District Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].DistrictCode==DistrictID && DistrictID.length > 0)
				{
				$('#'+SelectID).html( "<option value='"+retObj[i].DistrictCode+"' selected>"+ retObj[i].District + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].DistrictCode+"'>"+ retObj[i].District + "</option>");
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