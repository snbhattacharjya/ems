// JavaScript Document

function LogOut()
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'security/logout.php',
		type: 'POST',
		success: function(data) {
			$(body).empty();
			window.location.assign('');
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "html",
		async: false
	});	
}