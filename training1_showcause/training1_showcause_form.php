<?PHP
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
include("../config/config.php");
?>


<div class="box box-solid">
    <div class="box-header bg-teal-active">
        <h3 class="box-title text-bold">Absent Marking and Show Cause for 1st Training)</h3>
    </div><!-- /.box-header -->

    <div class="box-body">

        <div id="div_message" class="callout callout-danger" style="display:none">
        </div>

        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-app absent-marking">
                    <i class="fa fa-user-times text-red icon"></i> Absent Marking
                </a>
                <a class="btn btn-app date-absent-summary">
                    <i class="fa fa-calendar text-blue icon"></i> Date wise Report
                </a>
                <a class="btn btn-app poststat-absent-summary">
                    <i class="fa fa-bar-chart-o text-blue icon"></i> Poststatus wise Report
                </a>
                <a class="btn btn-app exempt-absent-summary">
                    <i class="fa fa-user-secret text-green icon"></i> Exempted from Absent
                </a>
                <a class="btn btn-app show-cause-summary">
                    <i class="fa fa-clipboard text-maroon icon"></i> Show Cause Letter
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
            <div class="col-md-12 table-responsive" id="ajax-result"  style="height: 100%">

            </div>
        </div>

    </div><!-- /.box-body -->
</div><!-- /.box -->

<script type="text/javascript">
$(function(){
    loadAbsentMarkingForm();
});

$('.absent-marking').click(function(e){
    e.preventDefault();
    loadAbsentMarkingForm();
});

$('.date-absent-summary').click(function(e){
    e.preventDefault();
    loadTrainingDateForm();
});

$('.poststat-absent-summary').click(function(e){
    e.preventDefault();
    loadSubdivAbsentSummary();
});

$('.exempt-absent-summary').click(function(e){
    e.preventDefault();
    loadExemptAbsentSummary();
});

$('.show-cause-summary').click(function(e){
    e.preventDefault();
    loadShowCauseSummary();
});
function loadAbsentMarkingForm(){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/training1_absent_marking_form.php",
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

function loadTrainingDateForm(){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/training1_date_form.php",
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

function loadSubdivAbsentSummary(){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/subdiv_training1_absent_summary.php",
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

function loadExemptAbsentSummary(){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/subdiv_training1_absent_exempt_summary.php",
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

function loadShowCauseSummary(){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "training1_showcause/showcause_subdiv_summary.php",
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
