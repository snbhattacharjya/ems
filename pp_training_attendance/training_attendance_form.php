<?PHP
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
$user_id=$_SESSION['UserID'];
require("../config/config.php");
?>
<div class="box box-solid">
    <div class="box-header bg-teal">
        <h3 class="box-title">
            Personnel Training Attendance
        </h3> 
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                            </div>
        </div><!-- /.box-header -->
        <div class="box-body">          
            <form role="form">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Subdivision:
                            </label>
                            <select class="form-control select2" id="subdiv">
                                <option value="">Select Subdivision</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Training Venue:
                            </label>
                            <select class="form-control select2" id="training_venue">
                                <option value="">Select Venue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Date:
                            </label>
                            <select class="form-control select2" id="training_date">
                                <option value="">Select Date</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Time:
                            </label>
                            <select class="form-control select2" id="training_time">
                                <option value="">Select Time</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <button type="button" class="btn btn-flat btn-success" id="generate_attendance_btn">
                                Generate Training Attendance
                            </button>
                        </div>
                </div>
                </div>
            </form>
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
    
    $('#generate_attendance_btn').click(function(e){
        e.preventDefault();
        $('.ajax-result').empty();
        $('.ajax-loader').show();
        var subdiv=$('#subdiv').val();
        var training_venue=$('#training_venue').val();
        var training_date=$('#training_date').val();
        var training_time=$('#training_time').val();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training_attendance/pp_training_attendance_table.php",
            type: "POST",
            data: {
                subdiv: subdiv,
                training_venue: training_venue,
                training_date: training_date,
                training_time: training_time
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
    });
});

function loadSubdivision(){
    $('#subdiv').select2({placeholder: "Loading Subdivision..."});
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "json/subdivision_details.php",
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
