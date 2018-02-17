// JavaScript Document
function LoadPoliceStationDetails(SelectID,PoliceStationID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/police_station_by_subdiv.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			$('#'+SelectID).empty();
			/* Populate the Remarks Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].PoliceStationCode==PoliceStationID && PoliceStationID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].PoliceStationCode+"' selected>"+ retObj[i].PoliceStation + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].PoliceStationCode+"'>"+ retObj[i].PoliceStation + "</option>");
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



function LoadPoliceStationBySubdiv(SelectID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/police_station_by_subdiv.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			$('#'+SelectID).empty();
			/* Populate the Remarks Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				$('#'+SelectID).append( "<option value='"+retObj[i].PoliceStationCode+"'>"+ retObj[i].PoliceStation + "</option>");
				
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