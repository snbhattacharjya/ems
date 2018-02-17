// JavaScript Document
/*
function getPCDetails(){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/pc_details.php',
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

function LoadPCDetails()
{
	var retObj=getPCDetails();

	$('#pc_dtls').empty();
	
	for(var i=0; i<retObj.length; i++)
	{
		$('#pc_dtls').append( "<option value='"+retObj[i].pccd+"' selected>"+retObj[i].pccd + "</option>");
	}
	$('#pc_dtls').select2();
}


*/
function LoadPCDetails(SelectID,PcID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/pc_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Language Combobox*/
			$('#'+SelectID).empty();
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].pccd==PcID && PcID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].pccd+"' selected>"+ retObj[i].pccd + " - " + retObj[i].pcname +"</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].pccd+"'>"+ retObj[i].pccd + " - " + retObj[i].pcname +"</option>");
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