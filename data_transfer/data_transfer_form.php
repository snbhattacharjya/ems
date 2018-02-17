<?PHP
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
?>
<div class="box box-solid">
    <div class="box-header bg-light-blue-gradient">
        <h3 class="box-title">
            Data Transfer Operations
        </h3> 
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                            </div>
        </div><!-- /.box-header -->
        <div class="box-body">          
            <div class="box-header">
                <a class="btn btn-app ppds-data-clean" data-target="data_transfer/clean_ppds.php">
                    <i class="fa fa-trash-o icon"></i> Clean PPDS Data
                </a>
                <a class="btn btn-app ppds-personnel-export" data-target="data_transfer/export_ems_ppds.php">
                    <i class="fa fa-upload icon"></i> Export EMS to PPDS Local
                </a>
                <a class="btn btn-app ppds-personnel-update-local" data-target="data_transfer/update_ems_pp_ppds_all.php">
                    <i class="fa fa-check-square-o icon"></i> PPDS Personnel Update Local
                </a>
                <a class="btn btn-app ppds-personnel-update-web" data-target="http://www.hooghlyonline.in/ems/data_transfer/update_ems_pp_ppds.php">
                    <i class="fa fa-globe icon"></i> PPDS Personnel Update Web
                </a>
                <a class="btn btn-app personnel-import" data-target="data_transfer/personnel_import_table.php">
                    <i class="fa fa-cloud-download icon"></i> Personnel Import Web
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
    $(".knob").knob();
});
    
$('.ppds-personnel-update-local').click(function(e){
    e.preventDefault();alert('check');
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: data_target,
            
            success: function(data) {
                $('.ajax-loader').hide();
                var result=JSON.parse(JSON.stringify(data));
                if(result.Status == 'Success'){
                    $('.ajax-result').html("<div class='text-center'><i class='fa fa-thumbs-up fa-2x text-green'></i><p>Total Records Updated: "+result.RecordsCount+"</p>");
                }
                else{
                    $('.ajax-result').html("<div class='text-center'><i class='fa fa-thumbs-down fa-2x text-red'></i><p>Reason: "+result.Status+"</p>");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
	});
});

$('.ppds-personnel-update-web').click(function(e){
    e.preventDefault();
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "data_transfer/update_ems_web_form.php",
            type: "POST",
            data: {
                target_url: data_target
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

$('.personnel-import').click(function(e){
    e.preventDefault();
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: data_target,
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

$('.ppds-personnel-export').click(function(e){
    e.preventDefault();
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: data_target,
        success: function(data) {
            $('.ajax-loader').hide();
            var result=JSON.parse(JSON.stringify(data));
            if(result.Status == 'Success'){
                $('.ajax-result').html("<div class='text-center'><i class='fa fa-thumbs-up fa-2x text-green'></i><p>Office Records Affected: "+result.OfficeCount+"</p><p>Personnel Records Affected: "+result.PersonnelCount+"</p>");
            }
            else{
                $('.ajax-result').html("<div class='text-center'><i class='fa fa-thumbs-down fa-2x text-red'></i><p>Reason: "+result.Status+"</p>");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "json",
        async: false
    });
});

$('.ppds-data-clean').click(function(e){
    e.preventDefault();
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: data_target,
        success: function(data) {
            $('.ajax-loader').hide();
            var result=JSON.parse(JSON.stringify(data));
            if(result.Status == 'Success'){
                $('.ajax-result').html("<div class='text-center'><i class='fa fa-thumbs-up fa-2x text-green'></i><p>Office Records Affected: "+result.OfficeCount+"</p><p>Personnel Records Affected: "+result.PersonnelCount+"</p>");
            }
            else{
                $('.ajax-result').html("<div class='text-center'><i class='fa fa-thumbs-down fa-2x text-red'></i><p>Reason: "+result.Status+"</p>");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "json",
        async: false
    });
});
</script>
