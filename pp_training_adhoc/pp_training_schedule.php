<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="nav-tabs-custom bg-gray"> 
    <ul class="nav nav-tabs">
        <li class="active text-bold text-maroon"><a href="#tab_1" data-toggle="tab"><i class="fa fa-plus-square"></i> Create Schedule</a></li>
        <li class="text-bold text-maroon"><a href="#tab_2" data-toggle="tab"><i class="fa fa-search"></i> View Schedules</a></li>
    </ul>
    <div class="tab-content">
        <div class="text-center">
            <span id="data-loader" style="display: none">
                <img src="img/ajax_loader_green_128.gif" class="margin-bottom" height="50" width="50">
                <i class="small text-bold text-red" style="display: block">
                    Loading...Please wait
                </i>
            </span>
        </div>
        <div class="tab-pane active" id="tab_1">
            <form role="form">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Training Type:
                            </label>
                            <select class="form-control" id="training_Type">
                                <option value="01">First Training</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Training Date:
                            </label>
                            <input type="text" class="form-control" id="training_date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Training Time:
                            </label>
                            <input type="text" class="form-control" id="training_time">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Venue Name:
                            </label>
                            <select class="select2 form-control" id="venue_base_name"></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <button type="button" class="btn btn-flat btn-success" id="create_schedule_btn">
                                Create Training Schedule
                            </button>
                        </div>
                </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center" style="display: none">
                        <img src="img/ajax_loader_green_128.gif" height="75" width="75" style="display: none" class="schedule-create-progress">
                    </p>
                    <p class="text-green schedule-table-content">
                        
                    </p>
                </div>
            </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <table id="view_schedule_table" class="table table-bordered table-condensed small">
                <thead>
                    <tr class="info">
                        <th colspan="4">
                            Select Venue: 
                            <select class="select2" id="venue_base_name_search"></select> 
                            <button type="button" class="btn btn-md btn-flat btn-success" id="venue_schedule_search_btn"><i class="fa fa-search"></i></button> <a href="#" target="_blank" class="btn btn-md btn-flat btn-danger" id="venue_schedule_print_btn"><i class="fa fa-print"></i></a>
                        </th>
                        <th colspan="3">
                            Enter Training Date: <input type="text" id="training_date_search"> 
                            <button type="button" class="btn btn-md btn-flat btn-success" id="date_schedule_search_btn"><i class="fa fa-search"></i></button> <a href="#" target="_blank" class="btn btn-md btn-flat btn-danger" id="date_schedule_print_btn"><i class="fa fa-print"></i></a>
                        </th>
                    </tr>
                    <tr class="bg-light-blue-gradient">
                        <th>#</th>
                        <th>Venue ID</th>
                        <th>Venue Name</th>
                        <th>Training Date</th>
                        <th>Training Time</th>
                        <th>Post Status</th>
                        <th>Personnel Count</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr class="bg-danger">
                        <th colspan="6" class="text-center">
                            Total Occupancy
                        </th>
                        <th class="text-center total_occupancy"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>
<!-- nav-tabs-custom -->

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
$(function(){
    $('.select2').select2();
    loadVenueBaseName();
    $('#venue_schedule_print_btn').attr('href','pp_training/venue_schedule_print.php?venue_base_name='+$('#venue_base_name_search').val());
});
$('#create_schedule_btn').click(function(e){
    e.preventDefault();
    createTrainingSchedule();
});
$('#venue_schedule_search_btn').click(function(e){
    e.preventDefault();
    viewTrainingSchedule('Venue');
});
$('#date_schedule_search_btn').click(function(e){
    e.preventDefault();
    viewTrainingSchedule('Date');
});
$('#venue_base_name_search').change(function(e){
    e.preventDefault();
    $('#venue_schedule_print_btn').attr('href','pp_training/venue_schedule_print.php?venue_base_name='+$('#venue_base_name_search').val());
});

$('#training_date_search').keyup(function(){
    $('#date_schedule_print_btn').attr('href','pp_training/date_schedule_print.php?training_date='+$('#training_date_search').val());
});
</script>

