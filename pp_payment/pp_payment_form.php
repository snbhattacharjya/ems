<?PHP
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
$user_id=$_SESSION['UserID'];
require("../config/config.php");
?>
<div class="box box-solid">
    <div class="box-header bg-teal">
        <h3 class="box-title">
            Personnel Polling Allowance Payment
        </h3> 
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                            </div>
        </div><!-- /.box-header -->
        <div class="box-body">          
            <form role="form" id="pp_payment_form">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                Presiding Officer (Party):
                            </label>
                            <input type="text" class="form-control check-total check-required" id="pr_party">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                Presiding Officer (Reserve):
                            </label>
                           <input type="text" class="form-control check-total check-required" id="pr_reserve">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                1st Polling Officer (Party):
                            </label>
                            <input type="text" class="form-control check-total check-required" id="p1_party">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                1st Polling Officer (Reserve):
                            </label>
                           <input type="text" class="form-control check-total check-required" id="p1_reserve">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                               2nd Polling Officer (Party):
                            </label>
                            <input type="text" class="form-control check-total check-required" id="p2_party">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                2nd Polling Officer (Reserve):
                            </label>
                           <input type="text" class="form-control check-total check-required" id="p2_reserve">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                               3rd Polling Officer (Party):
                            </label>
                            <input type="text" class="form-control check-total check-required" id="p3_party">
                        </div>
                        <div class="form-group">
                            <label class="control-label">
                                3rd Polling Officer (Reserve):
                            </label>
                           <input type="text" class="form-control check-total check-required" id="p3_reserve">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="form-group">
                            <button type="button" class="btn btn-flat btn-success" id="generate_payment_btn">
                                Generate Payment Schedule
                            </button>
                        </div>
                </div>
                </div>
            </form>
            <div class="row text-center ajax-loader" style="display: none">
                <div class="col-md-12">
                    <img src="data_transfer/loading_image.gif" height="150" width="150">
                    <p id="load-message">
                        Loading Web Data...Please wait
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ajax-result">
                    
                </div>
            </div>
        </div><!-- /.box-body -->
</div><!-- /.box -->
<script>
$('#generate_payment_btn').click(function(e){
        e.preventDefault();
        $('.ajax-result').empty();
        
        if(validateForm('pp_payment_form')){
            var pr_party=$('#pr_party').val();
            var pr_reserve=$('#pr_reserve').val();
            var p1_party=$('#p1_party').val();
            var p1_reserve=$('#p1_reserve').val();
            var p2_party=$('#p2_party').val();
            var p2_reserve=$('#p2_reserve').val();
            var p3_party=$('#p3_party').val();
            var p3_reserve=$('#p3_reserve').val();
            $('.ajax-loader').show();
            $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "pp_payment/populate_pp_payment_table.php",
                type: "POST",
                data: {
                    pr_party: pr_party,
                    pr_reserve: pr_reserve,
                    p1_party: p1_party,
                    p1_reserve: p1_reserve,
                    p2_party: p2_party,
                    p2_reserve: p2_reserve,
                    p3_party: p3_party,
                    p3_reserve: p3_reserve
                },
                success: function(data) {
                    $('.ajax-loader').hide();
                    var result=JSON.parse(JSON.stringify(data));
                    if(result.Status == 'Success'){
                        $('.ajax-result').html("<p class='text-center text-bold text-green'>Records Added: "+result.RecordCount+"</p>");
                    }
                    else{
                        $('.ajax-result').html("<p class='text-center text-bold text-red'>Data Error: "+result.Status+"</p>");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                dataType: "json",
                async: false
            });
        }
        else{
            $('.ajax-result').html("<p class='text-center text-bold text-red'>Data Error</p>");
        }
    });
</script>
