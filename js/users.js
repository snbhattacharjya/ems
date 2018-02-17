// JavaScript Document
function getUsersByType(UserTypeID){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/user_list_by_type.php',
		type: 'POST',
		data: {UserTypeID: UserTypeID},
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

function LoadAddUser(utype)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/insertuser.php',
		type: 'POST',
		data: {
			UserType: utype,
			UserName: $('#UserName').val(),
			Designation: $('#Designation').val(),
			EmailId: $('#EmailId').val(),
			MobileNumber: $('#MobileNumber').val()
			},
			success: function(data) {
				var retObj = JSON.parse(JSON.stringify(data));
		  		$('#autoGenPass').html(retObj.Password);
				$('#autoGenUserID').html(retObj.UserID);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}