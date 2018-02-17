<script>
var page_table;
var user_type;

$('document').ready(function(){

	//$('#timer_range').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'DD/MM/YYYY h:mm A'});

$('#timer_range').daterangepicker({
    "showDropdowns": true,
    "timePicker": true,
    "locale": {
        "format": "YYYY/MM/DD h:mm A",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ]
    }
}, function(start, end, label) {
  console.log("New date range selected: ' + start.format('YYYY/MM/DD h:mm A') + ' to ' + end.format('YYYY/MM/DD h:mm A') + ' (predefined range: ' + label + ')");
}); 
	
	$('#user_type').select2();
	$('#user_permit_type').select2();
	LoadUserTypeDetails();
	
	$('#user_permit_id').select2();
	LoadUsersByType($('#user_permit_type').val());
	
	$('#user_permit_page').select2();
	loadUserTypePageInfo($('#user_permit_type').val());
	
	$('#setting-menu').hide();
	$('#page_name_combo').select2();

	page_table=$('#app_page_table').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"processing": true
		}); 
	loadPageInfo();
	
	//$('#switch-permit').bootstrapSwitch();
	//$('#switch-timer').bootstrapSwitch();
	
	//Date range picker with time picker
	//$('#timer_range').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'DD/MM/YYYY h:mm A'});
});

$('#addPageBtn').click(function(e){
	var retObj=addPage($('#Page_Name').val(),$('#Page_Title').val(), $('#Page_Icon').val());
	if(retObj.Status=='Success'){
	loadPageInfo();
	alert(retObj.Message);
	}
	else if(retObj.Status=='Error')
	alert(retObj.Message);
});

$('#updatePageBtn').click(function(e){
	var retObj=updatePage($('#Page_Name').val(),$('#Page_Title').val(), $('#Page_Icon').val());
	if(retObj.Status=='Success'){
	loadPageInfo();
	alert(retObj.Message);
	}
	else if(retObj.Status=='Error')
	alert(retObj.Message);
});

$('#deletePageBtn').click(function(e){
	var retObj=deletePage($('#Page_Name').val());
	if(retObj.Status=='Success'){
	loadPageInfo();
	alert(retObj.Message);
	}
	else if(retObj.Status=='Error')
	alert(retObj.Message);
});

$('#user_permit_type').change(function(){
	LoadUsersByType($('#user_permit_type').val());
	loadUserTypePageInfo($('#user_permit_type').val());
});


$('#save_permission_timer').click(function(e) {
	var utype=$('#user_permit_type').val();
	var uid=$('#user_permit_id').val();
	var page=$('#user_permit_page').val();
	var timer_value=$('#timer_range').val().split("-");
	var permit=0;
	var timer=0;
	if($('#switch-permit').prop("checked")==true)
	{permit=1;}
	if($('#switch-timer').prop("checked")==true)
	{timer=1;}
	//alert(utype+"/"+uid+"/"+page+"/"+permit+"/"+timer+"/"+timer_value);
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'settings/set_timer.php',
		type: 'POST',
		data:{
			PageName:page,
			utype:utype,
			uid:uid,
			permit:permit,
			timer:timer,
			start_time:timer_value[0],
			end_time:timer_value[1]
			},
		success: function(data) {
			retObj = JSON.parse(JSON.stringify(data));
			alert(retObj.Message);
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
});


function LoadUserTypeDetails(){
	var user_type_info=getUserTypeDetails();
	$('#user_type').empty();
	$('#user_permit_type').empty();
	
	for(var i=0; i<user_type_info.length; i++)
	{
		$('#user_permit_type').append( "<option value='"+user_type_info[i].UserTypeID+"'>"+ user_type_info[i].UserType + "</option>");
		
		$('#user_type').append( "<option value='"+user_type_info[i].UserTypeID+"'>"+ user_type_info[i].UserType + "</option>");

	}
	$('#user_type').select2();
	$('#user_permit_type').select2();
}

function loadPageInfo(){
	var page_info=getAppPageInfo();
	page_table.clear().draw();
	$('#page_name_combo').empty();
	for(var i=0; i<page_info.length; i++)
	{
		page_table.row.add([page_info[i].PageName, page_info[i].PageTitle, page_info[i].ModifiedDate,'<button type="button" class="editPage btn btn-sm btn-info"><span class="fa fa-edit"></span></button>']).draw();

		$('#page_name_combo').append( "<option value='"+page_info[i].PageName+"'>"+ page_info[i].PageTitle + "</option>");

	}
	$('#page_name_combo').select2();
}

function loadUserTypePageInfo(UserType){
	var page_info=getUserTypePageInfo(UserType);
	$('#user_permit_page').empty();
	for(var i=0; i<page_info.length; i++)
	{
		$('#user_permit_page').append( "<option value='"+page_info[i].PageName+"'>"+ page_info[i].PageTitle + "</option>");

	}
	$('#user_permit_page').select2();
}

function LoadUsersByType(UserType){
	var user_info=getUsersByType(UserType);
	$('#user_permit_id').empty();
	$('#user_permit_id').append("<option value='All'>All Users</option>");
	for(var i=0; i<user_info.length; i++)
	{
		$('#user_permit_id').append( "<option value='"+user_info[i].UserID+"'>"+ user_info[i].UserID + " - " + user_info[i].UserName + "</option>");

	}
	$('#user_permit_id').select2();
}

$('#showUserTypeMenuBtn').click(function(e){
	//Load the User Type Menu Function
	$('#setting-menu').show();
	user_type=$('#user_type').select2('data');
	$('#user_type_text').val(user_type.text);
	loadUserTypeMenu(user_type.id);
	//$('#div_user_type_text').hide();
});

$('#addMenuLinkBtn').click(function(e){
	var result=addUserTypeMenuLink(user_type.id, $('#page_name_combo').val());
	if(result.Status=='Success'){
		alert(result.Message);
		loadUserTypeMenu(user_type.id);
	}
	else
		alert(result.Message);
});

$('#addMultiMenuBtn').click(function(e){
	var result=addUserTypeMultiMenu(user_type.id, $('#page_name_combo').val(), $('#multi_menu_title').val(), $('#multi_menu_icon').val());
	if(result.Status=='Success'){
		alert(result.Message);
		loadUserTypeMenu(user_type.id);
	}
	else
		alert(result.Message);
});

$('#addSubMenuBtn').click(function(e){
	var result=addUserTypeSubMenu(user_type.id, $('#page_name_combo').val());
	if(result.Status=='Success'){
		alert(result.Message);
		loadUserTypeMenu(user_type.id);
	}
	else
		alert(result.Message);
});

$('#upOrderMenuBtn').click(function(e){
	var result=upOrderUserTypeMenu(user_type.id, $('#page_name_combo').val());
	if(result.Status=='Success'){
		alert(result.Message);
		loadUserTypeMenu(user_type.id);
	}
	else
		alert(result.Message);
});

$('#downOrderMenuBtn').click(function(e){
	var result=downOrderUserTypeMenu(user_type.id, $('#page_name_combo').val());
	if(result.Status=='Success'){
		alert(result.Message);
		loadUserTypeMenu(user_type.id);
	}
	else
		alert(result.Message);
});

$('#removeMenuBtn').click(function(e){
	var result=removeUserTypeMenu(user_type.id, $('#page_name_combo').val());
	if(result.Status=='Success'){
		alert(result.Message);
		loadUserTypeMenu(user_type.id);
	}
	else
		alert(result.Message);
});

function loadUserTypeMenu(UserType)
{
	var user_type_menu=getUserTypeMenu(UserType);
	$('#user_type_menu').empty();
	if(user_type_menu.length<=0)
		$('#user_type_menu').append("<li class='list-group-item list-group-item-danger'><i class='fa fa-times'></i> NO DATA AVAILABLE</li>");
		
	for (var i=0; i<user_type_menu.length; i++){
		if(user_type_menu[i].MenuType==1){
			$('#user_type_menu').append("<li class='list-group-item list-group-item-success'><i class='fa "+user_type_menu[i].PageIcon+"'></i> "+user_type_menu[i].PageTitle+"</li>");
		}
		if(user_type_menu[i].MenuType==2 && user_type_menu[i].SubMenuOrder==1){
			$('#user_type_menu').append("<li class='list-group-item list-group-item-info'><i class='fa "+user_type_menu[i].MultiMenuIcon+"'></i> "+user_type_menu[i].MultiMenuTitle+"</li>");
			$('#user_type_menu').append("<li class='list-group-item list-group-item-warning'><i class='fa "+user_type_menu[i].PageIcon+"'></i> "+user_type_menu[i].PageTitle+"</li>");
		}
		if(user_type_menu[i].MenuType==2 && user_type_menu[i].SubMenuOrder>1){
			$('#user_type_menu').append("<li class='list-group-item list-group-item-warning'><i class='fa "+user_type_menu[i].PageIcon+"'></i> "+user_type_menu[i].PageTitle+"</li>");
		}
	}
}

function editPage(PageName, PageTitle){
alert('Inside Edit');/*
	$('#Page_Name').val(PageName);
	$('#Page_Title').val(PageTitle);
	$('#pageBtn').removeClass('btn-success').addClass('btn-info');
	$('#pageBtn').html("<span><i class='fa fa-pencil'></i></span>");*/
}
</script>
<div class="row">
<div class="col-md-12">
<div class="nav-tabs-custom">

	<!--Tab for App settings -->
	<ul class="nav nav-tabs pull-right">
		<li class="pull-left header"><i class="fa fa-gears"></i> APPLICATION SETTINGS</li>
		<li class="active"><a href="#setting-page-tab" data-toggle="tab" tabindex="-1"><i class="fa fa-folder-open"></i> Pages</a></li>
          
    	<li><a href="#setting-menu-tab" data-toggle="tab" tabindex="-2"><i class="fa fa-list-ul"> Menu</i></a></li>
		
		<li><a href="#setting-permit-tab" data-toggle="tab" tabindex="-3"><i class="fa fa-user-secret"> Permissions</i></a></li>
	</ul>
	<div class="tab-content">
	
		<!-- page tab-->
		<div class="tab-pane active" id="setting-page-tab">
			<div class="pad">
				<h4>Page Info</h4>
			</div>
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-sm-3">
					<input type="text" class="form-control" placeholder="Page Name" data-toggle="tooltip" data-placement="bottom" title="Enter Page Name" id="Page_Name" name="Page_Name">
					</div>
					<div class="col-sm-3">
					<input type="text" class="form-control" placeholder="Page Title" data-toggle="tooltip" data-placement="bottom" title="Enter Page Title" id="Page_Title" name="Page_Title">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" placeholder="Page Icon" data-toggle="tooltip" data-placement="bottom" title="Enter Page Icon" id="Page_Icon" name="Page_Icon">
					</div>
					<div class="col-sm-3 btn-group">
					<button type="button" class="btn btn-success btn-md" id="addPageBtn"><span><i class="fa fa-plus"></i></span></button>
					<button type="button" class="btn btn-warning btn-md" id="updatePageBtn"><span><i class="fa fa-save"></i></span></button>
					<button type="button" class="btn btn-danger btn-md" id="deletePageBtn"><span><i class="fa fa-trash"></i></span></button>
					</div>
				</div>
			</form>
			<div class="pad">
				<h4>Available Pages</h4>
			</div>
			<table class="table table-bordered table-striped" id="app_page_table">
				<thead>
				  <tr>
					<th>Page Name</th>
					<th>Page Title</th>
					<th>Modified Date</th>
					<th>&nbsp;</th>
				  </tr>
				</thead>
				<tfoot>

				</tfoot>
			</table>
	
		</div><!--end page tab -->
		
		
		<!-- menu tab-->
		<div class="tab-pane" id="setting-menu-tab">
			<div class="pad">
			<form class="form-horizontal" role="form">
				<div class="col-sm-3">
				<label class="control-label">Select User Type:</label>
				</div>
				<div class="col-sm-7">
				<select class="form-control" id="user_type" name="user_type" placeholder="User Type" data-toggle="tooltip" data-placement="bottom" title="Select User Type">
				</select>
				</div>
				<div class="col-sm-2">
				<button class="btn btn-info" type="button" id="showUserTypeMenuBtn"><i class="fa fa-search"></i></button>
				</div>
			</form>
			</div>

			<div id="setting-menu" class="box-body">
				<div class="col-sm-4">
					<h4>User Type Menu</h4>
					<ul class="list-group" id="user_type_menu">
					</ul>				
				</div><!-- End Col 1 -->
				
				<div class="col-sm-4">
					<h4>Menu Info</h4>
					<form class="form-horizontal" role="form">
						<div class="form-group" id="div_user_type_text">
							<label for="user_type_text">User Type</label>
							<input type="text" class="form-control" id="user_type_text" disabled>
						</div>
						<div class="form-group">
							<label for="page_name_combo">Select Page:</label>
							<select class="form-control" id="page_name_combo" name="page_name_combo" placeholder="Page Name" data-toggle="tooltip" data-placement="bottom" title="Select Page Name"></select>
						</div>
						<div class="form-group">
							<label for="multi_menu_title">Multi Level Menu</label>
							<input type="text" class="form-control" id="multi_menu_title" placeholder="Multilevel Menu Title">
						</div>
						<div class="form-group">
							<label for="multi_menu_icon">Multi Level Menu Icon</label>
							<input type="text" class="form-control" id="multi_menu_icon" placeholder="Multilevel Menu Icon">
						</div>
					</form>
				</div><!-- End Col 2-->
				
				<div class="col-sm-4 btn-group-vertical">
					<div class="pad"></div>
					<button type="button" class="btn btn-success btn-lg" id="addMenuLinkBtn"><span><i class="fa fa-link"></i> Add Menu Link</span></button>
					<button type="button" class="btn bg-maroon btn-lg" id="addMultiMenuBtn"><span><i class="fa fa-indent"></i> Add Multi Menu</span></button>
					<button type="button" class="btn btn-primary btn-lg" id="addSubMenuBtn"><span><i class="fa fa-list-ul"></i> Add Sub Menu</span></button>
					<button type="button" class="btn btn-info btn-lg" id="upOrderMenuBtn"><span><i class="fa fa-arrow-up"></i> Move Up</span></button>
					
					<button type="button" class="btn btn-warning btn-lg" id="downOrderMenuBtn"><span><i class="fa fa-arrow-down"></i> Move Down</span></button>
					<button type="button" class="btn btn-danger btn-lg" id="removeMenuBtn"><span><i class="fa fa-trash"></i></span> Remove</button>
				</div><!-- End Col 3 -->
			</div><!-- End Row -->
		</div>
		<!--end menu tab -->
		
		<!-- permit tab-->
		<div class="tab-pane box-body" id="setting-permit-tab">
				<div class="col-sm-5">
						<div class="form-group">
							<label for="user_permit_type">Select User Type:</label>
							<select class="form-control" id="user_permit_type" name="user_permit_type" placeholder="User Type" data-toggle="tooltip" data-placement="bottom" title="Select User Type">
						</select>
						</div>
						<div class="form-group">
							<label for="user_permit_id">Select User:</label>
							<select class="form-control" id="user_permit_id" name="user_permit_id" placeholder="User ID" data-toggle="tooltip" data-placement="bottom" title="Select User ID">
						</select>
						</div>
						<div class="form-group">
							<label for="user_permit_page">Select Page:</label>
							<select class="form-control" id="user_permit_page" name="user_permit_page" placeholder="Page Name" data-toggle="tooltip" data-placement="bottom" title="Select Page Name"></select>
						</div>

				</div><!--End Col 1-->
				
				<div class="col-sm-7">
				

                
						<div class="form-group">
							<label for="switch-permit">Permission:</label>

                            <div class="toggle-switch-permission toggle-switch-permission-success">
                                <label>
                                <input type="checkbox" id="switch-permit">
                                <div class="toggle-switch-permission-inner"></div>
                                    <div class="toggle-switch-permission-switch"><i class="fa fa-check"></i></div>
                                </label>
                
                            </div>

						</div>
						<div class="form-group">
							<label for="user_permit_type">Timer:</label>
                            
                            <div class="toggle-switch-timer toggle-switch-timer-success">
                                <label>
                                    <input type="checkbox" id="switch-timer">
                                    	<div class="toggle-switch-timer-inner"></div>
                                    <div class="toggle-switch-timer-switch"><i class="fa fa-check"></i></div>
                                </label>
                            
                            </div>
                            
						</div>
                       <div class="form-group">
							<label for="user_permit_type">Date Time Range:</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" class="form-control pull-right" id="timer_range" readonly="readonly">
							</div>
						</div>
				</div><!-- End Col 2 -->
                <div class="footer">
       			 <button class="btn btn-lg btn-success" id="save_permission_timer">SAVE</button>
        		</div>
		</div>

		<!--end Permit tab -->
		
	</div><!-- Tab Content -->

</div><!-- End Nav Custom-->
</div><!-- COLUMN-->
</div><!-- End Row -->