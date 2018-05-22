<?php
session_start();
require("../config/config.php");
?>
<h3>Male Report</h3>    
<table class="table table-bordered" id="govt_post_table">
<thead>
<tr class="bg-maroon-gradient">
<th>Office Category</th>
<th>NA - <br /> NOT ASSIGNED</th>
<?php
	$post_stat_query="SELECT post_stat, poststatus FROM poststat ORDER BY post_stat";
	$post_stat_result=$mysqli->query($post_stat_query);
	$post_status=array();
	while($row = $post_stat_result->fetch_assoc()){
		$post_status[]=array("PostCode"=>$row['post_stat'],"PostName"=>$row['poststatus']);
?>
	<th><?php echo $row['post_stat'].' - <br>'.$row['poststatus']; ?></th>
<?php
	}
	$post_stat_result->close();
?>
<th>Total</th>
</tr>
</thead>
<tbody>
<?php
$govt_query="SELECT govt, govt_description FROM govtcategory ORDER BY govt";
$govt_result=$mysqli->query($govt_query);

$govt=array();
while($govt_row = $govt_result->fetch_assoc()){
	$govt[]=array("CategoryCode"=>$govt_row['govt'],"CategoryName"=>$govt_row['govt_description']);
}
$govt_result->close();

for($i = 0 ; $i < count($govt) ; $i++){
?>
<tr>
<td><?php echo $govt[$i]['CategoryName']; ?></td>
<?php
	$total_govt_post=0;
	
	$govt_post_query=$mysqli->prepare("SELECT COUNT(personcd) FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE office.govt = ? AND personnel.poststat = '' AND personnel.gender='M'") or die($mysqli->error);
	$govt_post_query->bind_param("s",$govt[$i]['CategoryCode']) or die($govt_post_query->error);
	$govt_post_query->execute() or die($govt_post_query->error);
	$govt_post_query->bind_result($govt_post_result) or die($govt_post_query->error);
	$govt_post_query->fetch() or die($govt_post_query->error);
	
	$govt_post_query->close();
	$total_govt_post+=$govt_post_result;
?>
<td><?php echo $govt_post_result ;?></td>
<?php
	
	for($j = 0 ; $j < count($post_status) ; $j++){
		$govt_post_query=$mysqli->prepare("SELECT COUNT(personcd) FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE office.govt = ? AND personnel.poststat = ?  AND personnel.gender='M'") or die($mysqli->error);
		$govt_post_query->bind_param("ss",$govt[$i]['CategoryCode'],$post_status[$j]['PostCode']) or die($govt_post_query->error);
		$govt_post_query->execute() or die($govt_post_query->error);
		$govt_post_query->bind_result($govt_post_result) or die($govt_post_query->error);
		$govt_post_query->fetch() or die($govt_post_query->error);
		
		$govt_post_query->close();
		$total_govt_post+=$govt_post_result;
?>
<td><?php echo $govt_post_result ;?></td>
<?php
	}
?>
<td><?php echo $total_govt_post;?></td>
</tr>
<?php 
}
?>
</tbody>
<tfoot>
	<tr class="danger">
    	<th>Total</th>
        <?php
		$total_govt_post=0;
		$govt_post_query=$mysqli->prepare("SELECT COUNT(personcd) FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE personnel.poststat = ''  AND personnel.gender='M'") or die($mysqli->error);
		$govt_post_query->execute() or die($govt_post_query->error);
		$govt_post_query->bind_result($govt_post_result) or die($govt_post_query->error);
		$govt_post_query->fetch() or die($govt_post_query->error);
		
		$govt_post_query->close();
		$total_govt_post+=$govt_post_result;
		?>
        <th><?php echo $govt_post_result ;?></th>
        <?php
		for($j = 0 ; $j < count($post_status) ; $j++){
			$govt_post_query=$mysqli->prepare("SELECT COUNT(personcd) FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE personnel.poststat = ? AND personnel.gender='M'") or die($mysqli->error);
			$govt_post_query->bind_param("s",$post_status[$j]['PostCode']) or die($govt_post_query->error);
			$govt_post_query->execute() or die($govt_post_query->error);
			$govt_post_query->bind_result($govt_post_result) or die($govt_post_query->error);
			$govt_post_query->fetch() or die($govt_post_query->error);
			
			$govt_post_query->close();
			$total_govt_post+=$govt_post_result;
?>
		<th><?php echo $govt_post_result ;?></th>
<?php
		}
?>
		<th><?php echo $total_govt_post;?></th>
    </tr>
</tfoot>
</table>

<h3>Female Report</h3>
<table class="table table-bordered" id="govt_female_post_table">
<thead>
<tr class="bg-maroon-gradient">
<th>Office Category</th>
<th>NA - <br /> NOT ASSIGNED</th>
<?php
	$post_stat_query="SELECT post_stat, poststatus FROM poststat ORDER BY post_stat";
	$post_stat_result=$mysqli->query($post_stat_query);
	$post_status=array();
	while($row = $post_stat_result->fetch_assoc()){
		$post_status[]=array("PostCode"=>$row['post_stat'],"PostName"=>$row['poststatus']);
?>
	<th><?php echo $row['post_stat'].' - <br>'.$row['poststatus']; ?></th>
<?php
	}
	$post_stat_result->close();
?>
<th>Total</th>
</tr>
</thead>
<tbody>
<?php
$govt_query="SELECT govt, govt_description FROM govtcategory ORDER BY govt";
$govt_result=$mysqli->query($govt_query);

$govt=array();
while($govt_row = $govt_result->fetch_assoc()){
	$govt[]=array("CategoryCode"=>$govt_row['govt'],"CategoryName"=>$govt_row['govt_description']);
}
$govt_result->close();

for($i = 0 ; $i < count($govt) ; $i++){
?>
<tr>
<td><?php echo $govt[$i]['CategoryName']; ?></td>
<?php
	$total_govt_post=0;
	
	$govt_post_query=$mysqli->prepare("SELECT COUNT(personcd) FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE office.govt = ? AND personnel.poststat = '' AND personnel.gender='F'") or die($mysqli->error);
	$govt_post_query->bind_param("s",$govt[$i]['CategoryCode']) or die($govt_post_query->error);
	$govt_post_query->execute() or die($govt_post_query->error);
	$govt_post_query->bind_result($govt_post_result) or die($govt_post_query->error);
	$govt_post_query->fetch() or die($govt_post_query->error);
	
	$govt_post_query->close();
	$total_govt_post+=$govt_post_result;
?>
<td><?php echo $govt_post_result ;?></td>
<?php
	
	for($j = 0 ; $j < count($post_status) ; $j++){
		$govt_post_query=$mysqli->prepare("SELECT COUNT(personcd) FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE office.govt = ? AND personnel.poststat = ?  AND personnel.gender='F'") or die($mysqli->error);
		$govt_post_query->bind_param("ss",$govt[$i]['CategoryCode'],$post_status[$j]['PostCode']) or die($govt_post_query->error);
		$govt_post_query->execute() or die($govt_post_query->error);
		$govt_post_query->bind_result($govt_post_result) or die($govt_post_query->error);
		$govt_post_query->fetch() or die($govt_post_query->error);
		
		$govt_post_query->close();
		$total_govt_post+=$govt_post_result;
?>
<td><?php echo $govt_post_result ;?></td>
<?php
	}
?>
<td><?php echo $total_govt_post;?></td>
</tr>
<?php 
}
?>
</tbody>
<tfoot>
	<tr class="danger">
    	<th>Total</th>
        <?php
		$total_govt_post=0;
		$govt_post_query=$mysqli->prepare("SELECT COUNT(personcd) FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE personnel.poststat = ''  AND personnel.gender='F'") or die($mysqli->error);
		$govt_post_query->execute() or die($govt_post_query->error);
		$govt_post_query->bind_result($govt_post_result) or die($govt_post_query->error);
		$govt_post_query->fetch() or die($govt_post_query->error);
		
		$govt_post_query->close();
		$total_govt_post+=$govt_post_result;
		?>
        <th><?php echo $govt_post_result ;?></th>
        <?php
		for($j = 0 ; $j < count($post_status) ; $j++){
			$govt_post_query=$mysqli->prepare("SELECT COUNT(personcd) FROM personnel INNER JOIN office ON personnel.officecd=office.officecd WHERE personnel.poststat = ? AND personnel.gender='F'") or die($mysqli->error);
			$govt_post_query->bind_param("s",$post_status[$j]['PostCode']) or die($govt_post_query->error);
			$govt_post_query->execute() or die($govt_post_query->error);
			$govt_post_query->bind_result($govt_post_result) or die($govt_post_query->error);
			$govt_post_query->fetch() or die($govt_post_query->error);
			
			$govt_post_query->close();
			$total_govt_post+=$govt_post_result;
?>
		<th><?php echo $govt_post_result ;?></th>
<?php
		}
?>
		<th><?php echo $total_govt_post;?></th>
    </tr>
</tfoot>
</table>
		   
<script>

var table=$('#govt_post_table').DataTable({
	"paging": false,
	"lengthChange": true,
	"searching": false,
	"ordering": true,
	"info": true,
	"autoWidth": true
});

var table1=$('#govt_female_post_table').DataTable({
	"paging": false,
	"lengthChange": true,
	"searching": false,
	"ordering": true,
	"info": true,
	"autoWidth": true
});

</script>