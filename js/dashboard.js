// JavaScript Document
function show_number_of_office(UserType)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/show_number_of_office.php',
		data:{UserType:UserType},
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			var a=retObj[0].total;
			$("#no_office").html(a);

		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}


function show_number_of_emp(UserType)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/show_number_of_emp.php',
		data:{UserType:UserType},
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			var a=retObj[0].total;
			$("#no_emp").html(a);

		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});	
}


function show_number_of_male_emp(UserType)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/show_number_of_male_emp.php',
		data:{UserType:UserType},
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			var a=retObj[0].total;
			$("#no_male_emp").html(a);

		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});	
}


function show_number_of_female_emp(UserType)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/show_number_of_female_emp.php',
		data:{UserType:UserType},
		type: 'POST',
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			var a=retObj[0].total;
			$("#no_female_emp").html(a);

		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});	
}