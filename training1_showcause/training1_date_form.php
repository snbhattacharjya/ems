<?php
session_start();
$user_id=$_SESSION['UserID'];
require("../config/config.php");
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
$training_date_query=$mysqli->prepare("SELECT DISTINCT(DATE(training_dt)) FROM training_schedule ORDER BY DATE(training_dt) DESC") or die($mysqli->error);
$training_date_query->execute() or die($training_date_query->error);
$training_date_query->bind_result($exempt_date) or die($training_date_query->error);
$training_dates=array();
while($training_date_query->fetch()){
    $training_dates[]=array("DateValue"=>$exempt_date,"DateView"=>date_format(date_create($exempt_date),"d-M-Y"));
}
$training_date_query->close();
?>

<div class="input-group input-group-sm margin-bottom">
    <div class="input-group-btn">
        <button class="btn btn-success view-report">View Report</button>
    </div>
    <select class="select2" id="training_date" style="width: 30%">
        <option value='ALL'>All Dates</option>
        <?php
        for($i=0;$i<count($training_dates);$i++){
            echo "<option value='".$training_dates[$i]['DateValue']."'>".$training_dates[$i]['DateView']."</option>";
        }
        ?>
    </select>
</div>
<div class="row text-center subdiv-result-loader" style="display: none">
    <img src="training1_showcause/preloader.gif">
</div>
<div class="row">
    <div class="col-sm-12 subdiv-date-absent-result">
    </div>
</div>
<script>
    $(function(){
        $('.select2').select2();
        loadSubdivDateAbsentSummary();

        $('.view-report').click(function(e){
            e.preventDefault();
            loadSubdivDateAbsentSummary();
        });
    });

    function loadSubdivDateAbsentSummary(){
        $('.subdiv-result-loader').show();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'training1_showcause/subdiv_date_absent_summary.php',
            type: "POST",
            data: {
                training_date: $('#training_date').val()
            },
            success: function(data) {
                $('.subdiv-date-absent-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "html",
            async: false
        });
        $('.subdiv-result-loader').hide();
    }
</script>
