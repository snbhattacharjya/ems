<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 session_start();
?>
<div class="row">
    <div class="col-md-12">
        <form role="form">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control select2" id="subdiv">
                            <option value="">Select Subdivision</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control select2" id="training_venue">
                            <option value="">Select Venue</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control select2" id="training_date">
                            <option value="">Select Date</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control select2" id="training_time">
                            <option value="">Select Time</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                            Select Action <span class="fa fa-caret-down"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="scheduled-pp">Personnel Scheduled</a></li>
                            <li><a href="#" class="absent-pp">Personnel Absent</a></li>
                            <li><a href="#" class="room-absent-pp">Room wise Absent List</a></li>
                            <?php
                            if($_SESSION['UserID'] == 'ADMIN' || $_SESSION['UserID'] == 'ppcell_hug'){
                             ?>
                            <li><a href="#" class="show-cause-letter">Show Cause Letter</a></li>
                            <?php
                             }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row text-center pp-attendance-loader" style="display: none">
    <img src="training1_showcause/preloader.gif">
</div>
<div class="row">
    <div class="col-md-12 pp-attendance-result">

    </div>
</div>
<script>
    $(function(){
      $('.select2').select2();
      loadSubdivision();

    $('#subdiv').change(function(e){
        e.preventDefault();
        $('#training_venue').empty();
        $('#training_venue').select2({placeholder: "Loading Training Venue..."});
        var subdiv=$('#subdiv').val();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training_attendance/training_venue_subdiv.php",
            type: "POST",
            data: {
                subdiv: subdiv
            },
            success: function(data) {
                $('#training_venue').empty();
                var result=JSON.parse(JSON.stringify(data));
                $('#training_venue').append("<option value=''>Select Training Venue</option>");
                $.each(result,function(i){

                    $('#training_venue').append("<option value='"+result[i].VenueBaseName+"'>"+result[i].VenueBaseName+"</option>");
                });
                $('#training_venue').select2();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
	});
    });

    $('#training_venue').change(function(e){
        e.preventDefault();
        $('#training_date').empty();
        $('#training_date').select2({placeholder: "Loading Training Date..."});
        var training_venue=$('#training_venue').val();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training_attendance/training_date_venue.php",
            type: "POST",
            data: {
                training_venue: training_venue
            },
            success: function(data) {
                $('#training_date').empty();
                var result=JSON.parse(JSON.stringify(data));
                $('#training_date').append("<option value=''>Select Training Date</option>");
                $.each(result,function(i){
                    $('#training_date').append("<option value='"+result[i].TrainingDate+"'>"+result[i].DateFormat+"</option>");
                });
                $('#training_date').select2();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
	});
    });

    $('#training_date').change(function(e){
        e.preventDefault();
        $('#training_time').empty();
        $('#training_time').select2({placeholder: "Loading Training Time..."});
        var training_venue=$('#training_venue').val();
        var training_date=$('#training_date').val();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training_attendance/training_time_date_venue.php",
            type: "POST",
            data: {
                training_venue: training_venue,
                training_date: training_date
            },
            success: function(data) {
                $('#training_time').empty();
                var result=JSON.parse(JSON.stringify(data));
                $('#training_time').append("<option value=''>Select Training Time</option>");
                $.each(result,function(i){
                    $('#training_time').append("<option value='"+result[i].TrainingTime+"'>"+result[i].TrainingTime+"</option>");
                });
                $('#training_time').select2();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
	});
    });

    $('.scheduled-pp').click(function(e){
        e.preventDefault();
        $('.pp-attendance-result').empty();
        $('.pp-attendance-loader').show();
        var subdiv=$('#subdiv').val();
        var training_venue=$('#training_venue').val();
        var training_date=$('#training_date').val();
        var training_time=$('#training_time').val();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/training1_pp_schedule_table.php",
            type: "POST",
            data: {
                subdiv: subdiv,
                training_venue: training_venue,
                training_date: training_date,
                training_time: training_time
            },
            success: function(data) {
                $('.pp-attendance-loader').hide();
                $('.pp-attendance-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    });

    $('.absent-pp').click(function(e){
        e.preventDefault();
        $('.pp-attendance-result').empty();
        $('.pp-attendance-loader').show();
        var subdiv=$('#subdiv').val();
        var training_venue=$('#training_venue').val();
        var training_date=$('#training_date').val();
        var training_time=$('#training_time').val();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/training1_pp_absent_table.php",
            type: "POST",
            data: {
                subdiv: subdiv,
                training_venue: training_venue,
                training_date: training_date,
                training_time: training_time
            },
            success: function(data) {
                $('.pp-attendance-loader').hide();
                $('.pp-attendance-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    });

    $('.room-absent-pp').click(function(e){
        e.preventDefault();
        $('.pp-attendance-result').empty();
        $('.pp-attendance-loader').show();
        var subdiv=$('#subdiv').val();
        var training_venue=$('#training_venue').val();
        var training_date=$('#training_date').val();
        var training_time=$('#training_time').val();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/room_absent_summary.php",
            type: "POST",
            data: {
                subdiv: subdiv,
                training_venue: training_venue,
                training_date: training_date,
                training_time: training_time
            },
            success: function(data) {
                $('.pp-attendance-loader').hide();
                $('.pp-attendance-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    });

    $('.show-cause-letter').click(function(e){
        e.preventDefault();
        $('.pp-attendance-result').empty();
        $('.pp-attendance-loader').show();
        var subdiv=$('#subdiv').val();
        var training_venue=$('#training_venue').val();
        var training_date=$('#training_date').val();
        var training_time=$('#training_time').val();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/showcause1_datetime_venue_summary.php",
            type: "POST",
            data: {
                subdiv: subdiv,
                training_venue: training_venue,
                training_date: training_date,
                training_time: training_time
            },
            success: function(data) {
                $('.pp-attendance-loader').hide();
                $('.pp-attendance-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    });
});

function loadSubdivision(){
    $('#subdiv').select2({placeholder: "Loading Subdivision..."});
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/user_subdivision_details.php",
            success: function(data) {
                $('#subdiv').empty();
                var result=JSON.parse(JSON.stringify(data));
                $('#subdiv').append("<option value=''>Select Subdivision</option>");
                $.each(result,function(i){
                    if(result[i].SubdivisionCode != '9999'){
                        $('#subdiv').append("<option value='"+result[i].SubdivisionCode+"'>"+result[i].Subdivision+"</option>");
                    }
                });
                $('#subdiv').select2();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
	});
}
</script>
