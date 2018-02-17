<table id="table_report" class="table table-bordered table-condensed small">
    <thead>
        <tr class="info">
            <th>
                <select id="subdiv" class="select2" style="width: 100%"></select>
            </th>
            <th>
                <select id="training_date" class="select2" style="width: 100%"></select>
            </th>
            <th class="text-center">
                <button class="btn btn-success" id="loadReport"><i class="fa fa-search"></i> Load Report</button> 
                <img src="img/ajax_loader_green_128.gif"  class="pull-right" height="25" width="25" style="display: none" id="data-loader">
            </th>
            <th class="text-center">
                <a href="#" class="btn btn-danger" id="print_summary">
                    <i class="fa fa-print"></i> Print Summary
                </a>
            </th>
            <th class="text-center">
                <button class="btn btn-warning" id="reset_btn"><i class="fa fa-refresh"></i> Reset</button>
            </th>
        </tr>
        
        <tr class="bg-blue-active">
            <th>#</th>
            <th>Assembly Code</th>
            <th>Assembly Name</th>
            <th>Personnel Count</th>
            <th>Print List</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>

    </tfoot>
  </table> 
<script>
    $(function(){
        $('.select2').select2();
        loadSubdivision();
    
        $('#subdiv').change(function(e){
            e.preventDefault();
            $('#training_date').empty();
            $('#training_date').select2({placeholder: "Loading Training Date..."});
            var subdiv=$('#subdiv').val();
            $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "postal_ballot/training_date_subdiv.php",
                type: "POST",
                data: {
                    subdiv: subdiv
                },
                success: function(data) {
                    $('#training_date').empty();
                    var result=JSON.parse(JSON.stringify(data));
                    $('#training_date').append("<option value=''>Select Training Date</option>");
                    $.each(result,function(i){
                        $('#training_date').append("<option value='"+result[i].TrainingDate+"'>"+result[i].DateFormat+"</option>");
                    });
                    $('#training_date').select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "json",
                async: false
            });
        });
        
        $('#loadReport').click(function(e){
            e.preventDefault();
            var report;
            $('#data-loader').show();
            $('#subdiv').prop('disabled',true);
            $('#training_date').prop('disabled',true);
            $('#loadReport').prop('disabled',true);
            $.ajax({
                    mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                    url: 'postal_ballot/assembly_pp_summary_report.php',
                    type: 'POST',
                    data: {
                        subdiv: $('#subdiv').val(),
                        training_date: $('#training_date').val()
                    },
                    success: function(data) {
                        report=JSON.parse(JSON.stringify(data));
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                            alert(errorThrown);
                    },
                    dataType: "json",
                    async: false
            });

            if(report.length > 0){
                $('#table_report tbody').empty();
                $('#table_report tfoot').empty();
                $('#print_summary').attr('href',"postal_ballot/assembly_pp_summary_print.php?subdiv="+$('#subdiv').val()+"&training_date="+$('#training_date').val());
                $('#print_summary').attr('target','_blank');
                var total_pp_count=0;
                $.each(report, function(i){
                    $('#table_report tbody').append("<tr><td>"+(i+1)+"</td><td class='assemblycd'>"+report[i].AssemblyCode+"</td><td>"+report[i].AssemblyName+"</td><td>"+report[i].PPCount+"</td><td class='text-center'><a href='postal_ballot/assembly_pp_list_print.php?subdiv="+$('#subdiv').val()+"&training_date="+$('#training_date').val()+"&assembly_temp="+report[i].AssemblyCode+"' class='btn btn-default text-red' target='_blank'><i class='fa fa-print'></i></td></tr>");
                    total_pp_count+=parseInt(report[i].PPCount);
                });
                $('#table_report tfoot').append("<tr class='danger'><th colspan='3' class='text-center'>Total</th><th class='text-center'>"+total_pp_count+"</th><th>&nbsp;</th></tr>");
            }
            else{
                $('#table_report tbody').empty();
                $('#table_report tfoot').empty();
                $('#print_summary').removeAttr('target').attr('href','#');
            }
            
            $('#data-loader').hide();
        });
        
        $('#reset_btn').click(function(e){
            $('#subdiv').prop('disabled',false);
            $('#training_date').prop('disabled',false);
            $('#loadReport').prop('disabled',false);
            $('#table_report tbody').empty();
            $('#table_report tfoot').empty();
            $('#print_summary').removeAttr('target').attr('href','#');
        });
    });
    
    function loadSubdivision(){
        $('#subdiv').select2({placeholder: "Loading Subdivision..."});
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "json/subdivision_details.php",
                success: function(data) {
                    $('#subdiv').empty();
                    var result=JSON.parse(JSON.stringify(data));
                    $('#subdiv').append("<option value=''>Select Subdivision</option>");
                    $.each(result,function(i){
                        if(result[i].SubdivisionCode != '9999'){
                            $('#subdiv').append("<option value='"+result[i].SubdivisionCode+"'>"+result[i].Subdivision+"</option>");
                        }
                    });
                    $('#subdiv').select2();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "json",
                async: false
            });
    }
</script>

