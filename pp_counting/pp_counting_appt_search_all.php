<?PHP
session_start();
include("../config/config.php");
?>

<h3 class="page-header">All Booked Counting Personnel Data</h3> 

<div class="overlay text-center" align="center">
  <img src="img/ajax_loader_green_128.gif" width="50" height="50" />
  <small> Loading...</small>
</div>

<table id="table_employee" class="table table-bordered table-condensed small" style="display:none">
    <thead>
      <tr class="bg-blue-gradient">
        <th class="index empcode">EMPLOYEE CODE</th>
        <th class="index name">EMPLOYEE NAME</th>
        <th class="personal desg">DESIGNATION</th>
        <th class="personal office_details">OFFICE DETAILS</th>
        <th class="personal poststat">POST STATUS</th>
        <th class="personal gender">GENDER</th>
        <th class="contact mob_no">MOBILE</th>
        <th class="bank bank_acc_no">BANK Ac/No</th>
        <th class="forsubdivision">FOR SUBDIVISION</th>
        <th class="edit">EDIT EMPLOYEE</th>
        <th class="edit">1st Appointment Letter</th>
        <th class="edit">2nd Appointment Letter</th>
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
      <div class="modal-header bg-red-gradient">
        <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
        <h3 class="modal-title"><strong><i class="fa fa-warning text-yellow"></i></strong> Warning Message</h3>
      </div>
      <div class="modal-body">
		<h4></h4>
      </div>
      
    </div>

  </div>
</div>	

<script type="text/javascript">
var table;
var assembly;
var assembly_combo;
var poststat;
var poststat_combo;
var employees;
var RecordIndex;
var edit_lock='OPEN';
$(document).ready(function(){	
    $('#table_employee').hide();

    loadAssemblyDetails();
    loadPostStatus();
    LoadEmployeebyOffice();
});	

function loadAssemblyDetails(){
	$('.overlay').find('small').html(' Loading Assembly Data...');
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/assembly_details.php',
		success: function(data) {
			assembly=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	assembly_combo="<select class='assembly_combo'>";
	for(var i=0; i<assembly.length; i++){
		assembly_combo+="<option value='"+assembly[i].AssemblyCode+"'>"+assembly[i].AssemblyName+"</option>";
	}
	assembly_combo+="</select>";
}

function loadPostStatus(){
    $('.overlay').find('small').html(' Loading Post Status...');
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/poststatus_details.php',
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

function LoadEmployeebyOffice()
{
	$('.overlay').find('small').html(' Loading Employee Data...');
	$.ajax({
	mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
	url: 'pp_counting/employee_by_office_appt.php',
        
	success: function(data) {
		employees=JSON.parse(JSON.stringify(data));
		$('#table_employee tbody').empty();
		for(var i=0; i<employees.length; i++)
		{
		
                    var poststat_index=poststat.map(function(data) { return data.post_stat; }).indexOf(employees[i].PostStat);	
                    $('#table_employee').find('tbody').append("<tr><td class='index empcode'>"+employees[i].PersonCode+"</td><td class='index name'>"+employees[i].OfficerName+"</td><td class='personal desg'>"+employees[i].Desg+"</td><td class='personal office_details'>"+employees[i].office_details+"</td><td class='personal poststat'>"+poststat[poststat_index].poststatus+"</td><td class='personal gender'>"+employees[i].Gender+"</td><td class='contact mob_no'>"+employees[i].Mobile+"</td><td class='bank bank_acc_no'>"+employees[i].BankAccNo+"</td><td class='forsubdivision'>"+employees[i].ForSubdivision+"</td><td class='edit'>"+"<a href='#' class='edit-link'><span class='fa fa-edit'></span> Edit</a></td><td class='appt'>"+"<a href='pp_counting/pp_counting_appt_personcd.php?personcd="+employees[i].PersonCode+"' target='_blank'><span class='fa fa-print'></span> Print</a></td><td class='appt'>"+"<a href='pp_counting/pp_counting_appt2_personcd.php?personcd="+employees[i].PersonCode+"' target='_blank'><span class='fa fa-print'></span> Print</a></td></tr>");
			
		}
		$('.overlay').hide();
		$('#table_employee').show();
	},
        error: function (jqXHR, textStatus, errorThrown) {
		alert(errorThrown);
	},
	dataType: "json",
	async: false
	});
	
	table=$('#table_employee').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
	}); 	
}

$('#table_employee tbody').on('click','.edit-link',function(e){
	e.preventDefault();
	//alert($(this).html());
	if(edit_lock == 'OPEN'){
            var row=$(this).closest('tr');
            var edit_cell=$(this).closest('td');
            var emp_code=$(row).find('.empcode').html().toString();//alert(emp_code);
            RecordIndex = employees.map(function(data) { return data.PersonCode; }).indexOf(emp_code);

            edit_lock='LOCK';
            row.addClass('warning');
            $(edit_cell).html("<a href='#' class='update-link text-green'><span class='fa fa-save'></span> Save</a> &nbsp;&nbsp; <a href='#' class='cancel-link text-red'><span class='fa fa-close'></span> Cancel</a>");
            formatEditForm(row);
            $('.update-link').on('click',function(e){
                e.preventDefault();
                updateData(row);
            });
            $('.cancel-link').on('click',function(e){
                e.preventDefault();
                cancelDataUpdate(row);
            });
                
	}
	else{
            $('#message-modal .modal-body h4').html('Please wait for the pending Edit Operation !!!');
            $('#message-modal').modal();
	}
});

function formatEditForm(Row){
    //Assigning Old Values;
    var officer_name=$(Row).find('.name').html().toString();
    var desg=$(Row).find('.desg').html().toString();
    var gender=$(Row).find('.gender').html().toString();
    var mob_no=$(Row).find('.mob_no').html().toString();

    //Adding Input Feilds
    $(Row).find('.name').html("<input type='text' class='name_input'\>");
    $('.name_input').val(officer_name);
    $(Row).find('.desg').html("<input type='text' class='desg_input'\>");
    $('.desg_input').val(desg);
    $(Row).find('.mob_no').html("<input type='text' class='mob_no_input'\>");
    $('.mob_no_input').val(mob_no);

    var gender_combo="<select class='gender_combo'><option value='M'>M</option><option value='F'>F</option></select>";
    $(Row).find('.gender').html(gender_combo);
    $(Row).find('.gender').find('select').addClass('gender_input');
    $('.gender_input option').each(function() {
        if($(this).val() == gender)
            $(this).attr('selected',true);
    });
}

function updateData(Row){
    //Assigining EmpCode
    var emp_code=$(Row).find('.empcode').html().toString();
    var result;
    //Assigning New Values;
    var officer_name=$(Row).find('.name_input').val();
    var desg=$(Row).find('.desg_input').val();
    var gender=$(Row).find('.gender_input').val();
    var mob_no=$(Row).find('.mob_no_input').val();
    if(!checkString(officer_name)){
        $(Row).find('.name').addClass('danger');
        return false;
    }
    $(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
    result=updatePersonalApptSearchData(emp_code, officer_name, desg, mob_no, gender);
    $(Row).removeClass('warning').find('td').removeClass('danger');
    if(result == 'Success'){
        //Adding Input Values
        $(Row).find('.name').html(officer_name).addClass('success');
        $(Row).find('.desg').html(desg).addClass('success');
        $(Row).find('.gender').html(gender).addClass('success');
        $(Row).find('.mob_no').html(mob_no).addClass('success');
        
        employees[RecordIndex].OfficerName=officer_name;
        employees[RecordIndex].Desg=desg;
        employees[RecordIndex].Mobile=mob_no;
        employees[RecordIndex].Gender=gender;
    }
    else{
        //Adding Old Values
        $(Row).find('.name').html(employees[RecordIndex].OfficerName).addClass('danger');
        $(Row).find('.desg').html(employees[RecordIndex].Desg).addClass('danger');
        $(Row).find('.gender').html(employees[RecordIndex].Gender).addClass('danger');
        $(Row).find('.mob_no').html(employees[RecordIndex].Mobile).addClass('danger');
        
    }
    $(Row).find('.edit').html("<a href='#' class='edit-link'><span class='fa fa-edit'></span> Edit</a>");
    edit_lock='OPEN';
}

function cancelDataUpdate(Row){
    $(Row).removeClass('warning').find('td').removeClass('danger');
    //Adding Old Values
    $(Row).find('.name').html(employees[RecordIndex].OfficerName);
    $(Row).find('.desg').html(employees[RecordIndex].Desg);
    $(Row).find('.gender').html(employees[RecordIndex].Gender);
    $(Row).find('.mob_no').html(employees[RecordIndex].Mobile);
    $(Row).find('.edit').html("<a href='#' class='edit-link'><span class='fa fa-edit'></span> Edit</a>");
    edit_lock='OPEN';
}

function updatePersonalApptSearchData(EmpCode, OfficerName, Desg, Mobile, Gender){
    var result;
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'pp_counting/update_personal_appt_search.php',
        type: 'POST',
        data: {
            EmpCode: EmpCode,
            OfficerName: OfficerName,
            Desg: Desg,
            Mobile: Mobile,
            Gender: Gender
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
    return result.Status;
}
</script>