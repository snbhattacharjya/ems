<?php
require("../config/config.php");

$blockmuni_query=$mysqli->prepare("SELECT block_muni.blockminicd, block_muni.blockmuni, COUNT(personnel.personcd) FROM (office INNER JOIN personnel ON office.officecd=personnel.officecd) INNER JOIN block_muni ON office.blockormuni_cd=block_muni.blockminicd GROUP BY block_muni.blockminicd, block_muni.blockmuni ORDER BY block_muni.blockminicd, block_muni.blockmuni") or die($mysqli->error);

$blockmuni_query->execute() or die($blockmuni_query->error);
$blockmuni_query->bind_result($block_muni_code,$block_muni_name,$block_muni_total) or die($blockmuni_query->error);
$blockmuni=array();

while($blockmuni_query->fetch()){
	$blockmuni[]=array("BlockMuniCode"=>$block_muni_code, "BlockMuniName"=>$block_muni_name, "BlockMuniTotal"=>$block_muni_total);
}
$blockmuni_query->close();

?>
<table id="blockmuni_personnel_summary" class="table table-bordered table-condensed table-striped small">
    <thead>
        <tr class="bg-black-gradient">
            <th>Block/Municipality Code</th>
            <th>Block/Municipality Name</th>
            <th>Total Records</th>
            <th>Progress</th>
        </tr>
    </thead>
    <tbody>
        <?php
	for($i=0;$i<count($blockmuni);$i++){
        ?>
	<tr>
            <td class="blockormuni_cd"><?php echo $blockmuni[$i]['BlockMuniCode']; ?></td>
            <td><?php echo $blockmuni[$i]['BlockMuniName']; ?></td>
            <td class="total-records text-center">&nbsp;</td>
            <td class="progress text-center">&nbsp;</td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr class="danger">
            <th colspan="4">
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    echo "<i class='fa fa-info-circle'></i> Report Compiled as on: ".date("d-M-Y H:i:s A"); 
                ?>
            </th>
    </tfoot>
</table>
<script>
$(function(){
    var rows=$('#blockmuni_personnel_summary tbody').find('tr');
    $.each(rows,function(){
        var row=$(this);
        $(row).addClass('warning');
        var block_muni_code=$(row).find('.blockormuni_cd').html().toString();
        $(row).find('.total-records').html("<i class='fa fa-spinner fa-spin text-orange'></i>");
        var result;
        $.ajax({
            mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
            url: "http://hooghlyonline.in/ems/data_transfer/personnel_export_blockmuni.php",
            type: "POST",
            data: {
                block_muni_code : block_muni_code
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
        $(row).find('.total-records').html(result.length);
        var add_count=1;
        $.each(result,function(i){
            var add_result;
            $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: "data_transfer/personnel_import_web.php",
                type: "POST",
                data: {
                    personcd: result[i].personcd,
                    officecd: result[i].officecd,
                    officer_name: result[i].officer_name,
                    off_desg: result[i].off_desg,
                    adharno: result[i].adharno,
                    present_addr1: result[i].present_addr1,
                    present_addr2: result[i].present_addr2,
                    perm_addr1: result[i].perm_addr1,
                    perm_addr2: result[i].perm_addr2,
                    dateofbirth: result[i].dateofbirth,
                    gender: result[i].gender,
                    scale: result[i].scale,
                    basic_pay: result[i].basic_pay,
                    grade_pay: result[i].grade_pay,
                    workingstatus: result[i].workingstatus,
                    email: result[i].email,
                    resi_no: result[i].resi_no,
                    mob_no: result[i].mob_no,
                    qualificationcd: result[i].qualificationcd,
                    languagecd: result[i].languagecd,
                    epic: result[i].epic,
                    acno: result[i].acno,
                    slno: result[i].slno,
                    partno: result[i].partno,
                    poststat: result[i].poststat,
                    assembly_temp: result[i].assembly_temp,
                    assembly_off: result[i].assembly_off,
                    assembly_perm: result[i].assembly_perm,
                    districtcd: result[i].districtcd,
                    subdivisioncd: result[i].subdivisioncd,
                    bank_acc_no: result[i].bank_acc_no,
                    bank_cd: result[i].bank_cd,
                    branchname: result[i].branchname,
                    branchcd: result[i].branchcd,
                    remarks: result[i].remarks,
                    pgroup: result[i].pgroup,
                    upload_file: result[i].upload_file,
                    usercode: result[i].usercode,
                    posted_date: result[i].posted_date,
                    f_cd: result[i].f_cd,
                    image: result[i].image,
                    signature: result[i].signature
                },
                success: function(data) {
                    add_result=JSON.parse(JSON.stringify(data));
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error: "+errorThrown+", ID: "+result[i].personcd);
                },
                dataType: "json",
                async: false
            });
            if(add_result.Status  == 'Success'){
                $(row).find('.progress').html("<span class='text-bold text-center'>"+add_count+"</span>");
                add_count+=1;
            }
        });
        $(row).removeClass('warning').addClass('success');
        if((add_count - 1) == result.length)
            $(row).find('.progress').append(" <i class='fa fa-check-square text-blue'></i>");
        else
            $(row).find('.progress').append(" <i class='fa fa-warning text-red'></i>");
    });
});
</script>