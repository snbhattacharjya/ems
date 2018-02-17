// JavaScript Document
function addPage(PageName, PageTitle, PageIcon){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/add_page.php',
		type: 'POST',
		data: {
				PageName: PageName,
				PageTitle: PageTitle,
				PageIcon: PageIcon
			},
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

function updatePage(PageName, PageTitle, PageIcon){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/update_page.php',
		type: 'POST',
		data: {
				PageName: PageName,
				PageTitle: PageTitle,
				PageIcon: PageIcon
			},
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

function deletePage(PageName){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/delete_page.php',
		type: 'POST',
		data: {
				PageName: PageName
			},
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

function getAppPageInfo(){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/get_page_info.php',
		type: 'POST',
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

function getUserTypePageInfo(UserType){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/get_page_info.php',
		type: 'POST',
		data: {
				UserType: UserType
			},
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

function getUserTypeMenu(UserType){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/get_user_type_menu.php',
		type: 'POST',
		data: {UserType: UserType},
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

function addUserTypeMenuLink(UserType, PageName){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/add_user_type_menu_link.php',
		type: 'POST',
		data: {
			UserType: UserType,
			PageName: PageName
		},
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

function addUserTypeMultiMenu(UserType, PageName, MultiMenuTitle, MultiMenuIcon){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/add_user_type_multi_menu.php',
		type: 'POST',
		data: {
			UserType: UserType,
			PageName: PageName,
			MultiMenuTitle: MultiMenuTitle,
			MultiMenuIcon: MultiMenuIcon
		},
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

function addUserTypeSubMenu(UserType, PageName){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/add_user_type_sub_menu.php',
		type: 'POST',
		data: {
			UserType: UserType,
			PageName: PageName
		},
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

function removeUserTypeMenu(UserType, PageName){
	var retObj;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/remove_user_type_menu.php',
		type: 'POST',
		data: {
			UserType: UserType,
			PageName: PageName
		},
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
