<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="box box-solid">
    <div class="box-header bg-teal-active">
        <h3 class="box-title text-bold">Postal Ballot Cell</h3> 
    </div><!-- /.box-header -->

    <div class="box-body">

        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-app personnel-summary">
                    <i class="fa fa-users text-green icon"></i> Personnel Report
                </a>
                <a class="btn btn-app assembly-appt">
                    <i class="fa fa-certificate text-green icon"></i> Assembly wise Appointment
                </a>
            </div>
        </div><!-- /.row -->
        
        <div class="row text-center ajax-loader">
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
        loadPersonnelSummary();
    });
    
    $('.personnel-summary').click(function(e){
        loadPersonnelSummary();
    });
    
    $('.assembly-appt').click(function(e){
        loadAssemblyAppointment();
    });
    function loadPersonnelSummary(){
	$('#ajax-result').empty();
        $('.ajax-loader').show();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "postal_ballot/assembly_pp_summary_form.php",
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
    
    function loadAssemblyAppointment(){
	$('#ajax-result').empty();
        $('.ajax-loader').show();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "postal_ballot/assembly_appointment.php",
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

