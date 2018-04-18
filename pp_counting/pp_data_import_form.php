<?PHP
session_start();
include("../config/config.php");
$officecd=$_POST['officecd'];
//die('Permission Denied!');
?>

<h3 class="page-header">Import Personnel for Counting for Office Code: <span class="officecd"><?php echo $officecd; ?></span></h3>

<div class="overlay text-center" align="center">
  <img src="img/ajax_loader_green_128.gif" width="50" height="50" />
  <small> Loading...</small>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-warning" id="report_panel" style="display: none">
            <div class="panel-heading text-bold"><i class="fa fa-info-circle text-blue"></i>&nbsp;&nbsp;<span id="report_result">Msg Panel</span></div>
        </div>
    </div>
</div><!-- End Row 3 -->
<table id="table_employee" class="table table-bordered table-condensed small">
    <thead>
        <tr class="danger">
            <th colspan="7">
                <button class="btn btn-default" id="exportPP"><i class="fa fa-cloud-upload text-green"></i> Export Selected <span class="selected_pp_count badge">0</span></button>

                <input type="text" class="input-sm pull-right" placeholder="Search Employee" id="search-text">
            </th>
        </tr>
        <tr class="bg-blue-active">
            <th><input type="checkbox" class="select-all"></th>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Designation</th>
            <th>Gender</th>
            <th>Mobile No</th>
            <th>Counting Post Status</th>
        </tr>
    </thead>
    <tbody>

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

<script type="text/javascript">
var poststat;
var poststat_combo;

var emp;
var selected_pp=0;

$(document).ready(function(){
    //$('#table_employee').hide();

    loadPostStatus();
    LoadEmployeebyOfficeImport();
});

function loadPostStatus(){
    $('.overlay').find('small').html(' Loading Post Status...');
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/counting_poststatus_details.php',
            success: function(data) {
                    poststat=JSON.parse(JSON.stringify(data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
            },
            dataType: "json",
            async: false
    });
    poststat_combo="<select class='poststat_combo'>";
    for(var i=0; i<poststat.length; i++){
            poststat_combo+="<option value='"+poststat[i].post_stat+"'>"+poststat[i].poststatus+"</option>";
    }
    poststat_combo+="</select>";
}

function LoadEmployeebyOfficeImport()
{
    var officecd = $('.officecd').html().toString();
    $('.overlay').find('small').html(' Loading Employee Data...');
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'pp_counting/employee_by_office_import.php',
        type: "POST",
        data: {
            officecd: officecd
        },
        success: function(data) {
                emp=JSON.parse(JSON.stringify(data));
                if(emp.length > 0){
                    $('#total_pp').html(emp.length);
                    $('#table_employee tbody').empty();
                    $.each(emp, function(i){
                        $('#table_employee tbody').append("<tr><td><input type='checkbox' class='select-pp'></td><td class='personcd'>"+emp[i].personcd+"</td><td>"+emp[i].officer_name+"</td><td>"+emp[i].off_desg+"</td><td>"+emp[i].gender+"</td><td>"+emp[i].mob_no+"</td><td>"+poststat_combo+"</td></tr>");
                    });

                    $('.select-pp').change(function(e){
                        e.preventDefault();
                        var row=$(this).closest('tr');
                        if(row.hasClass('warning')){
                            row.removeClass('warning');
                            selected_pp -= 1;
                            $('.selected_pp_count').html(selected_pp);
                        }
                        else{
                            row.addClass('warning');
                            selected_pp += 1;
                            $('.selected_pp_count').html(selected_pp);
                        }
                    });
                }
                else{
                    $('#table_employee tbody').empty();
                }

                $('.overlay').hide();

        },
        error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
        },
        dataType: "json",
        async: false
    });
}

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
        $("#table_employee tbody tr").addClass('warning');
        $('#table_employee tbody .select-pp').prop('checked',true);
        $('.selected_pp_count').html(emp.length);
    }
    else{
        $("#table_employee tbody tr").removeClass('warning');
        $('#table_employee tbody .select-pp').prop('checked',false);
        $('.selected_pp_count').html('0');
    }
});

$('#exportPP').click(function(e){
    e.preventDefault();
    $('.overlay').show();
    $('.overlay').find('small').html(' Exporting Data...');
    var emp_export_count=0;
    var rows=$('#table_employee tbody tr');
    var total_pp=rows.length;
    $.each(rows,function(index){
        if($(this).hasClass('warning')){
            var emp_code=$(this).find('.personcd').html().toString();
            var poststat=$(this).find('.poststat_combo').val();
            var result;

                $.ajax({
                        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                        url: 'pp_counting/export_employee.php',
                        type: 'POST',
                        data: {
                                personcd: emp_code,
                                poststat: poststat
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
                    emp_export_count += 1;
                    total_pp -= 1;
                    $(this).hide();
                    $('#total_pp').html(total_pp);
                }
                else{
                    alert(result.Status);
                }

            if(emp_export_count != selected_pp){
                $('.body-text').html("ERROR - Some Personnel Cannot be Marked for Counting");
                $('.modal-header').addClass('bg-red');
                $('#message-modal').modal('show');
            }
            else{
                $('.body-text').html("All Selected Personnel Successfully Marked for Counting");
                $('.modal-header').addClass('bg-green');
                $('#message-modal').modal('show');
            }
        }
    });
    $(rows).removeClass('warning');
    $(rows).find('.select-pp').prop('checked',false);
    selected_pp = 0;
    $('.selected_pp_count').html(selected_pp);
    $('.overlay').hide();
});
</script>
