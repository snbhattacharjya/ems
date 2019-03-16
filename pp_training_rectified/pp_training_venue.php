<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="nav-tabs-custom bg-gray"> 
    <ul class="nav nav-tabs">
        <li class="active text-bold text-maroon"><a href="#tab_1" data-toggle="tab"><i class="fa fa-plus-square"></i> Add</a></li>
        <li class="text-bold text-maroon"><a href="#tab_2" data-toggle="tab"><i class="fa fa-edit"></i> Edit</a></li>
        <li class="text-bold text-maroon"><a href="#tab_3" data-toggle="tab"><i class="fa fa-print"></i> Print Report</a></li>
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
            <div class="row">
                <div class="col-md-6">
                    <form role="form">
                        <div class="form-group">
                            <label class="control-label">
                                Venue Assembly:
                            </label>
                            <select class="select2 form-control" id="venue_assembly"></select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                Venue Name:
                            </label>
                            <input type="text" class="form-control" id="venue_name">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                Address1:
                            </label>
                            <input type="text" class="form-control" id="address1">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                Address2:
                            </label>
                            <input type="text" class="form-control" id="address2">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                Rooms:
                            </label>
                            <input type="text" class="form-control" id="rooms">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                Capacity @ each Room (can be modified individually from Edit Option):
                            </label>
                            <input type="text" class="form-control" id="capacity">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-flat btn-success pull-right" id="add_venue_btn">
                                Add New Venue
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-center">
                    <img src="img/ajax_loader_green_128.gif" height="75" width="75" style="display: none" class="venue-add-progress">
                    <p class="text-green venue-add-success" style="display: none">
                        <i class="fa fa-check-circle fa-3x"></i>
                    </p>
                    <p class="text-red venue-add-error" style="display: none">
                        <i class="fa fa-warning fa-3x"></i>
                    </p>
                </div>
            </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <table id="venue_room_table" class="table table-bordered table-condensed small">
                <thead>
                    <tr class="info">
                        <th colspan="5" class="text-right">
                            Select Venue: 
                            <select class="select2" id="venue_base_name"></select> 
                            <button type="button" class="btn btn-md btn-flat btn-success" id="venue_search_btn"><i class="fa fa-search"></i></button>
                        </th>
                    </tr>
                    <tr class="bg-light-blue-gradient">
                        <th>#</th>
                        <th>Venue ID</th>
                        <th>Venue Name</th>
                        <th>Capacity</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr class="bg-danger">
                        <th colspan="3" class="text-center">
                            Total
                        </th>
                        <th class="text-center total_capacity"></th>
                        <th>&nbsp;</th>
                    </tr>
                </tfoot>
            </table>
        </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="tab_3">
          <div class="row">
              <div class="col-md-4">
                  <ul class="nav nav-pills nav-stacked">
                      <li class="text-bold"><a href="#" class="generate-report text-green" data-target="office_summary">Office Summary Report</a></li>
                    <li class="text-bold"><a href="#" class="generate-report text-green" data-target="employee_exempt_details">Employee Marked for Exemption</a></li>
                  </ul>
              </div>
              <div class="col-md-8 text-center pad">
                  <a href="pdf/print_report.php" target="_blank" class="report-btn btn btn-lg btn-primary" style="display: none; width: 50%"><i class="fa fa-print"></i> View Report</a>
              </div>
          </div>
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
    loadAssemblySubdivUser();
    loadVenueBaseName();
});
$('#add_venue_btn').click(function(e){
    e.preventDefault();
    addTrainingVenue();
});
$('#venue_search_btn').click(function(e){
    e.preventDefault();
    loadVenueRooms();
});
</script>

