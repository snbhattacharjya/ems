<title>
    Personnel List for Postal Ballot Cell
</title>
<?php
session_start();
if(!isset($_SESSION['UserID'])){
    die("Login Expired!. Please Login again to continue");
}
require("../config/config.php");

$subdiv=$_GET['subdiv'];
$training_date=$_GET['training_date'];
$assembly_temp=$_GET['assembly_temp'];

$assembly_query=$mysqli->prepare("SELECT personnel.personcd, personnel.officer_name, personnel.present_addr1, personnel.present_addr2, personnel.mob_no, personnel.epic, personnel.acno, personnel.partno, personnel.slno FROM ((personnel INNER JOIN assembly ON personnel.assembly_temp = assembly.assemblycd) INNER JOIN training_schedule ON personnel.training1_sch = training_schedule.schedule_code) INNER JOIN training_venue ON training_venue.venue_cd = training_schedule.training_venue WHERE personnel.personcd NOT IN (SELECT personcd FROM personnel_training_absent) AND training_venue.subdivisioncd = ? AND training_schedule.training_dt = ? AND personnel.assembly_temp = ? ORDER BY personnel.personcd, personnel.officer_name") or die($mysqli->error);
$assembly_query->bind_param("sss",$subdiv,$training_date,$assembly_temp) or die($assembly_query->error);
$assembly_query->execute() or die($assembly_query->error);
$assembly_query->bind_result($personcd, $officer_name, $present_addr1, $present_addr2, $mob_no, $epic, $acno, $partno, $slno) or die($assembly_query->error);
$return=array();
while($assembly_query->fetch())
{
    $return[]=array("personcd"=>$personcd, "officer_name"=>$officer_name, "present_addr1"=>$present_addr1, "present_addr2"=>$present_addr2, "mob_no"=>$mob_no, "epic"=>$epic, "acno"=>$acno, "partno"=>$partno, "slno"=>$slno);
}
$assembly_query->close();

$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivision FROM subdivision WHERE subdivision.subdivisioncd = ?") or die($mysqli->error);
$subdiv_query->bind_param("s",$subdiv) or die($subdiv_query->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($subdiv_name) or die($subdiv_query->error);
$subdiv_query->fetch() or die($subdiv_query->error);
$subdiv_query->close();

$assembly_query=$mysqli->prepare("SELECT assembly.assemblyname FROM assembly WHERE assembly.assemblycd = ?") or die($mysqli->error);
$assembly_query->bind_param("s",$assembly_temp) or die($assembly_query->error);
$assembly_query->execute() or die($assembly_query->error);
$assembly_query->bind_result($assembly_name) or die($assembly_query->error);
$assembly_query->fetch() or die($assembly_query->error);
$assembly_query->close();
?>
<table id="table_report" border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th colspan="9">
                Postal Ballot Personnel for Subdivision - <?php echo $subdiv_name; ?>, for Personnel with Present Assembly <?php echo $assembly_temp." - ".$assembly_name; ?> and 1st Training Date: <?php echo date_format(date_create($training_date),"d-M-Y"); ?>
            </th>
        </tr>
        
        <tr class="bg-blue-active">
            <th>#</th>
            <th>Personnel Code</th>
            <th>Personnel Name</th>
            <th>Address</th>
            <th>Mobile</th>
            <th>EPIC</th>
            <th>AC No</th>
            <th>Part No</th>
            <th>Sl No</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i=0;$i<count($return);$i++){
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $return[$i]['personcd']; ?></td>
            <td><?php echo $return[$i]['officer_name']; ?></td>
            <td><?php echo $return[$i]['present_addr1'].", ".$return[$i]['present_addr2']; ?></td>
            <td><?php echo $return[$i]['mob_no']; ?></td>
            <td><?php echo $return[$i]['epic']; ?></td>
            <td><?php echo $return[$i]['acno']; ?></td>
            <td><?php echo $return[$i]['partno']; ?></td>
            <td><?php echo $return[$i]['slno']; ?></td>
            
        </tr>
        <?php
        }
        ?>
    </tbody>
  </table> 

