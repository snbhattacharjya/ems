// JavaScript Document
function LoadCategoryWiseOfficeDetailsReport()
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/report_office_update.php',
		type: 'POST',
		success: function(data) {
			
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}