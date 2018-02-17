<?php
session_start();
require("../config/config.php");

if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");

$post_stat="AE";
$remarks_names=array();
$aeo_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.off_desg, office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.phone, office.mobile, personnel.mob_no, personnel.email FROM ((office INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd=personnel.officecd WHERE personnel.poststat = ?") or die($mysqli->error);
$aeo_query->bind_param("s",$post_stat) or die($aeo_query->error);
$aeo_query->execute() or die($aeo_query->error);
$aeo_query->bind_result($personcd,$officer_name,$off_desg,$officecd,$office,$officer_desg,$address1,$address2,$blockmuni,$policestation,$postoffice,$pin,$phone,$mobile,$mob_no,$email) or die($aeo_query->error);

$aeo_list=array();
while($aeo_query->fetch()){
	$aeo_list[]=array("personcd"=>$personcd,"officer_name"=>$officer_name,"off_desg"=>$off_desg,"officecd"=>$officecd,"office"=>$office,"officer_desg"=>$officer_desg,"address1"=>$address1,"address2"=>$address2,"blockmuni"=>$blockmuni,"policestation"=>$policestation,"postoffice"=>$postoffice,"pin"=>$pin,"phone"=>$phone,"mobile"=>$mobile,"mob_no"=>$mob_no,"email"=>$email);
}
$aeo_query->close();
?>
<table cellpadding="0" cellspacing="1" border="1">
<thead>
<tr>
    <th>#</th>
    <th>Office Code </th>
    <th>Office Name</th>
    <th>Head Of Office Designation</th>
    <th>Office Address</th>
    <th>Office Contact Details</th>
    <th>Officer Code</th>
    <th>Officer Name</th>
    <th>Officer Designation</th>
    <th>Officer Contact Details</th>
</tr>
</thead>
<tbody>

<?php
	for($i=0;$i<count($aeo_list);$i++){
?>
    <tr>
	<td><?php echo ($i+1); ?></td>
        <td><?php echo $aeo_list[$i]['officecd']; ?></td>
        <td><?php echo $aeo_list[$i]['office']; ?></td>
        <td><?php echo $aeo_list[$i]['officer_desg']; ?></td>
        <td><?php echo $aeo_list[$i]['address1'].', '.$aeo_list[$i]['address2'].'; <strong>Block/Muni</strong> - '.$aeo_list[$i]['blockmuni'].'; <strong>P.S. </strong>- '.$aeo_list[$i]['policestation'].'; <strong>PO: </strong>'.$aeo_list[$i]['postoffice'].'; <strong>Pin </strong>- '.$aeo_list[$i]['pin']; ?></td>
        <td><?php echo "(P): ".$aeo_list[$i]['phone']."; (M): ".$aeo_list[$i]['mobile']; ?></td>
        <td><?php echo $aeo_list[$i]['personcd']; ?></td>
        <td><?php echo $aeo_list[$i]['officer_name']; ?></td>
        <td><?php echo $aeo_list[$i]['off_desg']; ?></td>
        <td><?php echo "(M): ".$aeo_list[$i]['mob_no']."; (Email): ".$aeo_list[$i]['email']; ?></td>
        
    </tr>
<?php
}
?>
</tbody>
<tfoot>
    <tr>
	
    </tr>
</tfoot>
</table>