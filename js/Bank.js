// JavaScript Document
function LoadBankDetails(SelectID, BankID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/bank_details.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Bank Combobox*/
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].BankCode==BankID && BankID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].BankCode+"' selected>"+ retObj[i].BankName + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].BankCode+"'>"+ retObj[i].BankName + "</option>");
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