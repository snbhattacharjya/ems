// JavaScript Document
function getAllUserAudit(){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'audit/getAllUserAudit.php',
		success: function(data) {
			retObj=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	return retObj;
}

function getSDOAudit(){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'audit/getSDOAudit.php',
		success: function(data) {
			retObj=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	return retObj;
}

function getDEOAudit(){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'audit/getDEOAudit.php',
		success: function(data) {
			retObj=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	return retObj;
}

function getOfficeAudit(){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'audit/getOfficeAudit.php',
		success: function(data) {
			retObj=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	return retObj;
}