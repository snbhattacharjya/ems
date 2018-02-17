<?PHP
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
?>
<div align="center" class="margin">
    <div class="info-box bg-teal-gradient" style="width: 50%">
        <span class="info-box-icon" style="vertical-align: central"><img src="data_transfer/rotating_globe1.gif" alt=""></span>
      <div class="info-box-content">
        <span class="info-box-text text-bold">Total Records</span>
        <span class="info-box-number text-bold">Loading...</span>
        <div class="progress">
          <div class="progress-bar" style="width: 0%"></div>
        </div>
        <span class="progress-description">
          0%
        </span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
</div>
<script>
    var records;
    $(function(){
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "data_transfer/ems_web_data_export.php",
            
            success: function(data) {;
                records=JSON.parse(JSON.stringify(data));
                $('.info-box-number').html(records.length);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            },
            dataType: "json",
            async: false
	});
    });
    
    $(function(){
        var percent_complete=0;
        var result;
        var update_success=0;
        $.each(records,function(i){
            var query_string="";
            query_string+="UPDATE personnel SET booked='', forassembly='', training1_sch='', training2_sch='', groupid="+records[i].groupid+" WHERE personcd='"+records[i].personcd+"'";
            $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "http://hooghlyonline.in/ems/data_transfer/update_ems_pp_ppds.php",
                type: "POST",
                data: {
                    personcd: records[i].personcd,
                    booked: records[i].booked,
                    forassembly: records[i].forassembly,
                    training1_sch: records[i].training1_sch,
                    training2_sch: records[i].training2_sch
                },
                success: function(data) {;
                    result=JSON.parse(JSON.stringify(data));
                    if(result.Status == 'Success'){
                        update_success += 1;
                    }
                    percent_complete=Math.floor(i/records.length*100);
                    $('.progress-bar').width(percent_complete);
                    $('.progress-description').html((i+1)+" of "+records.length);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "json",
                async: false
            });
        });
    });
</script>
