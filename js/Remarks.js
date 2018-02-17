// JavaScript Document
function LoadRemarksDetails(SelectID,RemarksID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/remarks_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Remarks Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].RemarksCode==RemarksID && RemarksID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].RemarksCode+"' selected>"+ retObj[i].RemarksName + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].RemarksCode+"'>"+ retObj[i].RemarksName + "</option>");
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