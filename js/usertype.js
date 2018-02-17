// JavaScript Document
function LoadUserTypeDetails(SelectID,UserTypeID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/usertype.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Subdivision Combobox*/
			$('#'+SelectID).empty();
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].UserTypeID==UserTypeID && UserTypeID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].UserTypeID+"' selected>"+ retObj[i].UserType + "</option>");
				}
				else
				{
					$('#'+SelectID).append( "<option value='"+retObj[i].UserTypeID+"'>"+ retObj[i].UserType + "</option>");
				}
			}
			//$.getScript('plugins/select2/select2.min.js');
			$('#'+SelectID).select2();
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}


function getUserTypeDetails(){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/usertype.php',
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