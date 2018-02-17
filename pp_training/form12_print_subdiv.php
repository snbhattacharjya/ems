<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

$subdiv_code=$_GET['subdiv_code'];

$first_app_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, poststatus, mob_no, epic, partno, slno, acno, bank, branch, ifsc, bank_accno, officecd, office, address, block_muni_name, postoffice, subdivision, policestation, district, pin, training_desc, venuename, venueaddress, training_dt, training_time FROM first_rand_table WHERE subdivisioncd = ? ORDER BY officecd, personcd") or die($mysqli->error);
$first_app_query->bind_param("s",$subdiv_code) or die($first_app_query->error);
$first_app_query->execute() or die($first_app_query->error);
$first_app_query->bind_result($personcd, $officer_name, $off_desg, $poststatus, $mob_no, $epic, $partno, $slno, $acno, $bank, $branch, $ifsc, $bank_accno, $officecd, $office, $address, $block_muni_name, $postoffice, $subdivision, $policestation, $district, $pin, $training_desc, $venuename, $venueaddress, $training_dt, $training_time) or die($first_app_query->error);

$pp_data=array();
while($first_app_query->fetch()){
    $pp_data[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "off_desg"=>$off_desg, "poststatus"=>$poststatus, "mob_no"=>$mob_no, "epic"=>$epic, "partno"=>$partno, "slno"=>$slno, "acno"=>$acno, "bank"=>$bank, "branch"=>$branch, "ifsc"=>$ifsc, "bank_accno"=>$bank_accno, "officecd"=>$officecd, "office"=>$office, "address"=>$address, "block_muni_name"=>$block_muni_name, "postoffice"=>$postoffice, "subdivision"=>$subdivision, "policestation"=>$policestation, "district"=>$district, "pin"=>$pin, "training_desc"=>$training_desc, "venuename"=>$venuename, "venueaddress"=>$venueaddress, "training_dt"=>$training_dt, "training_time"=>$training_time);
}
for($i = 0;$i < count($pp_data); $i++){
?>
<table width="100%" style="font-family: sans-serif; font-size: 12">
    <tr>
        <th colspan="2">
            FORM 12<br>
            (<i>See rules </i>19 and 20)<br>
            LETTER OF INTIMATION TO RETURNING OFFICER
        </th>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 30; text-align: left">
            To<br>
            The Returning Officer for<br>
            Assembly Constituency - <strong><?php echo $pp_data[$i]['AssemblyCode']."-".$pp_data[$i]['AssemblyName']; ?></strong>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 30; text-align: left">
            Sir,
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;I intend to cast my vote by post at the ensuing election to the Legislative Assembly/House of the People from the <strong><?php echo $pp_data[$i]['AssemblyCode']."-".$pp_data[$i]['AssemblyName']; ?></strong> Assembly Constituency.
            <p>
                &nbsp;&nbsp;&nbsp;My name is entered at S.No. <strong><?php echo $pp_data[$i]['SlNo']; ?></strong> in Part No. <strong><?php echo $pp_data[$i]['PartNo']; ?></strong> of the electoral role for <strong><?php echo $pp_data[$i]['AssemblyCode']."-".$pp_data[$i]['AssemblyName']; ?></strong> assembly constituency comprised within <strong> <?php echo $pp_data[$i]['PcCode']."-".$pp_data[$i]['PcName']; ?></strong> Parliamentary Constituency.
            </p>
            <p>
                &nbsp;&nbsp;&nbsp;The ballot paper may be sent to me at the following address:-<br><br>
                ........................................................<br>
                ........................................................<br>
                ........................................................
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 30; width: 50%">
            Place: ...................<br><br>
            Date:  ...................
        </td>
        <td style="padding-top: 30; width: 50%; text-align: right">
            Yours faithfully,<br><br>
            ..................................
        </td>
    </tr>
    <tr>
        <th colspan="2">
            <?php echo "Emp Code - ".$pp_data[$i]['personcd']."; EPIC - ".$pp_data[$i]['epic'];?>
        </th>
    </tr>
</table>
<p style="page-break-after: always"></p>
<?php
}
?>