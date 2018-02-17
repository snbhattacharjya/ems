<div class="box box-solid">
    <div class="box-header bg-teal-active">
        <h3 class="box-title text-bold">Police Personnel PP2 Reports</h3> 
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row text-center ajax-loader" style="display: none">
            <img src="police_report/loading_image.gif" height="150" width="150">
            <p id="load-message">
                Loading Web Data...Please wait
            </p>
        </div>
        
        <div class="row">
            <div class="col-md-12 table-responsive" id="ajax-result">
                
            </div>
        </div>

    </div><!-- /.box-body -->
</div><!-- /.box -->
<script>
    $(function(){
        loadSubdivPP2Summary();
    });
    
    function loadSubdivPP2Summary(){
    $('#ajax-result').empty();
    $('.ajax-loader').show();
    $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "police_report/subdiv_pp2_summary.php",
            success: function(data) {
                $('.ajax-loader').hide();
                $('#ajax-result').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "html",
            async: false
	});
    }
</script>

