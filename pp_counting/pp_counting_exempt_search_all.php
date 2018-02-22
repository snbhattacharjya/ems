<?PHP
session_start();
include("../config/config.php");
?>

<h3 class="page-header">All Exempted Counting Personnel Data</h3> 

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
	url: 'pp_counting/employee_by_office_exempt.php',
        
	success: function(data) {
		employees=JSON.parse(JSON.stringify(data));
		$('#table_employee tbody').empty();
		for(var i=0; i<employees.length; i++)
		{
		
                    var poststat_index=poststat.map(function(data) { return data.post_stat; }).indexOf(employees[i].PostStat);	
                    $('#table_employee').find('tbody').append("<tr><td class='index empcode'>"+employees[i].PersonCode+"</td><td class='index name'>"+employees[i].OfficerName+"</td><td class='personal desg'>"+employees[i].Desg+"</td><td class='personal office_details'>"+employees[i].office_details+"</td><td class='personal poststat'>"+poststat[poststat_index].poststatus+"</td><td class='personal gender'>"+employees[i].Gender+"</td><td class='contact mob_no'>"+employees[i].Mobile+"</td><td class='bank bank_acc_no'>"+employees[i].BankAccNo+"</td><td class='forsubdivision'>"+employees[i].ForSubdivision+"</td></tr>");
			
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
</script>