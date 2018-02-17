// JavaScript Document
function SecureLogin(UserID, Password)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'security/login_secure.php',
		type: 'POST',
		data: {
			UserID: UserID,
			Password: Password
		},
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			if(retObj.Status=='Success')
			{
				$("#body").empty();
				$("#body").removeClass("login-page").addClass("skin-green sidebar-mini");
				$("#body").load("mainpage.php");
				loadUserProfile(retObj.UserID);
				$('#timer_div').hide();
				$('#body').addClass('fixed');
				//alert(retObj.Session);
			}
			else
				alert(retObj.Status);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			//alert(errorThrown);
			alert("Secure Login Error 1");
		},
		dataType: "json",
		async: false
	});
}

function loadUserProfile(UserID)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/user_details.php',
		type: 'POST',
		data: {
			UserID: UserID,
		},
		success: function(data) {
			var retObj = JSON.parse(JSON.stringify(data));
			loadProfile(retObj.UserID);
			loadUserTypeMenu(retObj.UserTypeID, retObj.DashBoard);
			loadUserTypeDashBoard(retObj.DashBoard);
			setUserSession(retObj.UserID, retObj.UserTypeID);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown+":  loadUserProfile");
		},
		dataType: "json",
		async: false
	});
}


function loadProfile(UserID)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/user_profile.php',
		type: 'POST',
		data: {
			UserID: UserID,
		},
		success: function(data) {
			
			$("#userprofile").html(data);
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown+":  loadProfile");
		}
	});
}


function loadUserTypeMenu(UserTypeID, Dashboard)
{
	var flag=0;
	var temp_menu_order=0;
	var result;
	var user_type_menu=getUserTypeMenu(UserTypeID);
	//$('#sidebar_menu').empty();
	result="<ul class=\"sidebar-menu\"><li class=\"active\"><a href=\""+Dashboard+"\" class=\"ajax_link\"><i class=\"fa fa-home\"></i><span>Home</span></a></li>";
	for (var i=0; i<user_type_menu.length; i++){
		//For First Menu Link
		if(user_type_menu[i].MenuType==1 && flag==0){
			result=result+"<li><a href=\""+user_type_menu[i].PageName+"\" class=\"ajax_link\"><i class=\"fa "+user_type_menu[i].PageIcon+"\"></i><span>"+user_type_menu[i].PageTitle+"</span></a></li>";
		}
		//For New Menu Link after a Multi Menu
		if(user_type_menu[i].MenuType==1 && flag==1){
			flag=0;
			result=result+"</ul></li><li><a href=\""+user_type_menu[i].PageName+"\" class=\"ajax_link\"><i class=\"fa "+user_type_menu[i].PageIcon+"\"></i><span>"+user_type_menu[i].PageTitle+"</span></a></li>";
		}
		//For New Multi Menu with SubMenuOrder 1
		if(user_type_menu[i].MenuType==2 && user_type_menu[i].SubMenuOrder==1 && flag==0 && temp_menu_order!=user_type_menu[i].MenuOrder){
			flag=1;
			temp_menu_order=user_type_menu[i].MenuOrder;
			result=result+"<li class=\"treeview\"><a href=\"#\"><i class=\"fa "+user_type_menu[i].MultiMenuIcon+"\"></i><span>"+user_type_menu[i].MultiMenuTitle+"</span><i class=\"fa fa-angle-left pull-right\"></i></a><ul class=\"treeview-menu\"><li><a href=\""+user_type_menu[i].PageName+"\" class=\"ajax_link\"><i class=\"fa "+user_type_menu[i].PageIcon+"\"></i><span>"+user_type_menu[i].PageTitle+"</span></a></li>";
		}
		//For First SubMenu with Submenu Order > 1
		if(user_type_menu[i].MenuType==2 && user_type_menu[i].SubMenuOrder!=1 && temp_menu_order==user_type_menu[i].MenuOrder && flag==1){
			result=result+"<li><a href=\""+user_type_menu[i].PageName+"\" class=\"ajax_link\"><i class=\"fa "+user_type_menu[i].PageIcon+"\"></i><span>"+user_type_menu[i].PageTitle+"</span></a></li>";
		}
		//For Next Multi Menu
		if(user_type_menu[i].MenuType==2 && user_type_menu[i].SubMenuOrder==1 && temp_menu_order!=user_type_menu[i].MenuOrder && flag==1){
			temp_menu_order=user_type_menu[i].MenuOrder;
			result=result+"</ul></li><li class=\"treeview\"><a href=\"#\"><i class=\"fa "+user_type_menu[i].MultiMenuIcon+"\"></i><span>"+user_type_menu[i].MultiMenuTitle+"</span><i class=\"fa fa-angle-left pull-right\"></i></a><ul class=\"treeview-menu\"><li><a href=\""+user_type_menu[i].PageName+"\" class=\"ajax_link\"><i class=\"fa "+user_type_menu[i].PageIcon+"\"></i><span>"+user_type_menu[i].PageTitle+"</span></a></li>";
		}
	}
	//For Last Menu, if it is a Multi Menu
	if(flag==1){
		result=result+"</ul></li>";
	}
	result=result+"</ul>";
	$('#menu').html(result);
	/*
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/menu_process.php',
		type: 'POST',
		data: {
				user_type_id: UserTypeID
			},
		success: function(data) {
			$('#sidebar_menu').html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "html",
		async: false
	});*/
}

function loadUserTypeDashBoard(DashBoard)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: DashBoard,
		type: 'POST',
		success: function(data) {
			$('#page_content').html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown+": loadUserTypeDashBoard");
		},
		dataType: "html",
		async: false
	});
}

function login()
{
		var UserID=$('#userid').val();
		var Password=$('#password').val();
		
		if(UserID=='')
		{
			alert('UserID Cannot be Blank!');
			return false;
		}
		if(Password=='')
		{
			alert('Password Cannot be Blank!');
			return false;
		}
		
		SecureLogin(UserID, Password);
}

function setUserSession(UserID, UserTypeID)
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/set_user_session.php',
		type: 'POST',
		data: {
			UserID: UserID,
			UserTypeID: UserTypeID
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown+":  setUserSession");
		},
		dataType: "html",
		async: false
	});
}