<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="box box-solid">
    <div class="box-header bg-teal-active">
        <h3 class="box-title text-bold">Counting Personnel Data Preparation</h3> 
    </div><!-- /.box-header -->

    <div class="box-body">

        <div class="row">
            <div class="col-md-8">
                <div class="input-group input-group-sm">
                    <select id="office" class="select2 form-control"></select>
                    <div class="input-group-btn">
                        <button class="btn btn-warning dropdown-toggle" id="searchPP" data-toggle="dropdown">Select Action for Office &nbsp;&nbsp;<span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="add_new"><i class="fa fa-plus-square"></i> Add New PP</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="pp_search"><i class="fa fa-search"></i> Search PP Data for Office</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="pp_search_all"><i class="fa fa-search"></i> All Counting Personnel</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="pp_import"><i class="fa fa-cloud-download"></i> Import from Polling PP</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">Counting PP Report &nbsp;&nbsp;<span class="fa fa-pie-chart"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#" class="counting-pp-summary"><i class="fa fa-star"></i> Subdivision Wise</a></li>
                    <li class="divider"></li>
                    <li><a href="#" class="counting-pp-office"><i class="fa fa-star"></i> Office wise</a></li>
                    <li class="divider"></li>
                    <li><a href="#" class="counting-pp-date"><i class="fa fa-star"></i> Date wise</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">Appointment Data&nbsp;&nbsp;<span class="fa fa-certificate"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#" class="mo_cs_ca_summary"><i class="fa fa-star"></i> Appointment Docs</a></li>
                    <!--<li class="divider"></li>
                    <li><a href="#" class="ca_grd_summary"><i class="fa fa-star"></i> CA GR-D</a></li>-->
                    <li class="divider"></li>
                    <li><a href="pp_counting/pp_counting_subdiv_deployment_print.php" target="_blank"><i class="fa fa-star"></i> Subdivision to Subdivision Deployment</a></li>
                    <li class="divider"></li>
                    <li><a href="pp_counting/pp_counting_asm_deployment_print.php" target="_blank"><i class="fa fa-star"></i> Assembly to Subdivision Deployment</a></li>
                    <li class="divider"></li>
                    <li><a href="pp_counting/pp_counting_random2_sms.php" target="_blank"><i class="fa fa-star"></i> SMS after 2nd Randomisation</a></li>
                    <li class="divider"></li>
                    <li><a href="#" class="booked_search"><i class="fa fa-search"></i> Booked Data</a></li>
                    <li class="divider"></li>
                    <li><a href="#" class="unbooked_search"><i class="fa fa-search"></i> Unbooked Data</a></li>
                    <li class="divider"></li>
                    <li><a href="#" class="exempt_search"><i class="fa fa-search"></i> Exempt Data</a></li>
                </ul>
            </div>
        </div><!-- /.row -->
        
        <div class="row" style="padding-top: 15px">
            <div class="col-md-12">
                <div class="input-group input-group-sm">
                    <div class="input-group-btn">
                        <button class="btn btn-default"><span class="fa fa-cloud-upload text-red text-bold">&nbsp;Export PP for Counting: </span></button>
                    </div>
                    <input type="text" class="emp_search form-control" placeholder="Search By ID, Name or Bank Ac/No. Each entry separated by comma">
                    <div class="input-group-btn">
                        <button class="btn btn-warning dropdown-toggle" id="searchPP" data-toggle="dropdown">Search Employee By &nbsp;&nbsp;<span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="emp-search-id"><i class="fa fa-square"></i> ID</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="emp-search-name"><i class="fa fa-circle"></i> Name</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="emp-search-bank"><i class="fa fa-bank"></i> Bank Ac/No</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-center ajax-loader" style="display: none">
            <img src="data_transfer/loading_image.gif" height="150" width="150">
            <p id="load-message">
                Loading Web Data...Please wait
            </p>
        </div>
        
        <div class="row">
            <div class="col-md-12 table-responsive ajax-result">
                
            </div>
        </div>

    </div><!-- /.box-body -->
</div><!-- /.box --> 
<script>
    $(function(){
        loadOffice();
    });
    
    $('.pp_search').click(function(e){
        e.preventDefault();
        loadPersonnelSummary();
    });
    
    $('.add_new').click(function(e){
        e.preventDefault();
        loadPersonnelAddForm();
    });
    
    $('.pp_import').click(function(e){
        e.preventDefault();
        loadPersonnelCountingImportForm();
    });
    
    $('.counting-pp-summary').click(function(e){
        e.preventDefault();
        loadPersonnelCountingSummary();
    });
    
    $('.counting-pp-office').click(function(e){
        e.preventDefault();
        loadOfficePPCountingSummary();
    });
    
    $('.counting-pp-date').click(function(e){
        e.preventDefault();
        loadPersonnelCountingEntryDateForm();
    });
    
    $('.emp-search-id').click(function(e){
        e.preventDefault();
        loadPersonnelCountingImportSearch('id');
    });
    
    $('.emp-search-name').click(function(e){
        e.preventDefault();
        loadPersonnelCountingImportSearch('name');
    });
    
    $('.emp-search-bank').click(function(e){
        e.preventDefault();
        loadPersonnelCountingImportSearch('bank');
    });
    
    $('.pp_search_all').click(function(e){
        e.preventDefault();
        loadPersonnelCountingAllSearch();
    });
    
    $('.mo_cs_ca_summary').click(function(e){
        e.preventDefault();
        loadPersonnelCountingAppt('COUNT_PP');
    });
    
    $('.ca_grd_summary').click(function(e){
        e.preventDefault();
        loadPersonnelCountingAppt('COUNT_GRD');
    });
    
    $('.booked_search').click(function(e){
        e.preventDefault();
        loadPersonnelCountingBookedSearch();
    });
    
    $('.unbooked_search').click(function(e){
        e.preventDefault();
        loadPersonnelCountingUnbookedSearch();
    });
    
    $('.exempt_search').click(function(e){
        e.preventDefault();
        loadPersonnelCountingExemptSearch();
    });
    
    function loadOffice(){
	var office;
	$('#office').select2({placeholder: 'Loading Office...'});
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/office_by_blockmuni.php',
				
		success: function(data) {
			office=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	if(office.length > 0){
		$('#office').empty();
		$.each(office,function(i){
			$('#office').append( "<option value='"+office[i].OfficeCode+"'>"+ office[i].OfficeCode + ' - ' +office[i].OfficeName + ', ' + office[i].Address + "</option>");
		});
		$('#office').select2({placeholder: 'Select Office'});
	}
	else{
		$('#office').empty();
	}	
    }
    
    function loadPersonnelSummary(){
	var officecd=$('#office').val();
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_data_search.php',
            type: "POST",
            data: {
                officecd: officecd
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelCountingAllSearch(){
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_data_search_all.php',
            
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelAddForm(){
	var officecd=$('#office').val();
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_data_add_form.php',
            type: "POST",
            data: {
                officecd: officecd
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelCountingImportForm(){
	var officecd=$('#office').val();
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_data_import_form.php',
            type: "POST",
            data: {
                officecd: officecd
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelCountingImportSearch(search_param){
        var search_val=$('.emp_search').val();
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_data_import_by_search.php',
            type: "POST",
            data: {
                search_val: search_val,
                search_param: search_param
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelCountingSummary(){
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/subdiv_counting_pp_summary.php',
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadOfficePPCountingSummary(){
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_counting_office_summary.php',
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelCountingEntryDateForm(){
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_counting_entry_date_form.php',
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelCountingAppt(opt){
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_counting_appt_summary.php',
            type: 'POST',
            data: {
                opt: opt
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelCountingBookedSearch(){
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_counting_appt_search_all.php',
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelCountingUnbookedSearch(){
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_counting_unbooked_search_all.php',
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelCountingExemptSearch(){
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_counting/pp_counting_exempt_search_all.php',
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
</script>

