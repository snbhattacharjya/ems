<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<table id="table_employee" class="table table-bordered table-condensed small">
    <thead>
        <tr>
            <th colspan="4" class="info">
                    <select id="office" class="select2" multiple="multiple" style="width: 75%"></select>
                    <button class="btn btn-warning" id="loadPP"><i class="fa fa-search"></i> Load PP</button>
            </th>
            <th rowspan="2" class="success text-center" style="vertical-align: middle">
                <button class="btn btn-primary" id="resetPP"><i class="fa fa-refresh"></i> Reset</button>
            </th>
            <th colspan="3" rowspan="2" class="warning text-center"  style="vertical-align: middle">
                <button class="btn btn-danger" id="exemptPP"><i class="fa fa-user-times"></i> Mark PP for Exemption</button>
                <img src="img/ajax_loader_green_128.gif"  class="pull-right" height="30" width="30" style="display: none" id="data-loader">
            </th>
        </tr>
        <tr>
            <th colspan="4" class="danger">
                <div class="input-group input-group-sm">
                    <input type="text" id="emp_search" class="form-control" placeholder="Search Personnel by Name or ID. For multiple use value1,value2, ..." style="width: 100%">
                    <div class="input-group-btn">
                        <button class="btn btn-warning dropdown-toggle" id="searchPP" data-toggle="dropdown"><i class="fa fa-search"></i> Search By <span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="id_search">ID</a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="name_search">Name</a></li>
                        </ul>
                    </div>
                </div>
            </th>
        </tr>
        <tr class="bg-gray">
            <th colspan="9">
                Total: <span id="total_pp">0</span>, Selected: <span id="selected_pp">0</span>
                <input type="text" class="input-sm pull-right" placeholder="Search Employee" id="search-text">
            </th>
        </tr>
        <tr class="bg-blue-active">
            <th><input type="checkbox" class="select-all"></th>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Employee Designation</th>
            <th>Post Status</th>
            <th>Mobile No</th>
            <th>Remarks</th>
            <th>Reason for Exemption</th>
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
<script>
    var emp;
    var selected_pp=0;
    $('.select2').select2();
    /*$('input[type="checkbox"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-green'
    });*/
    $(function(){
        loadOffice();
    });
    function loadOffice(){
	var office;
	$('#office').select2({placeholder: 'Loading Office...'});
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/office_by_blockmuni.php',

		success: function(data) {
			office=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	if(office.length > 0){
		$('#office').empty();
		$.each(office,function(i){
			$('#office').append( "<option value='"+office[i].OfficeCode+"'>"+ office[i].OfficeCode + ' - ' +office[i].OfficeName + "</option>");
		});
		$('#office').select2({placeholder: 'Select Office'});
	}
	else{
		$('#office').empty();
	}
    }

    $('#loadPP').click(function(e){
        e.preventDefault();
        $('#data-loader').show();
        $('#office').prop('disabled',true);
        $('#loadPP').prop('disabled',true);
        $.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'post_random_exemption/employee_by_office.php',
		type: 'POST',
                data: {
                        OfficeCode: $('#office').val()
                },
		success: function(data) {
			emp=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});

        if(emp.length > 0){
            $('#total_pp').html(emp.length);
            $('#table_employee tbody').empty();
            $.each(emp, function(i){
                $('#table_employee tbody').append("<tr><td><input type='checkbox' class='select-pp'></td><td class='personcd'>"+emp[i].personcd+"</td><td>"+emp[i].officer_name+"</td><td>"+emp[i].off_desg+"</td><td>"+emp[i].poststat+"</td><td>"+emp[i].mob_no+"</td><td>"+emp[i].remarks+"</td><td><input type='text' class='reason'></td></tr>");
            });

            $('.select-pp').change(function(e){
                e.preventDefault();
                var row=$(this).closest('tr');
                if(row.hasClass('warning')){
                    row.removeClass('warning');
                    selected_pp -= 1;
                    $('#selected_pp').html(selected_pp);
                }
                else{
                    row.addClass('warning');
                    selected_pp += 1;
                    $('#selected_pp').html(selected_pp);
                }
            });
        }
        else{
            $('#table_employee tbody').empty();
        }

        $('#data-loader').hide();
    });

    $('.id_search').click(function(e){
        e.preventDefault();
        $('#data-loader').show();
        $('#emp_search').prop('disabled',true);
        $('#searchPP').prop('disabled',true);
        $.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'post_random_exemption/employee_by_id.php',
		type: 'POST',
                data: {
                        personcd: $('#emp_search').val()
                },
		success: function(data) {
			emp=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});

        if(emp.length > 0){
            $('#total_pp').html(emp.length);
            $('#table_employee tbody').empty();
            $.each(emp, function(i){
                $('#table_employee tbody').append("<tr><td><input type='checkbox' class='select-pp'></td><td class='personcd'>"+emp[i].personcd+"</td><td>"+emp[i].officer_name+"</td><td>"+emp[i].off_desg+"</td><td>"+emp[i].poststat+"</td><td>"+emp[i].mob_no+"</td><td>"+emp[i].remarks+"</td><td><input type='text' class='reason'></td></tr>");
            });

            $('.select-pp').change(function(e){
                e.preventDefault();
                var row=$(this).closest('tr');
                if(row.hasClass('warning')){
                    row.removeClass('warning');
                    selected_pp -= 1;
                    $('#selected_pp').html(selected_pp);
                }
                else{
                    row.addClass('warning');
                    selected_pp += 1;
                    $('#selected_pp').html(selected_pp);
                }
            });
        }
        else{
            $('#table_employee tbody').empty();
        }

        $('#data-loader').hide();
    });

    $('.name_search').click(function(e){
        e.preventDefault();
        $('#data-loader').show();
        $('#emp_search').prop('disabled',true);
        $('#searchPP').prop('disabled',true);
        $.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'post_random_exemption/employee_by_name.php',
		type: 'POST',
                data: {
                        officer_name: $('#emp_search').val()
                },
		success: function(data) {
			emp=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});

        if(emp.length > 0){
            $('#total_pp').html(emp.length);
            $('#table_employee tbody').empty();
            $.each(emp, function(i){
                $('#table_employee tbody').append("<tr><td><input type='checkbox' class='select-pp'></td><td class='personcd'>"+emp[i].personcd+"</td><td>"+emp[i].officer_name+"</td><td>"+emp[i].off_desg+"</td><td>"+emp[i].poststat+"</td><td>"+emp[i].mob_no+"</td><td>"+emp[i].remarks+"</td><td><input type='text' class='reason'></td></tr>");
            });

            $('.select-pp').change(function(e){
                e.preventDefault();
                var row=$(this).closest('tr');
                if(row.hasClass('warning')){
                    row.removeClass('warning');
                    selected_pp -= 1;
                    $('#selected_pp').html(selected_pp);
                }
                else{
                    row.addClass('warning');
                    selected_pp += 1;
                    $('#selected_pp').html(selected_pp);
                }
            });
        }
        else{
            $('#table_employee tbody').empty();
        }

        $('#data-loader').hide();
    });

    $('#resetPP').click(function(e){
        e.preventDefault();
        $('#table_employee tbody').empty();
        $('#selected_pp').html('0');
        $('#total_pp').html('0');
        $('#office').prop('disabled',false);
        $('#loadPP').prop('disabled',false);
        $('#emp_search').prop('disabled',false);
        $('#searchPP').prop('disabled',false);
    });

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
            $('#selected_pp').html(emp.length);
        }
        else{
            $("#table_employee tbody tr").removeClass('warning');
            $('#table_employee tbody .select-pp').prop('checked',false);
            $('#selected_pp').html('0');
        }
    });

    $('#exemptPP').click(function(e){
        e.preventDefault();
        $('#data-loader').show();
        var emp_exempt_count=0;
        var rows=$('#table_employee tbody tr');
        var total_pp=rows.length;
        $.each(rows,function(index){
            if($(this).hasClass('warning')){
                var emp_code=$(this).find('.personcd').html().toString();
                var reason=$(this).find('.reason').val();
                var result;
                if(reason.length > 0){
                    $.ajax({
                            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                            url: 'post_random_exemption/mark_exempt_employee.php',
                            type: 'POST',
                            data: {
                                    personcd: emp_code,
                                    reason: reason
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
                        emp_exempt_count += 1;
                        total_pp -= 1;
                        $(this).hide();
                        $('#total_pp').html(total_pp);
                    }
                    else{
                        alert(result.Status);
                    }
                }
                /*else{
                    $(this).removeClass('warning');
                    $(this).find('.select-pp').prop('checked',false);
                    selected_pp -= 1;
                    $('#selected_pp').html(selected_pp);
                }*/
                if(emp_exempt_count != selected_pp){
                    $('.body-text').html("ERROR - Some Personnel Cannot be Marked for Exemption");
                    $('.modal-header').addClass('bg-red');
                    $('#message-modal').modal('show');
                }
                else{
                    $('.body-text').html("All Selected Personnel Successfully Marked for Exemption");
                    $('.modal-header').addClass('bg-green');
                    $('#message-modal').modal('show');
                }
            }
        });
        $(rows).removeClass('warning');
        $(rows).find('.select-pp').prop('checked',false);
        selected_pp = 0;
        $('#selected_pp').html(selected_pp);
        $('#data-loader').hide();
    });
</script>
