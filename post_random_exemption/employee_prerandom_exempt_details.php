<?php
session_start();
$user_id=$_SESSION['UserID'];
$block_code=substr($user_id,3,6);
if(isset($_SESSION['Subdiv']))
{
    $subdiv=$_SESSION['Subdiv'];
}
require("../config/config.php");


$employee_exempt_query="SELECT office.officecd, office.office, personnel_exempt.personcd, personnel_exempt.officer_name, personnel_exempt.off_desg, personnel_exempt.mob_no, remarks.remarks, personnel_exempt_marked.reason FROM ((office INNER JOIN personnel_exempt ON office.officecd = personnel_exempt.officecd) INNER JOIN remarks ON personnel_exempt.remarks = remarks.remarks_cd) INNER JOIN personnel_exempt_marked ON personnel_exempt.personcd = personnel_exempt_marked.personcd ORDER BY office.officecd, personnel_exempt.officer_name";

$employee_exempt_result=mysqli_query($DBLink,$employee_exempt_query) or die(mysqli_error($DBLink));
$return=array();
while($row=mysqli_fetch_assoc($employee_exempt_result))
{
	$return[]=$row;
}
?>
<div class="text-center margin-bottom">
    <a class="btn btn-md btn-flat btn-default text-red" href="post_random_exemption/employee_prerandom_exempt_details_print.php" target="_blank"><i class="fa fa-print"></i> Print</a>
</div>
<div class="table-responsive">
    <table id="employee_exempt_details" class="table table-bordered table-condensed small">
        <thead>
            <tr class="bg-gray">
                <th colspan="9">
                    <input type="text" class="input-sm pull-right" placeholder="Search Employee" id="search-text">
                </th>
            </tr>
            <tr class="bg-light-blue-gradient">
                <th>#</th>
                <th>Office ID</th>
                <th>Office Name</th>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Designation</th>
                <th>Mobile</th>
                <th>Remarks</th>
                <th>Reason for Exemption</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for($i=0; $i<count($return);$i++){
            ?>
            <tr>
                <td><?php echo ($i+1); ?></td>
                <td><?php echo $return[$i]['officecd']; ?></td>
                <td><?php echo $return[$i]['office']; ?></td>
                <td class="personcd"><?php echo $return[$i]['personcd']; ?></td>
                <td><?php echo $return[$i]['officer_name']; ?></td>
                <td><?php echo $return[$i]['off_desg']; ?></td>
                <td><?php echo $return[$i]['mob_no']; ?></td>
                <td><?php echo $return[$i]['remarks']; ?></td>
                <td><?php echo $return[$i]['reason']; ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>

        </tfoot>
    </table>
</div>
<script>
    $(function(){
        $("#search-text").keyup(function(){
            if (this.value.length < 1) {
                $("#employee_exempt_details tbody tr").css("display", "");
            }
            else {
                $("#employee_exempt_details tbody tr:not(:contains('"+$(this).val().toUpperCase()+"'))").css("display", "none");
                $("#employee_exempt_details tbody tr:contains('"+$(this).val().toUpperCase()+"')").css("display", "");
            }

        });

        $('.remove-exempt-pp').click(function(e){
            e.preventDefault();
            var row=$(this).closest('tr');
            var result;
            var personcd = $(row).find('.personcd').html().toString();
            $(this).html("<i class='fa fa-spinner fa-spin text-orange'></i>");
            $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: 'post_random_exemption/employee_exempt_remove.php',
                type: "POST",
                data: {
                    personcd: personcd
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
                $(row).hide();
            }
            else{
                $(this).html("<i class='fa fa-minus-circle text-red'></i>");
            }
        });
    });
</script>
