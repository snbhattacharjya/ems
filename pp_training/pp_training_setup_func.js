/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var modify_lock=0;

function loadPPTrainingVenue(){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    //var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/pp_training_venue.php",
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

function loadAssemblySubdivUser(){
    var result;
    $('#venue_assembly').select2({placeholder: "Loading Assembly..."});
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: "pp_training/assembly_subdiv_user.php",
        success: function(data) {
            result=JSON.parse(JSON.stringify(data));
            $('#venue_assembly').empty();
            $.each(result,function(i){
                $('#venue_assembly').append("<option value'"+result[i].AssemblyCode+"'>"+result[i].AssemblyCode+' - '+result[i].AssemblyName+"</option>");
            });
            $('#venue_assembly').select2();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "json",
        async: false
    });
}

function loadVenueBaseName(){
    var result;
    $('#venue_base_name').select2({placeholder: "Loading Venues..."});
    $('#venue_base_name_search').select2({placeholder: "Loading Venues..."});
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: "pp_training/venue_distinct_subdiv.php",
        success: function(data) {
            result=JSON.parse(JSON.stringify(data));
            $('#venue_base_name').empty();
            $('#venue_base_name_search').empty();
            $.each(result,function(i){
                $('#venue_base_name').append("<option value'"+result[i].VenueBaseName+"'>"+result[i].VenueBaseName+"</option>");
                $('#venue_base_name_search').append("<option value'"+result[i].VenueBaseName+"'>"+result[i].VenueBaseName+"</option>");
            });
            $('#venue_base_name').select2();
            $('#venue_base_name_search').select2();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "json",
        async: false
    });
}

function addTrainingVenue(){
    var result;
    var venue_assembly=$('#venue_assembly').val();
    var venue_name=$('#venue_name').val();
    var address1=$('#address1').val();
    var address2=$('#address2').val();
    var rooms=$('#rooms').val();
    var capacity=$('#capacity').val();
    $('.venue-add-error, .venue-add-success').hide();
    $('.venue-add-progress').show();
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: "pp_training/training_venue_add.php",
        type: "POST",
        data: {
            venue_assembly: venue_assembly,
            venue_name: venue_name,
            address1: address1,
            address2: address2,
            rooms: rooms,
            capacity: capacity
        },
        success: function(data) {
            $('.venue-add-progress').hide();
            result=JSON.parse(JSON.stringify(data));
            if(result.Status == 'Success'){
                $('.venue-add-success').show();
                $('#venue_base_name').append("<option value'"+venue_name+"'>"+venue_name+"</option>");
                $('#venue_base_name').select2();
            }
            else{
                $('.venue-add-error').show();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "json",
        async: false
    });
}

function loadVenueRooms(){
    var result;
    $('#data-loader').show();
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: "pp_training/venue_rooms.php",
        type: "POST",
        data: {
            venue_base_name: $('#venue_base_name').val()
        },
        success: function(data) {
            result=JSON.parse(JSON.stringify(data));
            $('#venue_room_table tbody').empty();
            $('#venue_room_table tfoot').find('.total_capacity').html('0');
            var total_capacity=0;
            $.each(result,function(i){
                $('#venue_room_table tbody').append("<tr><td>"+(i+1)+"</td><td class='venue_cd'>"+result[i].VenueID+"</td><td>"+result[i].VenueName+"</td><td class='venue_capacity'>"+result[i].VenueCapacity+"</td><td class='edit'><a href='#' class='modify text-aqua'><i class='fa fa-edit'></i></a></td></tr>");
                total_capacity += parseInt(result[i].VenueCapacity);
            });
            $('#venue_room_table tfoot').find('.total_capacity').html(total_capacity);
            $('#data-loader').hide();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "json",
        async: false
    });

    $('#venue_room_table tbody').on('click','.modify', function(e){
        e.preventDefault();
        if(modify_lock == 0){
            modify_lock=1;
            var row=$(this).closest('tr').addClass('warning');
            var cell=$(this).closest('td');
            var venue_cd=$(row).find('.venue_cd').html().toString();
            var venue_capacity=$(row).find('.venue_capacity').html().toString();
            $(row).find('.venue_capacity').html("<input type='text' value='"+venue_capacity+"' class='venue_capacity_input'>");
            $(cell).html("<a href='#' class='save btn btn-sm text-green'><i class='fa fa-save'></i></a> <a href='#' class='cancel btn btn-sm text-red'><i class='fa fa-close'></i></a>");

            $('.save').click(function(e){
                e.preventDefault();
                var venue_capacity_input=$(row).find('.venue_capacity_input').val();
                $(cell).html("<i class='fa fa-spinner fa-spin text-orange'></i>");
                $.ajax({
                    mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                    url: "pp_training/venue_capacity_update.php",
                    type: "POST",
                    data: {
                        venue_cd: venue_cd,
                        venue_capacity: venue_capacity_input
                    },
                    success: function(data) {
                        var result=JSON.parse(JSON.stringify(data));
                        if(result.Status == 'Success'){
                            $(row).removeClass('warning').removeClass('danger').addClass('success');
                            $(row).find('.venue_capacity').html(venue_capacity_input);
                        }
                        else{
                            $(row).removeClass('warning').addClass('danger');
                            $(row).find('.venue_capacity').html(venue_capacity);
                        }
                        $(cell).html("<a href='#' class='modify text-aqua'><i class='fa fa-edit'></i></a>");
                        var total_capacity=$('#venue_room_table tfoot').find('.total_capacity').html().toString();
                        $('#venue_room_table tfoot').find('.total_capacity').html(parseInt(total_capacity) + (venue_capacity_input - venue_capacity));
                        modify_lock=0;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    },
                    dataType: "json",
                    async: false
                });
            });
            $('.cancel').click(function(e){
                e.preventDefault();
                $(row).removeClass('warning').removeClass('danger');
                $(row).find('.venue_capacity').html(venue_capacity);
                $(cell).html("<a href='#' class='modify text-aqua'><i class='fa fa-edit'></i></a>");
                modify_lock=0;
            });
        }
    });
}

function loadPPTrainingSchedule(){
    $('.ajax-result').empty();
    $('.ajax-loader').show();
    //var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/pp_training_schedule.php",
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

function createTrainingSchedule(){
    $('.schedule-table-content').empty();
    $('.schedule-create-progress').show();
    //var data_target=$(this).attr('data-target').valueOf().toString();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "pp_training/create_training_schedule.php",
            type: "POST",
            data: {
                venue_base_name: $('#venue_base_name').val(),
                training_date: $('#training_date').val(),
                training_time: $('#training_time').val()
            },
            success: function(data) {
                $('.schedule-create-progress').hide();
                $('.schedule-table-content').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
}

function loadScheduleTable(){
    var result;
    $('#data-loader').show();
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: "pp_training/venue_rooms.php",
        type: "POST",
        data: {
            venue_base_name: $('#venue_base_name').val(),
        },
        success: function(data) {
            result=JSON.parse(JSON.stringify(data));
            $('#schedule_table tbody').empty();
            //$('#venue_room_table tfoot').find('.total_capacity').html('0');
            //var total_capacity=0;
            $.each(result,function(i){
                $('#schedule_table tbody').append("<tr><td>"+(i+1)+"</td><td class='venue_cd'>"+result[i].VenueID+"</td><td class='venue_name'>"+result[i].VenueName+"</td><td class='venue_capacity'>"+result[i].VenueCapacity+"</td><td><input type='text' class='pr_input' maxlength='3' size='3' value='0'></td><td><input type='text' class='p1_input' maxlength='3' size='3' value='0'></td><td><input type='text' class='p2_input' maxlength='3' size='3' value='0'></td><td><input type='text' class='p3_input' maxlength='3' size='3' value='0'></td><td><input type='text' class='p4_input' maxlength='3' size='3' value='0'></td></tr>");
                //total_capacity += parseInt(result[i].VenueCapacity);
            });
            //$('#venue_room_table tfoot').find('.total_capacity').html(total_capacity);
            $('#data-loader').hide();
            $('#venue_base_name, #training_date, #training_time').attr('disabled',true);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "json",
        async: false
    });
}

function saveTrainingSchedule(){
    var analyze_table=true;
    var rows=$('#schedule_table  tbody').find('tr');
    $.each(rows,function(){
        var row=$(this);
        var venue_capacity=parseInt($(row).find('.venue_capacity').html().toString());
        var pr_count=parseInt($(row).find('.pr_input').val());
        var p1_count=parseInt($(row).find('.p1_input').val());
        var p2_count=parseInt($(row).find('.p2_input').val());
        var p3_count=parseInt($(row).find('.p3_input').val());
        var p4_count=parseInt($(row).find('.p4_input').val());

        if(venue_capacity < (pr_count + p1_count + p2_count + p3_count + p4_count)){
            $(row).removeClass('success').addClass('warning');
            analyze_table=false;
        }
        else{
            $(row).removeClass('warning').addClass('success');
        }
    });
    if(analyze_table == true){
       $.each(rows,function(){
            var row=$(this);
            $(row).find('.venue_name').append("<span class='pull-right text-yellow'><i class='fa fa-spinner fa-spin'></i></span>");
            var venue_cd=$(row).find('.venue_cd').html().toString();
            var pr_count=parseInt($(row).find('.pr_input').val());
            var p1_count=parseInt($(row).find('.p1_input').val());
            var p2_count=parseInt($(row).find('.p2_input').val());
            var p3_count=parseInt($(row).find('.p3_input').val());
            var p4_count=parseInt($(row).find('.p4_input').val());

            $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "pp_training/save_training_schedule.php",
                type: "POST",
                data: {
                    venue_cd: venue_cd,
                    pr_count: pr_count,
                    p1_count: p1_count,
                    p2_count: p2_count,
                    p3_count: p3_count,
                    p4_count: p4_count,
                    training_date: $('#training_date').val(),
                    training_time: $('#training_time').val(),
                },
                success: function(data) {
                    var result=JSON.parse(JSON.stringify(data));
                    if(result.Status == 'Success'){
                        $(row).removeClass('warning').addClass('success');
                    }
                    else{
                        $(row).removeClass('success').addClass('warning');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "json",
                async: false
            });
            $(row).find('.venue_name').find('span').remove();
        });
    }
    $('#venue_base_name, #training_date, #training_time').attr('disabled',false);
}

function viewTrainingSchedule(opt){
    var result;
    var url;
    $('#data-loader').show();
    if(opt == 'Venue'){
        url='pp_training/training_schedule_by_venue.php';
    }
    else{
        url='pp_training/training_schedule_by_date.php';
    }
    $.ajax({
        mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
        url: url,
        type: "POST",
        data: {
            venue_base_name: $('#venue_base_name_search').val(),
            training_date: $('#training_date_search').val()
        },
        success: function(data) {
            result=JSON.parse(JSON.stringify(data));
            $('#view_schedule_table tbody').empty();
            $('#view_schedule_table tfoot').find('.total_occupancy').html('0');
            var total_occupancy=0;
            $.each(result,function(i){
                $('#view_schedule_table tbody').append("<tr><td>"+(i+1)+"</td><td class='venue_cd'>"+result[i].VenueID+"</td><td class='venue_name'>"+result[i].VenueName+"</td><td class='training_date'>"+result[i].TrainingDate+"</td><td class='training_date'>"+result[i].TrainingTime+"</td><td class='training_date'>"+result[i].PostStatus+"</td><td class='training_date'>"+result[i].PPCount+"</td></tr>");
                total_occupancy += parseInt(result[i].PPCount);
            });
            $('#view_schedule_table tfoot').find('.total_occupancy').html(total_occupancy);
            $('#data-loader').hide();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        },
        dataType: "json",
        async: false
    });
}
