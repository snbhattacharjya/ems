<?php
session_start();
if(!isset($_SESSION['UserID']))
    die("Login Expired!. Please Login again to continue");
require("../config/config.php");

$opt=$_GET['opt'];
$subdiv=$_GET['subdiv'];

if($opt == 'COUNT_PP'){
$counting_pp_query=$mysqli_countppds->prepare("SELECT personnela.personcd, personnela.officer_name, personnela.off_desg, office.officecd, office.office, office.address1, office.address2, poststat.poststatus, personnela.mob_no, personnela.forassembly, assembly.assemblyname, personnela.groupid, grp_dcrc.member, poststatorder.membno, counting_allowance.amount FROM (((((personnela INNER JOIN office ON personnela.officecd = office.officecd) INNER JOIN poststat ON personnela.poststat = poststat.post_stat) INNER JOIN assembly ON assembly.assemblycd = personnela.forassembly) INNER JOIN grp_dcrc ON grp_dcrc.forassembly = personnela.forassembly AND grp_dcrc.groupid = personnela.groupid) INNER JOIN poststatorder ON poststatorder.memberparty = grp_dcrc.member AND poststatorder.poststat = personnela.poststat) INNER JOIN counting_allowance ON counting_allowance.poststat = personnela.poststat AND counting_allowance.booked = personnela.booked WHERE personnela.booked IN ('P') AND personnela.forsubdivision = ? ORDER BY personnela.forassembly, personnela.groupid, poststatorder.membno") or die($mysqli_countppds->error);
}
else if($opt == 'COUNT_GRD'){
    $counting_pp_query=$mysqli_countgrdppds->prepare("SELECT personnela.personcd, personnela.officer_name, personnela.off_desg, office.officecd, office.office, office.address1, office.address2, poststat.poststatus, personnela.mob_no FROM (personnela INNER JOIN office ON personnela.officecd = office.officecd) INNER JOIN poststat ON personnela.poststat = poststat.post_stat WHERE personnela.booked IN ('P','R') AND personnela.forsubdivision = ? ORDER BY personnela.poststat, personnela.personcd") or die($mysqli_countgrdppds->error);
}
$counting_pp_query->bind_param("s",$subdiv) or die($counting_pp_query->error);
$counting_pp_query->execute() or die($counting_pp_query->error);
$counting_pp_query->bind_result($personcd,$officer_name,$off_desg,$officecd,$office_name,$address1,$address2,$poststatus,$mobile,$forassembly,$assemblyname,$groupid,$member,$membno,$amount) or die($counting_pp_query->error);

$return=array();

while($counting_pp_query->fetch()){
	$return[]=array("PersonID"=>$personcd,"OfficerName"=>$officer_name,"Designation"=>$off_desg,"OfficeID"=>$officecd,"OfficeName"=>$office_name,"Address1"=>$address1,"Address2"=>$address2,"PostStatus"=>$poststatus,"Mobile"=>$mobile, "AssemblyCode"=>$forassembly, "AssemblyName"=>$assemblyname, "GroupID"=>$groupid, "MemberParty"=>$member, "MemberNo"=>$membno, "Amount"=>$amount);
}
$counting_pp_query->close();

?>
<title>Counting Personnel Party Muster Roll</title>
<h3>
    Counting Personnel Party Muster Roll
</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Assembly</th>
            <th>Party</th>
            <th>Post Status</th>
            <th>Person ID</th>
            <th>Officer Name</th>
            <th>Designation / Office</th>
            <th>Mobile</th>
            <th>Amount</th>
            <th>Signature</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i = 0; $i < count($return); $i++){
        ?>
        <tr>
            <td><?php echo $return[$i]['AssemblyCode']." - ".$return[$i]['AssemblyName']; ?></td>
            <td><?php echo $return[$i]['GroupID']; ?></td>
            <td><?php echo $return[$i]['PostStatus']; ?></td>
            <td><?php echo $return[$i]['PersonID']; ?></td>
            <td><?php echo $return[$i]['OfficerName']; ?></td>
            <td><?php echo $return[$i]['Designation'].", ".$return[$i]['OfficeName']." - ".$return[$i]['Address1'].", ".$return[$i]['Address2']." (".$return[$i]['OfficeID'].")"; ?></td>
            <td><?php echo $return[$i]['Mobile']; ?></td>
            <td><?php echo $return[$i]['Amount']; ?></td>
            <td><?php echo "&nbsp;"; ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        
    </tfoot>
</table>