<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$subdiv_param=$_POST['subdiv'];
$training_venue_param=$_POST['training_venue'];
$training_date_param=$_POST['training_date'];
$training_time_param=$_POST['training_time'];
$training_type_param='01';

$training_absent_list_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, office.officecd, office.office, office.address1, office.address2, poststat.poststatus, personnel.mob_no, training_venue.venuename, DATE_FORMAT(DATE(training_schedule.training_dt),'%D-%b-%Y (%a)'), training_schedule.training_time FROM (((personnel INNER JOIN office ON personnel.officecd = office.officecd) INNER JOIN poststat ON personnel.poststat = poststat.post_stat) INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue AND training_venue.subdivisioncd = ? AND training_venue.venue_base_name = ? AND training_schedule.training_dt = ? AND training_schedule.training_time = ? AND personnel.personcd IN (SELECT personcd FROM personnel_training_absent WHERE training_type = ?) ORDER BY training_venue.venuename, training_schedule.training_dt, training_schedule.training_time, personnel.officer_name") or die($mysqli->error);
    $training_absent_list_query->bind_param("sssss",$subdiv_param,$training_venue_param,$training_date_param,$training_time_param,$training_type_param) or die($training_absent_list_query->error);

$training_absent_list_query->execute() or die($training_absent_list_query->error);
$training_absent_list_query->bind_result($personcd,$officer_name,$off_desg,$officecd,$office_name,$address1,$address2,$poststatus,$mobile,$training_venue,$training_date,$training_time) or die($training_absent_list_query->error);
$return=array();
while($training_absent_list_query->fetch())
{
	$return[]=array("PersonID"=>$personcd,"OfficerName"=>$officer_name,"Designation"=>$off_desg,"OfficeID"=>$officecd,"OfficeName"=>$office_name,"Address1"=>$address1,"Address2"=>$address2,"PostStatus"=>$poststatus,"Mobile"=>$mobile,"TrainingVenue"=>$training_venue,"TrainingDate"=>$training_date,"TrainingTime"=>$training_time);
}	
?>
<div class="text-center">
   <img src="img/ajax_loader_green_128.gif" height="50" width="50" style="display: none" id="data-loader"> 
</div>
<div class="text-center margin-bottom">
    <a class="btn btn-default btn-md" href="training1_showcause/training1_pp_absent_table_print.php?subdiv=<?php echo $subdiv_param; ?>&training_venue=<?php echo $training_venue_param; ?>&training_date=<?php echo $training_date_param; ?>&training_time=<?php echo $training_time_param; ?>&training_type=<?php echo $training_type_param; ?>" target="_blank">
        <i class="fa fa-print text-red"></i> Print Absent List
    </a>
</div>
<table id="table_employee" class="table table-bordered table-condensed small">
    <thead>
        <tr class="danger">
            <th colspan="8">
                <button class="btn btn-default" id="totalPP"><i class="fa fa-user-times"></i> Total Absent <span class="badge">0</span></button> 
                <button class="btn btn-success" id="presentPP"><i class="fa fa-user-plus"></i> Mark Present <span class="badge">0</span></button> 
                <input type="text" class="input-sm pull-right" placeholder="Search Employee" id="search-text">
            </th>
        </tr>
        <tr class="bg-blue-active">
            <th><input type="checkbox" class="select-all"></th>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Designation / Office</th>
            <th>Post Status</th>
            <th>Mobile No</th>
            <th>Training Venue</th>
            <th>Training Date and Time</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i = 0; $i < count($return); $i++){
        ?>
        <tr>
            <td><?php echo "<input type='checkbox' class='select-pp'>"; ?></td>
            <td class="personcd"><?php echo $return[$i]['PersonID']; ?></td>
            <td><?php echo $return[$i]['OfficerName']; ?></td>
            <td><?php echo $return[$i]['Designation'].", ".$return[$i]['OfficeName']." - ".$return[$i]['Address1'].", ".$return[$i]['Address2']." (".$return[$i]['OfficeID'].")"; ?></td>
            <td><?php echo $return[$i]['PostStatus']; ?></td>
            <td><?php echo $return[$i]['Mobile']; ?></td>
            <td><?php echo $return[$i]['TrainingVenue']; ?></td>
            <td><?php echo $return[$i]['TrainingDate'].", ".$return[$i]['TrainingTime']; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>

    </tfoot>
  </table>
<!-- Modal -->
<div id="message-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
        <h3 class="modal-title">Application Message</h3>
      </div>
      <div class="modal-body">
          <h4 class="body-text"></h4>
      </div>
      
    </div>
  </div>
</div>		   
<script>
    var emp;
    var selected_pp=0;
    
    $(function(){
        loadAbsentSummary();
        
        $("#search-text").keyup(function(){
            if (this.value.length < 1) {
                $("#table_employee tbody tr").css("display", "");
            } 
            else {
                $("#table_employee tbody tr:not(:contains('"+$(this).val().toUpperCase()+"'))").css("display", "none");
                $("#table_employee tbody tr:contains('"+$(this).val().toUpperCase()+"')").css("display", "");
            }    
        });
        
        $('.select-all').change(function(e){
            e.preventDefault();
            if($(this).is(':checked')){
                $("#table_employee tbody tr").addClass('success');
                $('#table_employee tbody .select-pp').prop('checked',true);
                $('#presentPP').find('.badge').html(emp.length);
            }
            else{
                $("#table_employee tbody tr").removeClass('success');
                $('#table_employee tbody .select-pp').prop('checked',false);
                $('#presentPP').find('.badge').html('0');
            }
        });
        
        $('.select-pp').change(function(e){
            e.preventDefault();
            var row=$(this).closest('tr');
            if(row.hasClass('success')){
                row.removeClass('success');
                selected_pp -= 1;
                $('#presentPP').find('.badge').html(selected_pp);
            }
            else{
                row.addClass('success');
                selected_pp += 1;
                $('#presentPP').find('.badge').html(selected_pp);
            }
        });
        
        $('#presentPP').click(function(e){
            e.preventDefault();
            $('#data-loader').show();
            var emp_present_count=0;
            var total_pp=emp.length;
            $.each(emp,function(){
                if($(this).hasClass('success')){
                    var emp_code=$(this).find('.personcd').html().toString();
                    var result;
                    $.ajax({
                        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                        url: 'training1_showcause/unmark_training1_absent_employee.php',
                        type: 'POST',
                        data: {
                            personcd: emp_code
                        },
                        success: function(data) {
                                result=JSON.parse(JSON.stringify(data));
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                                alert(errorThrown);
                        },
                        dataType: "json",
                        async: false
                    });
                    if(result.Status == 'Success'){
                        emp_present_count += 1;
                        total_pp -= 1;
                        $(this).hide();
                        $('#totalPP').find('.badge').html(total_pp);
                    }
                    else{
                        alert(result.Status);
                    }
                }
                /*else{
                    $(this).removeClass('warning');
                    $(this).find('.select-pp').prop('checked',false);
                    selected_pp -= 1;
                    $('#selected_pp').html(selected_pp);
                }*/
                if(emp_present_count != selected_pp){
                    $('.body-text').html("ERROR - Some Personnel Cannot be Marked for Present");
                    $('.modal-header').addClass('bg-red');
                    $('#message-modal').modal('show');
                }
                else{
                    $('.body-text').html("All Selected Personnel Successfully Marked for Present");
                    $('.modal-header').addClass('bg-green');
                    $('#message-modal').modal('show');
                }
            });
            $(emp).removeClass('success');
            $(emp).find('.select-pp').prop('checked',false);
            selected_pp = 0;
            $('#presentPP').find('.badge').html(selected_pp);
            $('.select-all').prop('checked',false);
            $('#data-loader').hide();
        });
        
    });
    function loadAbsentSummary(){
	emp = $('#table_employee tbody tr');
	$('#totalPP').find('.badge').html(emp.length);
    }
    
    
</script>


