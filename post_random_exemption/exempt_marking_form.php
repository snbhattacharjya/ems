<?PHP
session_start();
include("../config/config.php");
?>

   
<div class="box box-solid">
    <div class="box-header bg-teal-active">
        <h3 class="box-title text-bold">Marking Personnel for Exemption from Polling Duty (After 1st Appointment)</h3> 
    </div><!-- /.box-header -->

    <div class="box-body">

        <div id="div_message" class="callout callout-danger" style="display:none">												
        </div>

        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-app select-personnel">
                    <i class="fa fa-check-square text-green icon"></i> Select Personnel
                </a>
                <a class="btn btn-app view-personnel">
                    <i class="fa fa-print text-blue icon"></i> Reports
                </a>
                <a class="btn btn-app pre-random-exempt">
                    <i class="fa fa-edit text-red icon"></i> Pre Random Exempt Report
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

<script type="text/javascript">
$(function(){
    loadSelectPPTable();
});

$('.select-personnel').click(function(e){
    e.preventDefault();
    loadSelectPPTable();
});

$('.view-personnel').click(function(e){
    e.preventDefault();
    loadViewPPTable();
});

$('.pre-random-exempt').click(function(e){
    e.preventDefault();
    loadPreRandomViewPPTable();
});

function loadSelectPPTable(){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "post_random_exemption/select_pp_table.php",
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

function loadViewPPTable(){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "post_random_exemption/view_pp_table.php",
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

function loadPreRandomViewPPTable(){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "post_random_exemption/view_prerandom_pp_table.php",
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

