<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    die("Login Expired!. Please Login again to continue");
}
$user_id=$_SESSION['UserID'];
require("../config/config.php");
?>
<div class="box box-solid">
    <div class="box-header bg-teal">
        <h3 class="box-title">
            Personnel Training Management - PP CELL
        </h3> 
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                            </div>
        </div><!-- /.box-header -->
        <div class="box-body">          
            <div class="box-header">
                <a class="btn btn-app training-summary">
                    <i class="fa fa-globe icon"></i> Training Appointment Adhoc Summary
                </a>
                
            </div><!-- /.box-header -->
            <div class="row text-center ajax-loader" style="display: none">
                <div class="col-md-12">
                    <img src="data_transfer/loading_image.gif" height="150" width="150">
                    <p id="load-message">
                        Loading Web Data...Please wait
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ajax-result">
                    
                </div>
            </div>
        </div><!-- /.box-body -->
</div><!-- /.box -->
<script>
$(function(){
    //$.getScript("pp_training_adhoc/pp_training_func.js");
});
    
$('.training-summary').click(function(e){
    e.preventDefault();
    loadSubdivPPBookedSummary();
});

$('.form12-summary').click(function(e){
    e.preventDefault();
    loadSubdivForm12Summary();
});

$('.training-summary-extra').click(function(e){
    e.preventDefault();
    loadSubdivPPExtraBookedSummary();
});

function loadSubdivPPBookedSummary(){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    //var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training_adhoc/pp_training_subdiv_summary.php",
            //type: "POST",
            //data: {
                //target_url: data_target
            //},
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

function loadSubdivPPExtraBookedSummary(){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    //var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training_extra/pp_training_extra_subdiv_summary.php",
            //type: "POST",
            //data: {
                //target_url: data_target
            //},
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
 
    function loadSubdivForm12Summary(){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    //var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training_adhoc/pp_form12_subdiv_summary.php",
            //type: "POST",
            //data: {
                //target_url: data_target
            //},
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
