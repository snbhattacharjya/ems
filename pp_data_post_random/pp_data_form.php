<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="box box-solid">
    <div class="box-header bg-teal-active">
        <h3 class="box-title text-bold">Polling Personnel Data (Post Randomisation)</h3> 
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
                            <li><a href="#" class="pp_search"><i class="fa fa-search"></i> Search PP Data</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="pp_search"><i class="fa fa-plus-circle"></i> Add New Office</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary btn-sm new-pp-summary">New PP Report &nbsp;&nbsp;<span class="fa fa-pie-chart"></span></button>
            </div>
        </div><!-- /.row -->
        
        <div class="row text-center ajax-loader" style="display: none">
            <img src="data_transfer/loading_image.gif" height="150" width="150">
            <p id="load-message">
                Loading Web Data...Please wait
            </p>
        </div>
        
        <div class="row">
            <div class="col-md-12 table-responsive" id="ajax-result">
                
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
    
    $('.new-pp-summary').click(function(e){
        e.preventDefault();
        loadPersonnelNewSummary();
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
			$('#office').append( "<option value='"+office[i].OfficeCode+"'>"+ office[i].OfficeCode + ' - ' +office[i].OfficeName + "</option>");
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
            url: 'pp_data_post_random/pp_data_search.php',
            type: "POST",
            data: {
                officecd: officecd
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('#ajax-result').html(data);
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
            url: 'pp_data_post_random/pp_data_add_form.php',
            type: "POST",
            data: {
                officecd: officecd
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('#ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPersonnelNewSummary(){
        $('.ajax-loader').show();
	$.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'pp_data_post_random/subdiv_new_pp_summary.php',
            success: function(data) {
                $('.ajax-loader').hide();
                $('#ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
</script>

