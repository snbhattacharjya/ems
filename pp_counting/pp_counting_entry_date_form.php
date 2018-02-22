<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");
?>
<h3 class="page-header">
    Counting Personnel Appointment Summary
</h3>
<?php
$posted_date_query=$mysqli->prepare("SELECT DISTINCT(DATE(posted_date)) FROM personnel_counting ORDER BY DATE(posted_date) DESC") or die($mysqli->error);
$posted_date_query->execute() or die($posted_date_query->error);
$posted_date_query->bind_result($posted_date) or die($posted_date_query->error);
$posted_dates=array();
while($posted_date_query->fetch()){
    $posted_dates[]=array("DateValue"=>$posted_date,"DateView"=>date_format(date_create($posted_date),"d-M-Y"));
}
$posted_date_query->close();
?>

<div class="input-group input-group-sm margin-bottom">
    <div class="input-group-btn">
        <button class="btn btn-success view-report">View Report for Entry Date</button>
    </div>
    <select class="select2" id="posted_date" style="width: 30%">
        <option value='ALL'>All Dates</option>
        <?php
        for($i=0;$i<count($posted_dates);$i++){
            echo "<option value='".$posted_dates[$i]['DateValue']."'>".$posted_dates[$i]['DateView']."</option>";
        }
        ?>
    </select>
</div>

<div class="row text-center pp-result-loader" style="display: none">
    <img src="training1_showcause/preloader.gif">
</div>

<div class="row margin-bottom">
    <div class="col-md-12 new-pp-result">
        
    </div>
</div>
<script>
    $(function(){
       $('#posted_date').select2();
       loadPPSubdivSummaryByDate();
       
       $('.view-report').click(function(e){
            e.preventDefault();
            loadPPSubdivSummaryByDate();
        });
    });

    function loadPPSubdivSummaryByDate()
    {
        var posted_date=$('#posted_date').val(); 
        $('.new-pp-result').empty();
        $('.pp-result-loader').show();
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "pp_counting/pp_counting_subdiv_summary.php",
                type: "POST",
                data: {
                    posted_date: posted_date
                },
                success: function(data) {
                    $('.pp-result-loader').hide();
                    $('.new-pp-result').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "html",
                async: false
            });
    }
</script>