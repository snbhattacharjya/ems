<?php
session_start();
$user_id=$_SESSION['UserID'];
require("../config/config.php")
?>
<h3>
    Pre-Random Exemption Reports
</h3>
<div class="nav-tabs-custom bg-gray"> 
    <ul class="nav nav-tabs">
      <li class="active text-bold text-maroon"><a href="#tab_1" data-toggle="tab">Employee Marked for Exemption</a></li>
      <li class="text-bold text-maroon"><a href="#tab_2" data-toggle="tab">Office Summary</a></li>
      <li class="text-bold text-maroon"><a href="#tab_3" data-toggle="tab">Post Status Summary</a></li>
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
            <div class="employee_exemption_result">
                
            </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <div class="pull-right margin-bottom">
                <button class="load-office-summary btn btn-md btn-flat btn-default text-green"><i class="fa fa-refresh"></i> Refresh</button> 
                <a class="btn btn-md btn-flat btn-default text-red" href="post_random_exemption/office_prerandom_summary_print.php" target="_blank"><i class="fa fa-print"></i> Print</a>
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
                        <th class="text-center exempt_total"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="tab_3">
            <div class="text-right margin-bottom">
                <button class="load-poststat-prerandom-exempt-summary btn btn-md btn-flat btn-default text-blue"><i class="fa fa-refresh"></i> Refresh</button>
                
            </div>
          <div class="poststat-summary-result">
              
          </div>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>
<!-- nav-tabs-custom -->   
<script>
var office_summary_table;
$(function(){
    $('.select2').select2();
   loadEmployeePreRandomExemptDetails();
});

$('.load-office-summary').click(function(e){
    e.preventDefault();
    loadOfficeSummary();
    $(this).remove();
});

function loadOfficeSummary(){
    var office_summary;
    var pp1_total=0;
    var pp2_total=0;
    var exempt_total=0;
    $('#data-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'post_random_exemption/office_prerandom_summary.php',

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
                $('#office_summary tbody').append("<tr><td>"+ (i+1) +"</td><td>"+office_summary[i].officecd+"</td><td>"+office_summary[i].office+"</td><td>"+office_summary[i].address+"</td><td>"+office_summary[i].phone+"</td><td>"+office_summary[i].mobile+"</td><td>"+office_summary[i].exempt_count+"</td></tr>");
                exempt_total += parseInt(office_summary[i].exempt_count);
        });

        var foot_row=$('#office_summary tfoot tr');
        $(foot_row).find('.exempt_total').html(exempt_total);
    }
    else{
        $('#office_summary tbody').empty();
    }
    office_summary_table = $('#office_summary').DataTable({
        paging: false
    });
    $('#data-loader').hide();
}

function loadEmployeePreRandomExemptDetails(){
    $('#data-loader').show();                            
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'post_random_exemption/employee_prerandom_exempt_details.php',
        success: function(data) {
            $('.employee_exemption_result').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
        },
        dataType: "html",
        async: false
    });
    $('#data-loader').hide();
}

$('.load-poststat-prerandom-exempt-summary').click(function(e){
    e.preventDefault();
    $('#data-loader').show();
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'post_random_exemption/subdiv_prerandom_exemption_summary.php',
        success: function(data) {
            $('.poststat-summary-result').html(data);
            $('#data-loader').hide();        
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "html",
        async: false
    });
});
</script>

