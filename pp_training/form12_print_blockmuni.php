<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

$block_muni_code=$_GET['block_muni_code'];

$first_app_query=$mysqli->prepare("SELECT personcd, epic, partno, slno, acno, office.officecd, assembly.assemblycd, assembly.assemblyname, pc.pccd, pc.pcname FROM ((personnel INNER JOIN office ON personnel.officecd=office.officecd) INNER JOIN assembly ON personnel.acno = assembly.assemblycd) INNER JOIN pc ON assembly.pccd = pc.pccd WHERE office.blockormuni_cd = ? AND personnel.booked IN ('P','R') AND assembly.assemblycd != '999' ORDER BY office.officecd, personcd") or die($mysqli->error);
$first_app_query->bind_param("s",$block_muni_code) or die($first_app_query->error);
$first_app_query->execute() or die($first_app_query->error);
$first_app_query->bind_result($personcd, $epic, $partno, $slno, $acno, $officecd, $assemblycd, $assemblyname, $pccd, $pcname) or die($first_app_query->error);

$pp_data=array();
while($first_app_query->fetch()){
    $pp_data[]=array("personcd"=>$personcd, "epic"=>$epic, "PartNo"=>$partno, "SlNo"=>$slno, "acno"=>$acno, "officecd"=>$officecd, "AssemblyCode"=>$assemblycd, "AssemblyName"=>$assemblyname, "PcCode"=>$pccd, "PcName"=>$pcname);
}
for($i = 0;$i < count($pp_data); $i++){
?>
<html>
    <title>
        Form 12 Block Municipality wise
    </title>
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
        <th colspan="2" style="padding-top: 90; font-size: 10">
            <?php echo "<strong>Office Code - ".$pp_data[$i]['officecd']."; Emp Code - ".$pp_data[$i]['personcd']."; EPIC - ".$pp_data[$i]['epic']."</strong>";?>
        </th>
    </tr>
</table>
<p style="page-break-after: always"></p>
<?php
}
?>
</html>