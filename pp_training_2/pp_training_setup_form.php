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
            Personnel Training Setup
        </h3> 
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                            </div>
        </div><!-- /.box-header -->
        <div class="box-body">          
            <div class="box-header">
                <a class="btn btn-app training-venue">
                    <i class="fa fa-building icon"></i> Training Venues
                </a>
                <a class="btn btn-app training-schedule">
                    <i class="fa fa-clock-o icon"></i> Training Schedules
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
    $.getScript("pp_training/pp_training_setup_func.js");
});
    
$('.training-venue').click(function(e){
    e.preventDefault();
    loadPPTrainingVenue();
});

$('.training-schedule').click(function(e){
    e.preventDefault();
    loadPPTrainingSchedule();
});
</script>
