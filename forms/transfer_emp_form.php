<?php
session_start();
include("../config/config.php");
?>   
<div class="box box-solid">
    <div class="box-header with-border bg-light-blue-gradient">
        <h3 class="box-title text-bold">
            Transter Employee Form
        </h3>              
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row"> 
            <div class="col-md-6">
                <form role="form">
                    <div class="form-group">
                        <label class="control-label">Source Office:</label>
                        <select class="select2 form-control" id="s_oid"></select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Employee:</label>
                        <select class="select2 form-control" id="pid" multiple="multiple"></select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Destination Office:</label>
                        <select class="select2 form-control" id="d_oid"></select>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-md btn-success pull-right" id="transfer_in_subdiv"><span><i class="fa fa-exchange fa-lg"></i></span> Transfer Within Subdivision</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <form role="form">
                    <div class="form-group">
                        <label class="control-label">Source Office:</label>
                        <select class="select2 form-control" id="s_oid2"></select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Employee:</label>
                        <select class="select2 form-control" id="pid2" multiple="multiple"></select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Destination Subdivision:</label>
                        <select class="select2 form-control" id="d_subdiv"></select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Destination Office:</label>
                        <select class="select2 form-control" id="d_oid2"></select>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-md btn-danger pull-right" id="transfer_out_subdiv"><span><i class="fa fa-exchange fa-lg"></i></span> Transfer Outside Subdivision</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- /.box-body -->

<script>
$(document).ready(function(e) {
    $('.select2').select2();
    loadOffice();
    loadOtherSubdivision();
});

$(function(){
    $('#s_oid').change(function(e) {
        e.preventDefault();	
        var emp;
        $('#pid').select2({placeholder: 'Loading Employee...'});

        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/employee_by_office2.php',
            type: 'POST',
            data: {
                    Office: $('#s_oid').val()
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
            $('#pid').empty();
            $.each(emp,function(i){
                    $('#pid').append( "<option value='"+emp[i].PersonCode+"'>"+ emp[i].PersonCode + ' - ' +emp[i].OfficerName + "</option>");
            });
            $('#pid').select2({placeholder: 'Select Employee'});
        }	
        else{
            $('#pid').empty();
            $('#pid').select2({placeholder: 'No Employee Found'});
        }
    });
    
    $('#s_oid2').change(function(e) {
        e.preventDefault();	
        var emp;
        $('#pid2').select2({placeholder: 'Loading Employee...'});
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/employee_by_office2.php',
            type: 'POST',
            data: {
                    Office: $('#s_oid2').val()
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
            $('#pid2').empty();
            $.each(emp,function(i){
                    $('#pid2').append( "<option value='"+emp[i].PersonCode+"'>"+ emp[i].PersonCode + ' - ' +emp[i].OfficerName + "</option>");
            });
            $('#pid2').select2({placeholder: 'Select Employee'});
        }	
        else{
            $('#pid2').empty();
            $('#pid2').select2({placeholder: 'No Employee Found'});
        }
    });
    
    $('#d_subdiv').change(function(e){
        e.preventDefault();
        var subdiv=$(this).val();
        var office;
        $('#d_oid2').select2({placeholder: 'Loading Other Destination Office...'});
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'json/office_by_subdiv2.php',
            type: "POST",
            data: {
                subdiv: subdiv
            },
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
            $('#d_oid2').empty();
            $('#d_oid2').append("<option value=''>Select New Office</option>");
            $.each(office,function(i){
                $('#d_oid2').append( "<option value='"+office[i].OfficeCode+"'>"+ office[i].OfficeCode + ' - ' +office[i].OfficeName + "</option>");
            });
            $('#d_oid2').select2();
        }
        else{
            $('#d_oid2').empty();
        }	
    });
    
    $('#transfer_in_subdiv').click(function(e){
        e.preventDefault();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'php/trans_emp.php',
            type: 'POST',
            data: {
                    SourceOffice: $('#s_oid').val(),
                    Person: $('#pid').val(),
                    NewOffice: $('#d_oid').val()
            },
            success: function(data) {
                var retObj=JSON.parse(JSON.stringify(data));
                alert(retObj.Status);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
        });
    });
    
    $('#transfer_out_subdiv').click(function(e){
        e.preventDefault();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: 'php/trans_emp_out_subdiv.php',
            type: 'POST',
            data: {
                    SourceOffice: $('#s_oid2').val(),
                    Person: $('#pid2').val(),
                    NewSubdiv: $('#d_subdiv').val(),
                    NewOffice: $('#d_oid2').val()
            },
            success: function(data) {
                var retObj=JSON.parse(JSON.stringify(data));
                alert(retObj.Status);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
        });
    });
});

function loadOffice()
{
    var office;
    $('#s_oid').select2({placeholder: 'Loading Source Office...'});
    $('#s_oid2').select2({placeholder: 'Loading Source Office...'});
    $('#d_oid').select2({placeholder: 'Loading New Office...'});
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
        $('#s_oid').empty();
        $('#s_oid2').empty();
        $('#d_oid').empty();
        $('#s_oid').append("<option value=''>Select Source Office</option>");
        $('#s_oid2').append("<option value=''>Select Source Office</option>");
        $('#d_oid').append("<option value=''>Select New Office</option>");
        $.each(office,function(i){
                $('#s_oid').append( "<option value='"+office[i].OfficeCode+"'>"+ office[i].OfficeCode + ' - ' +office[i].OfficeName + "</option>");
                $('#s_oid2').append( "<option value='"+office[i].OfficeCode+"'>"+ office[i].OfficeCode + ' - ' +office[i].OfficeName + "</option>");
                $('#d_oid').append( "<option value='"+office[i].OfficeCode+"'>"+ office[i].OfficeCode + ' - ' +office[i].OfficeName + "</option>");
        });
        $('#s_oid').select2();
        $('#s_oid2').select2();
        $('#d_oid').select2();
    }
    else{
        $('#s_oid').empty();
        $('#s_oid2').empty();
        $('#d_oid').empty();
    }	
}

function loadOtherSubdivision()
{
    var other_subdiv;
    $('#d_subdiv').select2({placeholder: 'Loading Other Subdivision...'});
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: 'json/other_subdivision.php',
        success: function(data) {
            other_subdiv=JSON.parse(JSON.stringify(data));
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "json",
        async: false
    });
    if(other_subdiv.length > 0){
        $('#d_subdiv').empty();
        $('#d_subdiv').append("<option value=''>Select Other Subdivision</option>");
        $.each(other_subdiv,function(i){
            $('#d_subdiv').append( "<option value='"+other_subdiv[i].SubdivCode+"'>"+other_subdiv[i].SubdivName + "</option>");
        });
        $('#d_subdiv').select2();
    }
    else{
        $('#d_subdiv').empty();
    }	
}  
</script>