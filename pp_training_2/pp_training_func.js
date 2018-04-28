/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function loadSubdivPPBookedSummary(){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    //var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/pp_training_subdiv_summary.php",
            //type: "POST",
            //data: {
                //target_url: data_target
            //},
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
}

function loadBlockMuniBookedSummary(subdiv){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/pp_training_blockmuni_summary.php",
            type: "POST",
            data: {
                subdiv: subdiv
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
   function loadOfficePPBookedSummary(subdiv, blockmuni){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/pp_training_office_summary.php",
            type: "POST",
            data: {
                subdiv: subdiv,
                blockmuni: blockmuni
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadPPOfficeReport(officecd, blockmuni){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/pp_booked_by_office.php",
            type: "POST",
            data: {
                officecd: officecd,
                blockmuni: blockmuni
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function populate_first_rand_table(){
        $('.ajax-result').empty();
        $('.ajax-loader').show();
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/first_rand_table_populate.php",
            success: function(data) {
                $('.ajax-loader').hide();
                var result=JSON.parse(JSON.stringify(data));
                if(result.Status == 'Success'){
                    $('.ajax-result').html("<div class='text-center'><i class='fa fa-thumbs-up fa-2x text-green'></i><p>Records Affected: "+result.RecordCount+"</p>");
                }
                else{
                    $('.ajax-result').html("<div class='text-center'><i class='fa fa-thumbs-down fa-2x text-red'></i><p>Reason: "+result.Status+"</p>");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
	});
    }
    
    function loadSubdivForm12Summary(){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    //var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/pp_form12_subdiv_summary.php",
            //type: "POST",
            //data: {
                //target_url: data_target
            //},
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
}

function loadBlockMuniForm12Summary(subdiv){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/pp_form12_blockmuni_summary.php",
            type: "POST",
            data: {
                subdiv: subdiv
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
   function loadOfficeForm12Summary(subdiv, blockmuni){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/pp_form12_office_summary.php",
            type: "POST",
            data: {
                subdiv: subdiv,
                blockmuni: blockmuni
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
    
    function loadForm12OfficeReport(officecd, blockmuni){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/pp_form12_by_office.php",
            type: "POST",
            data: {
                officecd: officecd,
                blockmuni: blockmuni
            },
            success: function(data) {
                $('.ajax-loader').hide();
                $('.ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }