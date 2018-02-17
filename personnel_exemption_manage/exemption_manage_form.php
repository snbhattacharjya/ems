<?PHP
session_start();
include("../config/config.php");
?>

   
<div class="box box-solid">
    <div class="box-header bg-teal-active">
        <h3 class="box-title text-bold">Personnel Exemption Management (Before 1st Appointment)</h3> 
    </div><!-- /.box-header -->

    <div class="box-body">

        <div id="div_message" class="callout callout-danger" style="display:none">												
        </div>

        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-app exemption-summary">
                    <i class="fa fa-pie-chart text-green icon"></i> Exemption Summary
                </a>
                <a class="btn btn-app manage-exemption">
                    <i class="fa fa-edit text-blue icon"></i> Manage
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
    loadSubdivisionExemptionSummary();
});

$('.exemption-summary').click(function(e){
    e.preventDefault();
    loadSubdivisionExemptionSummary();
});

$('.manage-exemption').click(function(e){
    e.preventDefault();
    loadManageExemptionForm();
});

function loadSubdivisionExemptionSummary(){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "personnel_exemption_manage/subdiv_exemption_summary.php",
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
            url: "personnel_exempt_marking/view_pp_table.php",
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

