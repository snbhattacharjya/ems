<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="box box-solid">
    <div class="box-header bg-teal-active">
        <h3 class="box-title text-bold">Police Personnel Randomisation</h3> 
    </div><!-- /.box-header -->

    <div class="box-body">

        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-app randomise-data">
                    <i class="fa fa-refresh text-green icon"></i> Randomise Data
                </a><!--
                <a class="btn btn-app randomise-data-female">
                    <i class="fa fa-female text-green icon"></i> Female Randomise
                </a> -->
                <a class="btn btn-app populate-data">
                    <i class="fa fa-cloud-upload text-red icon"></i> Populate Data
                </a>
                <a class="btn btn-app police-report">
                    <i class="fa fa-bar-chart-o text-blue icon"></i> Reports
                </a>             
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
        loadPoliceSummary();
    });
    
    $('.randomise-data').click(function(e){
        e.preventDefault();
        randomisePoliceData();
    });
    $('.randomise-data-female').click(function(e){
        e.preventDefault();
        randomisePoliceFemaleData();
    });
    $('.populate-data').click(function(e){
        e.preventDefault();
        populateData();
    });
    
    $('.police-report').click(function(e){
        e.preventDefault();
        loadPoliceReport();
    });
    
    function randomisePoliceData(){
	$('#ajax-result').empty();
        $('#load-message').html("Data Randomisation in Progress...Please Wait.");
        $('.ajax-loader').show();
        var retobj;
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "police_randomisation/police_data_randomise.php",
            success: function(data) {
                $('.ajax-loader').hide();
                retobj=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
        });
        if(retobj.Status == 'Success'){
            $('#ajax-result').html("<div class='text-center'><i class='fa fa-check-circle fa-5x text-green'></i><p>Randomisation Completed</p>");
        }
        else{
            $('#ajax-result').html("<div class='text-center'><i class='fa fa-warning fa-5x text-red'></i><p>Randomisation Not Completed"+retobj.Status+"</p>");
        }
    }
    
    function randomisePoliceFemaleData(){
	$('#ajax-result').empty();
        $('#load-message').html("Data Randomisation in Progress...Please Wait.");
        $('.ajax-loader').show();
        var retobj;
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "police_randomisation/police_female_data_randomise.php",
            success: function(data) {
                $('.ajax-loader').hide();
                retobj=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
        });
        if(retobj.Status == 'Success'){
            $('#ajax-result').html("<div class='text-center'><i class='fa fa-check-circle fa-5x text-green'></i><p>Randomisation Completed</p>");
        }
        else{
            $('#ajax-result').html("<div class='text-center'><i class='fa fa-warning fa-5x text-red'></i><p>Randomisation Not Completed"+retobj.Status+"</p>");
        }
    }
    
     function populateData(){
	$('#ajax-result').empty();
        $('#load-message').html("Data Populate in Progress...Please Wait.");
        $('.ajax-loader').show();
        var retobj;
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "police_randomisation/police_data_populate.php",
            success: function(data) {
                $('.ajax-loader').hide();
                retobj=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
        });
        if(retobj.Status == 'Success'){
            $('#ajax-result').html("<div class='text-center'><i class='fa fa-check-circle fa-5x text-green'></i><p>Data Populate Completed</p>");
        }
        else{
            $('#ajax-result').html("<div class='text-center'><i class='fa fa-warning fa-5x text-red'></i><p>Data Populate Not Completed"+retobj.Status+"</p>");
        }
    }
    
    function loadPoliceSummary(){
	$('#ajax-result').empty();
        $('#load-message').html("Loading Police Data Summary...Please Wait.");
        $('.ajax-loader').show();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "police_randomisation/police_summary.php",
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
    
    function loadPoliceReport(){
	$('#ajax-result').empty();
        $('#load-message').html("Loading Police Report...Please Wait.");
        $('.ajax-loader').show();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "police_randomisation/police_booth_allocation_report.php",
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

