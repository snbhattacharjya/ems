<?php
$training_date=$_POST['training_date'];
$training_time=$_POST['training_time'];
?>
<table id="schedule_table" class="table table-bordered table-condensed small">
    <thead>
        <tr>
            <th rowspan="2" class="bg-teal">#</th>
            <th rowspan="2" class="bg-teal">Venue ID</th>
            <th rowspan="2" class="bg-teal">Venue Name</th>
            <th rowspan="2" class="bg-teal">Capacity</th>
            <th class="text-center bg-maroon" colspan="5">Date: <span class="training_date"><?php echo $training_date; ?></span>, Time: <span class="training_time"><?php echo $training_time; ?></span></th>
        </tr>
        <tr>
            <th class="text-center info">PR</th>
            <th class="text-center success">P1</th>
            <th class="text-center warning">P2</th>
            <th class="text-center danger">P3</th>
            <th class="text-center primary">P4</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr class="danger">
            <th class="text-center" colspan="9">
                <button type="button" class="btn btn-flat btn-primary" id="save_schedule_btn">
                    Save Training Schedule
                </button>
            </th>
        </tr>
    </tfoot>
</table>
<script>
    $(function(){
        loadScheduleTable();
    });

    $('#save_schedule_btn').click(function(e){
        e.preventDefault();
        saveTrainingSchedule();
    });
</script>
