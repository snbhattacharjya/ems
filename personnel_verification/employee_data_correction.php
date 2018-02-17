<?PHP
session_start();
include("../config/config.php");

$officecd=$_POST['officecd'];
$office=$_POST['office'];
?>
<input type="text" class="office_code_correction" style="display: none" value="<?php echo $officecd; ?>">
<div class="row">
	<div class="col-md-12">
    	 <div class="box box-solid">
                <div class="box-header bg-red-gradient">
                  <h3 class="box-title">Employee Details for 
                    <span id="show_office" class="text-bold">
                        <?php echo $office." - (".$officecd.")"; ?>
                    </span>
                </h3> 
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                            
               	<div id="div_message" class="callout callout-danger" style="display:none">												
    			</div>
            
            	<div id="show_emp_form">
                <div class="box-header">
                    <a class="btn btn-app" data-target="personal" data-value="ON">
                    	<span class="badge bg-green"><i class="fa fa-check"></i></span>
                        <i class="fa fa-user text-red icon"></i> Personal
                    </a>
                    <a class="btn btn-app" data-target="bank" data-value="OFF">
                      <i class="fa fa-bank icon"></i> Bank
                    </a>
                    <a class="btn btn-app" data-target="epic" data-value="OFF">
                      <i class="fa fa-question-circle icon"></i> Epic
                    </a>
                </div><!-- /.box-header -->
                <div class="overlay text-center" align="center">
                  <img src="img/ajax_loader_green_128.gif" width="50" height="50" />
                  <small> Loading...</small>
                </div>
                  <table id="table_employee" class="table table-bordered table-condensed small" style="display: none">
                    <thead>
                      <tr class="bg-blue-gradient">
                        <th class="index empcode">EMPLOYEE CODE</th>
                        <th class="index name">EMPLOYEE NAME</th>
                        <th class="index desg">DESIGNATION</th>
                        <th class="personal mob_no">MOBILE</th>
                        <th class="bank bank_cd">BANK NAME</th>
                        <th class="bank branchname">BRANCH NAME</th>
                        <th class="bank branchcd">BRANCH IFSC</th>
                        <th class="bank bank_acc_no">BANK ACCOUNT NO</th>
                        <th class="epic epic_no">EPIC NO</th>
                        <th class="epic acno">AC NO</th>
                        <th class="epic partno">PART NO</th>
                        <th class="epic slno">SL NO</th>    
                        <th class="edit">EDIT EMPLOYEE</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>

                    </tfoot>
                  </table>
                  </div>
        	</div><!-- /.box-body -->
       	</div><!-- /.box -->
   	</div><!-- /.col -->
</div><!-- /.row -->
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
<script src="js/personnel.js"></script>
<script type="text/javascript">
var table;
var data_on="<span class='badge bg-green'><i class='fa fa-check'></i></span>";
var data_target_on='personal';
var bank;
var bank_combo;
var remarks;
var employees;
var RecordIndex;
var edit_lock='OPEN';

$(document).ready(function(){	
    loadBankDetails();
    LoadEmployeebyOffice();
});	

function loadBankDetails(){
	$('.overlay').find('small').html(' Loading Bank Data...');
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/bank_details.php',
		success: function(data) {
			bank=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	bank_combo="<select class='bank_combo'>";
	for(var i=0; i<bank.length; i++){
		bank_combo+="<option value='"+bank[i].BankCode+"'>"+bank[i].BankName+"</option>";
	}
	bank_combo+="</select>";
}

function LoadEmployeebyOffice()
{
    $('.overlay').find('small').html(' Loading Employee Data...');
    var officecd=$('.office_code_correction').val();
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'personnel_verification/employee_correction_list_by_office.php', //json/employee_by_office.php
        type: "POST",
        data: {
            officecd: officecd
        },
        success: function(data) {
            employees=JSON.parse(JSON.stringify(data));
            $('#table_employee tbody').empty();
            for(var i=0; i<employees.length; i++)
            {
                var bank_index=bank.map(function(data) { return data.BankCode; }).indexOf(employees[i].Bank);

                $('#table_employee').find('tbody').append("<tr><td class='index empcode'>"+employees[i].PersonCode+"</td><td class='index name'>"+employees[i].OfficerName+"</td><td class='index desg'>"+employees[i].Desg+"</td><td class='personal mob_no'>"+employees[i].Mobile+"</td><td class='bank bank_cd'>"+bank[bank_index].BankName+"</td><td class='bank branchname'>"+employees[i].Branch+"</td><td class='bank branchcd'>"+employees[i].IFSC+"</td><td class='bank bank_acc_no'>"+employees[i].AccountNo+"</td><td class='epic epic_no'>"+employees[i].EPIC+"</td><td class='epic acno'>"+employees[i].ACNO+"</td><td class='epic partno'>"+employees[i].PARTNO+"</td><td class='epic slno'>"+employees[i].SLNO+"</td><td class='edit'>"+"<a href='#' class='edit-link'><span class='fa fa-edit'></span> Edit</a></td></tr>");

            }
            $('.overlay').hide();
            $('.bank, .epic').hide();
            $('#table_employee').show();//alert(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "json",
        async: false
    });

    table=$('#table_employee').DataTable({
        "paging": false,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    }); 	
}

$('.btn-app').click(function(e) {
    e.preventDefault();
	if(edit_lock == 'OPEN'){
		var data_target=$(this).attr('data-target').toString();
		$('.btn-app').find('.icon').removeClass('text-red');
		$('.btn-app').find('span').remove();
		$(this).prepend(data_on);
		$(this).find('.icon').addClass('text-red');
		if(data_target_on != data_target){
			$('.'+data_target_on).hide(50,"linear");
			$('.'+data_target).show();
			data_target_on=data_target;
		}
	}
	else{
		$('#message-modal .modal-body h4').html('Please Cencel the pending Edit Operation in this active section and then proceed !!!');
		$('#message-modal').modal();
	}
});

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
                formatEditForm(data_target_on, row);
                $('.update-link').on('click',function(e){
                    e.preventDefault();
                    updateData(data_target_on, row);
                });
                $('.cancel-link').on('click',function(e){
                    e.preventDefault();
                    cancelDataUpdate(data_target_on, row);
                });
	}
	else{
		$('#message-modal .modal-body h4').html('Please wait for the pending Edit Operation !!!');
		$('#message-modal').modal();
	}
});

function formatEditForm(DataTarget, Row){
	if(DataTarget == 'personal'){
		//Assigning Old Values;
		var officer_name=$(Row).find('.name').html().toString();
		var mob_no=$(Row).find('.mob_no').html().toString();
		
		//Adding Input Feilds
		$(Row).find('.name').html("<input type='text' class='name_input'\>");
		$('.name_input').val(officer_name);
		$(Row).find('.mob_no').html("<input type='text' class='mob_no_input'\>");
		$('.mob_no_input').val(mob_no);
	}
        
	if(DataTarget == 'bank'){
		//Assigning Old Values;
		var bank_cd=employees[RecordIndex].Bank;
		var branchname=$(Row).find('.branchname').html().toString();
		var branchcd=$(Row).find('.branchcd').html().toString();
		var bank_acc_no=$(Row).find('.bank_acc_no').html().toString();
		
		//Adding Input Feilds
		$(Row).find('.bank_cd').html(bank_combo);
		$(Row).find('.bank_cd').find('select').addClass('bank_input');
		$('.bank_input option').each(function() {
                    if($(this).val() == bank_cd)
                        $(this).attr('selected',true);
                });
		
		$(Row).find('.branchname').html("<input type='text' class='branchname_input'\>");
		$('.branchname_input').val(branchname);
		$(Row).find('.branchcd').html("<input type='text' class='branchcd_input'\>");
		$('.branchcd_input').val(branchcd);
		$(Row).find('.bank_acc_no').html("<input type='text' class='bank_acc_no_input'\>");
		$('.bank_acc_no_input').val(bank_acc_no);
		
	}
	
	if(DataTarget == 'epic'){
		//Assigning Old Values;
		var epic_no=$(Row).find('.epic_no').html().toString();
		var partno=$(Row).find('.partno').html().toString();
		var slno=$(Row).find('.slno').html().toString();
                var acno=$(Row).find('.acno').html().toString();
		
		//Adding Input Feilds
		$(Row).find('.epic_no').html("<input type='text' class='epic_no_input'\>");
		$('.epic_no_input').val(epic_no);
		$(Row).find('.partno').html("<input type='text' class='partno_input'\>");
		$('.partno_input').val(partno);
		$(Row).find('.slno').html("<input type='text' class='slno_input'\>");
		$('.slno_input').val(slno);
                $(Row).find('.acno').html("<input type='text' class='acno_input'\>");
		$('.acno_input').val(acno);
		
	}
}

function updateData(DataTarget, Row){
	//Assigining EmpCode
	var emp_code=$(Row).find('.empcode').html().toString();
	var result;
	if(DataTarget == 'personal'){
		//Assigning New Values;
		var officer_name=$(Row).find('.name_input').val().toUpperCase();
		var mobile=$(Row).find('.mob_no_input').val();
		
		if(!checkString(officer_name)){
			$(Row).find('.name').addClass('danger');
			return false;
		}
                if(!checkformobile(mobile)){
			$(Row).find('.mob_no').addClass('danger');
			return false;
		}
		$(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
		result=correctPersonalData(emp_code, officer_name, mobile);
		$(Row).removeClass('warning').find('td').removeClass('danger');
		if(result == 'Success'){
			//Adding Input Values
			$(Row).find('.name').html(officer_name).addClass('success');
			$(Row).find('.mob_no').html(mobile).addClass('success');
			employees[RecordIndex].OfficerName=officer_name;
			employees[RecordIndex].Mobile=mobile;
		}
		else{
			//Adding Old Values
			$(Row).find('.name').html(employees[RecordIndex].OfficerName).addClass('danger');
			$(Row).find('.mob_no').html(employees[RecordIndex].Mobile).addClass('danger');
		}
	}
	
	if(DataTarget == 'bank'){
		//Assigning New Values;
		var bank_cd=$(Row).find('.bank_input').val();
		var branchname=$(Row).find('.branchname_input').val();
		var branchcd=$(Row).find('.branchcd_input').val();
		var bank_acc_no=$(Row).find('.bank_acc_no_input').val();

		var bank_index=bank.map(function(data) { return data.BankCode; }).indexOf(bank_cd);
		
		if(!checkString(branchname)){
			$(Row).find('.branchname').addClass('danger');
			return false;
		}
		
		if(!checkAccNo(bank_acc_no)){
			$(Row).find('.bank_acc_no').addClass('danger');
			return false;
		}
		
		$(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
		result=correctBankData(emp_code, bank_cd, branchname, branchcd, bank_acc_no);
		$(Row).removeClass('warning').find('td').removeClass('danger');
		if(result == 'Success'){
			//Adding Input Values
			$(Row).find('.bank_cd').html(bank[bank_index].BankName).addClass('success');
			$(Row).find('.branchname').html(branchname).addClass('success');
			$(Row).find('.branchcd').html(branchcd).addClass('success');
			$(Row).find('.bank_acc_no').html(bank_acc_no).addClass('success');
			employees[RecordIndex].Bank=bank_cd;
			employees[RecordIndex].Branch=branchname;
			employees[RecordIndex].IFSC=branchcd;
			employees[RecordIndex].AccountNo=bank_acc_no;
		}
		else{
			//Adding Old Values
			var bank_index=bank.map(function(data) { return data.BankCode; }).indexOf(employees[RecordIndex].Bank);
			$(Row).find('.bank_cd').html(bank[bank_index].BankName).addClass('danger');
			
			$(Row).find('.branchname').html(employees[RecordIndex].Branch).addClass('danger');
			$(Row).find('.branchcd').html(employees[RecordIndex].IFSC).addClass('danger');
			$(Row).find('.bank_acc_no').html(employees[RecordIndex].AccountNo).addClass('danger');
		}
	}
	
	if(DataTarget == 'epic'){
		//Assigning New Values;
		var epic_no=$(Row).find('.epic_no_input').val();
		var partno=$(Row).find('.partno_input').val();
		var slno=$(Row).find('.slno_input').val();
                var acno=$(Row).find('.acno_input').val();
		
		if(!checkfornumber(partno)){
			$(Row).find('.partno').addClass('danger');
			return false;
		}
		
		if(!checkfornumber(slno)){
			$(Row).find('.slno').addClass('danger');
			return false;
		}
		
                if(!checkfornumber(acno)){
			$(Row).find('.acno').addClass('danger');
			return false;
		}
		$(Row).find('.edit').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
		result=correctEpicData(emp_code, epic_no, partno, slno, acno);
		$(Row).removeClass('warning').find('td').removeClass('danger');
		if(result == 'Success'){
			//Adding Input Values
			$(Row).find('.epic_no').html(epic_no).addClass('success');
			$(Row).find('.partno').html(partno).addClass('success');
			$(Row).find('.slno').html(slno).addClass('success');
                        $(Row).find('.acno').html(acno).addClass('success');
			employees[RecordIndex].EPIC=epic_no;
			employees[RecordIndex].PARTNO=partno;
			employees[RecordIndex].SLNO=slno;
                        employees[RecordIndex].ACNO=acno;
		}
		else{
			//Adding Old Values
			$(Row).find('.epic_no').html(employees[RecordIndex].EPIC).addClass('danger');
			$(Row).find('.partno').html(employees[RecordIndex].PARTNO).addClass('danger');
			$(Row).find('.slno').html(employees[RecordIndex].SlNO).addClass('danger');
                        $(Row).find('.acno').html(employees[RecordIndex].ACNO).addClass('danger');
		}
	}
	
	$(Row).find('.edit').html("<a href='#' class='edit-link'><span class='fa fa-edit'></span> Edit</a>");
	edit_lock='OPEN';
}

function cancelDataUpdate(DataTarget, Row){
	$(Row).removeClass('warning').find('td').removeClass('danger');
	if(DataTarget == 'personal'){
		//Adding Old Values
		$(Row).find('.name').html(employees[RecordIndex].OfficerName);
		$(Row).find('.mob_no').html(employees[RecordIndex].Mobile);
	}
	
	if(DataTarget == 'bank'){
		//Adding Old Values
		var bank_index=bank.map(function(data) { return data.BankCode; }).indexOf(employees[RecordIndex].Bank);
		$(Row).find('.bank_cd').html(bank[bank_index].BankName);
			
		$(Row).find('.branchname').html(employees[RecordIndex].Branch);
		$(Row).find('.branchcd').html(employees[RecordIndex].IFSC);
		$(Row).find('.bank_acc_no').html(employees[RecordIndex].AccountNo);
	}
	
	if(DataTarget == 'epic'){
		//Adding Old Values
		$(Row).find('.epic_no').html(employees[RecordIndex].EPIC);
		$(Row).find('.partno').html(employees[RecordIndex].PARTNO);
		$(Row).find('.slno').html(employees[RecordIndex].SLNO);
                $(Row).find('.acno').html(employees[RecordIndex].ACNO);
	}
	
	$(Row).find('.edit').html("<a href='#' class='edit-link'><span class='fa fa-edit'></span> Edit</a>");
	edit_lock='OPEN';
}

function correctPersonalData(EmpCode, OfficerName, Mobile){
	var result;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'personnel_verification/correct_personal_data.php',
		type: 'POST',
		data: {
				EmpCode: EmpCode,
				OfficerName: OfficerName,
				Mobile: Mobile
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

function correctBankData(EmpCode, BankCd, BranchName, BranchCd, BankAccNo){
	var result;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'personnel_verification/correct_bank_data.php',
		type: 'POST',
		data: {
				EmpCode: EmpCode,
				BankCd: BankCd,
				BranchName: BranchName,
				BranchCd: BranchCd,
				BankAccNo: BankAccNo
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

function correctEpicData(EmpCode, EpicNo, PartNo, SlNo, AcNo){
	var result;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'personnel_verification/correct_epic_data.php',
		type: 'POST',
		data: {
				EmpCode: EmpCode,
				EpicNo: EpicNo,
				PartNo: PartNo,
				SlNo: SlNo,
                                AcNo: AcNo
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