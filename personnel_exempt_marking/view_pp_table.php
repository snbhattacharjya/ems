<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="nav-tabs-custom bg-gray"> 
    <ul class="nav nav-tabs">
      <li class="active text-bold text-maroon"><a href="#tab_1" data-toggle="tab">Employee Marked for Exemption</a></li>
      <li class="text-bold text-maroon"><a href="#tab_2" data-toggle="tab">Office Summary</a></li>
      <li class="text-bold text-maroon"><a href="#tab_3" data-toggle="tab">Print Report</a></li>
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
          <table id="employee_exempt_details" class="table table-bordered table-condensed small">
                <thead>
                    <tr class="bg-light-blue-gradient">
                        <th>#</th>
                        <th>Office ID</th>
                        <th>Office Name</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Designation</th>
                        <th>Mobile</th>
                        <th>Remarks</th>
                        <th>Reason for Exemption</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <div class="text-center margin-bottom">
                <button class="load-office-summary btn btn-lg btn-flat btn-success"> Load Office Summary</button>
            </div>
            <table id="office_summary" class="table table-bordered table-condensed small">
                <thead>
                    <tr class="bg-light-blue-gradient">
                        <th>#</th>
                        <th>Office ID</th>
                        <th>Office Name</th>
                        <th>Address</th>
                        <th>Contact No</th>
                        <th>Mobile No</th>
                        <th>PP1 Count</th>
                        <th>PP2 Count</th>
                        <th>Marked for Exemption</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr class="bg-danger">
                        <th colspan="6" class="text-center">
                            Total
                        </th>
                        <th class="text-center pp1_total"></th>
                        <th class="text-center pp2_total"></th>
                        <th class="text-center exempt_total"></th>
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
var office_summary_report;
var employee_exempt_report;
var office_summary_table;
$(function(){
   loadEmployeeExemptDetails();
});

$('.load-office-summary').click(function(e){
    e.preventDefault();
    loadOfficeSummary();
    $(this).parent('div').remove();
});

function loadOfficeSummary(){
    office_summary_report='';
    var office_summary;
    var pp1_total=0;
    var pp2_total=0;
    var exempt_total=0;
    $('#data-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'personnel_exempt_marking/office_summary.php',

            success: function(data) {
                office_summary=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
    });
    if(office_summary.length > 0){
        $('#office_summary tbody').empty();
        $.each(office_summary,function(i){
                office_summary_report += "<tr><td>"+ (i+1) +"</td><td>"+office_summary[i].officecd+"</td><td>"+office_summary[i].office+"</td><td>"+office_summary[i].address+"</td><td>"+office_summary[i].phone+"</td><td>"+office_summary[i].mobile+"</td><td>"+office_summary[i].pp1_count+"</td><td>"+office_summary[i].pp2_count+"</td><td>"+office_summary[i].exempt_count+"</td></tr>";
                $('#office_summary tbody').append("<tr><td>"+ (i+1) +"</td><td>"+office_summary[i].officecd+"</td><td>"+office_summary[i].office+"</td><td>"+office_summary[i].address+"</td><td>"+office_summary[i].phone+"</td><td>"+office_summary[i].mobile+"</td><td>"+office_summary[i].pp1_count+"</td><td>"+office_summary[i].pp2_count+"</td><td>"+office_summary[i].exempt_count+"</td></tr>");
                pp1_total += parseInt(office_summary[i].pp1_count);
                pp2_total += parseInt(office_summary[i].pp2_count);
                exempt_total += parseInt(office_summary[i].exempt_count);
        });
        office_summary_report = "<table border=\"1\" width=\"auto\">" + $('#office_summary thead').html() + office_summary_report;
        var foot_row=$('#office_summary tfoot tr');
        $(foot_row).find('.pp1_total').html(pp1_total);
        $(foot_row).find('.pp2_total').html(pp2_total);
        $(foot_row).find('.exempt_total').html(exempt_total);
        
        office_summary_report += $('#office_summary tfoot').html() + "</table>";
    }
    else{
        $('#office_summary tbody').empty();
    }
    office_summary_table = $('#office_summary').DataTable();
    $('#data-loader').hide();
}

function loadEmployeeExemptDetails(){
    employee_exempt_report='';
    var employee_exempt_details;
    $('#data-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'personnel_exempt_marking/employee_exempt_details.php',

            success: function(data) {
                    employee_exempt_details=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "json",
            async: false
    });
    if(employee_exempt_details.length > 0){
        $('#employee_exempt_details tbody').empty();
        $.each(employee_exempt_details,function(i){
            employee_exempt_report += "<tr><td>"+ (i+1) +"</td><td>"+employee_exempt_details[i].officecd+"</td><td>"+employee_exempt_details[i].office+"</td><td class='personcd'>"+employee_exempt_details[i].personcd+"</td><td>"+employee_exempt_details[i].officer_name+"</td><td>"+employee_exempt_details[i].off_desg+"</td><td>"+employee_exempt_details[i].mob_no+"</td><td>"+employee_exempt_details[i].remarks+"</td><td>"+employee_exempt_details[i].reason+"</td></tr>";
            
            $('#employee_exempt_details tbody').append("<tr><td>"+ (i+1) +"</td><td>"+employee_exempt_details[i].officecd+"</td><td>"+employee_exempt_details[i].office+"</td><td class='personcd'>"+employee_exempt_details[i].personcd+"</td><td>"+employee_exempt_details[i].officer_name+"</td><td>"+employee_exempt_details[i].off_desg+"</td><td>"+employee_exempt_details[i].mob_no+"</td><td>"+employee_exempt_details[i].remarks+"</td><td>"+employee_exempt_details[i].reason+"</td><td class='text-center'><a href='#' class='remove-exempt-pp'><i class='fa fa-minus-circle text-red'></i></a></td></tr>");
        });
        
        var table=$('#employee_exempt_details').DataTable({
            paging:false
        });
        employee_exempt_report = "<table border=\"1\" width=\"100%\">" + "<tr><th>Sl. No.</th><th>Office ID</th><th>Office Name</th><th>Employee ID</th><th>Employee Name</th><th>Designation</th><th>Mobile</th><th>Remarks</th><th>Reason for Exemption</th></tr>" + employee_exempt_report + "</table>";

        $('.remove-exempt-pp').click(function(e){
            e.preventDefault();
            var row=$(this).closest('tr');
            var result;
            var personcd = $(row).find('.personcd').html().toString();
            $(this).html("<i class='fa fa-spinner fa-spin text-orange'></i>");
            $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: 'personnel_exempt_marking/employee_exempt_remove.php',
                type: "POST",
                data: {
                    personcd: personcd
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
                $(row).hide();
            }
            else{
                $(this).html("<i class='fa fa-minus-circle text-red'></i>");
            }
        });
    }
    else{
        $('#employee_exempt_details tbody').empty();
    }
    $('#data-loader').hide();
}

$('.generate-report').click(function(e){
    e.preventDefault();
    var link=$(this);
    $(this).append("<span class='pull-right'><i class='fa fa-spinner fa-spin text-orange'></i></span>");
    var data_target=$(this).attr('data-target').valueOf();
    var report_html;
    var file_name;
    var report_title;
    if(data_target == 'office_summary'){
        file_name = 'Office_Personnel_Summary';
        report_title = 'Office Personnel Summary';
        report_html = office_summary_report;
    }
    else{
        file_name = 'Exempted_Personnel_List';
        report_title = 'Exempted Personnel List';
        report_html = employee_exempt_report;
    }
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'personnel_exempt_marking/generate_pdf_report.php',
            type: "POST",
            data: {
                report: report_html,
                file_name: file_name,
                report_title: report_title
            },
            success: function() {
               $('.report-btn').show();
               $(link).find('span').remove();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
        });
});

$('.report-btn').click(function(){
    $(this).hide();
});
</script>

