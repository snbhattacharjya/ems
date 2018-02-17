// JavaScript Document
function LoadMunicipalityDetails(SelectID,MunicipalityID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/block_muni_by_subdiv.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			$('#'+SelectID).empty();
			/* Populate the Remarks Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].BlockminiCode==MunicipalityID && MunicipalityID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].BlockminiCode+"' selected>"+ retObj[i].Blockmuni + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].BlockminiCode+"'>"+ retObj[i].Blockmuni + "</option>");
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


function LoadBlockMuniBySubdiv(SelectID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/block_muni_by_subdiv.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			$('#'+SelectID).empty();
			/* Populate the Remarks Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				$('#'+SelectID).append( "<option value='"+retObj[i].BlockminiCode+"'>"+ retObj[i].Blockmuni + "</option>");
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