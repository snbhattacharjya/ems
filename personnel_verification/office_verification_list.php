<div class="box box-solid">
    <div class="box-header bg-teal-active">
        <h3 class="box-title text-bold">Personnel Verification for EPIC/AC No/PART/SL, Mobile and Bank Details</h3> 
    </div><!-- /.box-header -->

    <div class="box-body">
<div class="text-center">
    <img src="img/ajax_loader_green_128.gif" class="margin-bottom" height="50" width="50" style="display: none" id="data-loader">
</div>
<table id="office_summary" class="table table-bordered table-condensed small">
    <thead>
        <tr class="bg-blue-gradient">
            <th>Sl. No.</th>
            <th>Office ID</th>
            <th>Office Name</th>
            <th>Block / Municipality</th>
            <th>Address</th>
            <th>Contact No</th>
            <th>Mobile No</th>
            <th>PP1 Count</th>
            <th>PP2 Count</th>
            <th>Data Correction</th>
            <th>Verification Report (PDF/HTML)</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr class="bg-danger">
            <th colspan="8" class="text-center">
                Total
            </th>
            <th class="text-center pp1_total"></th>
            <th class="text-center pp2_total"></th>
            <th class="text-center">&nbsp;</th>
        </tr>
    </tfoot>
</table>
</div><!-- /.box-body -->
</div><!-- /.box -->
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
var report_html;
var report_lock=0;
var download_lock=0;
$(function(){
   loadOfficeSummary();
});
function loadOfficeSummary(){
    var office_summary;
    var pp1_total=0;
    var pp2_total=0;
    $('#data-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'personnel_verification/office_summary_verification.php',

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
                $('#office_summary tbody').append("<tr><td>"+ (i+1) +"</td><td class='officecd'>"+office_summary[i].officecd+"</td><td class='office'>"+office_summary[i].office+"</td><td>"+office_summary[i].blockmuni+"</td><td>"+office_summary[i].address+"</td><td>"+office_summary[i].phone+"</td><td>"+office_summary[i].mobile+"</td><td>"+office_summary[i].pp1_count+"</td><td>"+office_summary[i].pp2_count+"</td><td class='text-center'><a href='#' class='data-correction btn btn-default btn-sm text-red'><i class='fa fa-edit'></i></a></td><td class='text-center'><a href='#' class='report-btn btn btn-warning btn-sm'><i class='loader fa fa-file-pdf-o'></i></a>&nbsp; <a href='personnel_verification/employee_verification_list_html.php?officecd="+office_summary[i].officecd+"' class='btn btn-info btn-sm' target='_blank'><i class='fa fa-file-excel-o'></i></a></td></tr>");
                pp1_total += parseInt(office_summary[i].pp1_count);
                pp2_total += parseInt(office_summary[i].pp2_count);
        });

        var foot_row=$('#office_summary tfoot tr');
        $(foot_row).find('.pp1_total').html(pp1_total);
        $(foot_row).find('.pp2_total').html(pp2_total);
        
        $('.data-correction').on('click', function(e){
            e.preventDefault();
            var officecd=$(this).closest('tr').find('.officecd').html().toString();
            var office=$(this).closest('tr').find('.office').html().toString();
            $('#page_content').html("<div class='text-center'><img src='img/ajax_loader_green_128.gif'></div>");
            $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: 'personnel_verification/employee_data_correction.php',
                type: "POST",
                data: {
                    officecd: officecd,
                    office: office
                },
                success: function(data) {
                    $('#page_content').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "html",
                async: false
            });
        });
        
        $('.report-btn').on('click', function(e){
            var link=$(this);
            var officecd=$(this).closest('tr').find('.officecd').html().toString();
            report_html='';
            $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: 'personnel_verification/employee_verification_list.php',
                type: "POST",
                data: {
                    officecd: officecd
                },
                success: function(data) {
                    report_html=data;
                    $.ajax({
                        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                        url: 'personnel_verification/generate_verification_pdf_report.php',
                        type: "POST",
                        data: {
                            report: report_html,
                            file_name: officecd
                        },
                        success: function() {
                            $(link).attr('href','pdf/print_report.php');
                            $(link).attr('target','_blank');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(errorThrown);
                        },
                        dataType: "html",
                        async: false
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "html",
                async: false
            });
        });
    }
    else{
        $('#office_summary tbody').empty();
    }
    var office_summary_table = $('#office_summary').DataTable();
    $('#data-loader').hide();
}

</script>
