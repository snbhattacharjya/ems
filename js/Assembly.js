// JavaScript Document
function getAssemblyDetails(){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/assembly_details.php',
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

function LoadAssemblyDetails(temp,perm,off)
{
	var retObj=getAssemblyDetails();
	
	/*$('#Assembly_temp').empty();
	$('#Assembly_perm').empty();
	$('#Assembly_off').empty();*/

	for(var i=0; i<retObj.length; i++)
	{
		if(retObj[i].AssemblyCode==temp && temp.length > 0)
		{
			$('#Assembly_temp').append( "<option value='"+retObj[i].AssemblyCode+"' selected>"+ retObj[i].AssemblyCode + " - " +retObj[i].AssemblyName + "</option>");
		}
		else
		{
			$('#Assembly_temp').append( "<option value='"+retObj[i].AssemblyCode+"'>"+ retObj[i].AssemblyCode + " - " + retObj[i].AssemblyName + "</option>");
		}
		
		
		if(retObj[i].AssemblyCode==perm && perm.length > 0)
		{
			$('#Assembly_perm').append( "<option value='"+retObj[i].AssemblyCode+"' selected>"+ retObj[i].AssemblyCode + " - " +retObj[i].AssemblyName + "</option>");
		}
		else
		{
			$('#Assembly_perm').append( "<option value='"+retObj[i].AssemblyCode+"'>"+ retObj[i].AssemblyCode + " - " + retObj[i].AssemblyName + "</option>");
		}
		
		
		if(retObj[i].AssemblyCode==off && off.length > 0)
		{
			$('#Assembly_off').append( "<option value='"+retObj[i].AssemblyCode+"' selected>"+ retObj[i].AssemblyCode + " - " +retObj[i].AssemblyName + "</option>");
		}
		else
		{
			$('#Assembly_off').append( "<option value='"+retObj[i].AssemblyCode+"'>"+ retObj[i].AssemblyCode + " - " + retObj[i].AssemblyName + "</option>");
		}
		
	/*	$('#Assembly_temp').append( "<option value='"+retObj[i].AssemblyCode+"'>"+ retObj[i].AssemblyCode + " - " +retObj[i].AssemblyName + "</option>");
		$('#Assembly_perm').append( "<option value='"+retObj[i].AssemblyCode+"'>"+ retObj[i].AssemblyCode + " - " +retObj[i].AssemblyName + "</option>");
		$('#Assembly_off').append( "<option value='"+retObj[i].AssemblyCode+"'>"+ retObj[i].AssemblyCode + " - " +retObj[i].AssemblyName + "</option>");*/
	}
		$('#Assembly_temp').select2();
	$('#Assembly_perm').select2();
	$('#Assembly_off').select2();

}





/*
function getAssemblyDetailsBySubdiv(){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/assembly_details_by_subdiv.php',
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

function LoadAssemblyDetailsBySubdiv()
{
	var retObj=getAssemblyDetailsBySubdiv();

	$('#Assembly_dtls').empty();
	
	for(var i=0; i<retObj.length; i++)
	{
		$('#Assembly_dtls').append( "<option value='"+retObj[i].AssemblyCode+"' selected>"+ retObj[i].AssemblyCode + " - " +retObj[i].AssemblyName + "</option>");
	}
	$('#Assembly_dtls').select2();
}

*/



function LoadAssemblyDetailsBySubdiv(SelectID,AssemblyID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/assembly_details_by_subdiv.php',
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Language Combobox*/
			$('#'+SelectID).empty();
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].AssemblyCode==AssemblyID && AssemblyID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].AssemblyCode+"' selected>"+ retObj[i].AssemblyCode + " - " +retObj[i].AssemblyName + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].AssemblyCode+"'>"+ retObj[i].AssemblyCode + " - " + retObj[i].AssemblyName + "</option>");
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



function LoadAssemblyDetailsBypc(SelectID,PcID,AssemblyID){
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/assembly_details_by_pc.php',
		type: 'POST',
		data: {pc:PcID},
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			/* Populate the Language Combobox*/
			$('#'+SelectID).empty();
			for(var i=0; i<retObj.length; i++)
			{
				if(retObj[i].AssemblyCode==AssemblyID && AssemblyID.length > 0)
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].AssemblyCode+"' selected>"+ retObj[i].AssemblyCode + " - " +retObj[i].AssemblyName + "</option>");
				}
				else
				{
				$('#'+SelectID).append( "<option value='"+retObj[i].AssemblyCode+"'>"+ retObj[i].AssemblyCode + " - " + retObj[i].AssemblyName + "</option>");
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