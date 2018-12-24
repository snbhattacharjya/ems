<?php
session_start();
require("../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>General Loksabha Election 2019 - Office Letter 10/PPCELL(Dist) 24.12.2018</title>
</head>
<body>
<?php
$opt = $_GET['opt'];
$code = $_GET['code'];
	$query_get_office=mysqli_query($DBLink,"SELECT offices.id, offices.name AS office_name, offices.officer_designation, offices.address,  block_munis.name AS block_muni_name, police_stations.name AS police_station_name, offices.post_office, offices.pin, offices.email, offices.phone, offices.mobile FROM ((offices INNER JOIN block_munis ON block_munis.id=offices.block_muni_id) INNER JOIN police_stations ON police_stations.id=offices.police_station_id) INNER JOIN training_yes_office_nopp ON offices.id = training_yes_office_nopp.office_id WHERE offices.block_muni_id='$code' ORDER BY offices.id") or die(mysqli_error($DBLink));
	while($res=mysqli_fetch_assoc($query_get_office))
	{
?>
	<table cellspacing = 0 cellpadding = 10>
    <tr>
  		<th colspan="2"><div>Government of West Bengal<br>
  			Office of the District Election Officer & District Magistrate, Hooghly<br>
  			<u>District Polling Personel Cell, Hooghly</u><br>
        <i>Email: ppcell.hooghly@gmail.com</i></div>
  			<hr style="border : 1px solid black;">
	  </th>
    </tr>
		<tr>
      <th width="50%" align="left">Memo No: 10/PPCELL(Dist)</th>
      <th width="50%" align="right">Dated: 24/12/2018 </th>
		</tr>
		<tr>
			<th width="50%" align="left">
				To <br>
				<?php echo $res['officer_designation'];?> <br>
        <?php echo $res['office_name'];?> <br>
				<?php echo $res['address'].'; <strong>Block/Muni</strong> - '.$res['block_muni_name'].'; <strong>P.S. </strong>- '.$res['police_station_name'].'; <strong>PO: </strong>'.$res['post_office'].'; <strong>Pin </strong>- '.$res['pin'];?>
			</th>

  		<th style="width: 50%;">
  					<strong>Office Code : <?php echo $res['id'];?></strong><br>
  				<strong>Block/Municipality: <?php echo $res['block_muni_name'];?></strong>
  		</span>
		</tr>
    <tr>
      <td colspan="2">
      Sub : - Non-submission of online PP1 & PP2 data.
      </td>
    </tr>
    
    <tr>
      <td colspan="2">
        Sir/Madam,
      </td>
    </tr>
		<tr>
      <td colspan="2" align="justify">
        <p>&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, it has been found that you have attended the training regarding online submission of PP1 & PP2 data in connection with General Parliament Election 2019 on the scheduled date. But you have not yet started the data entry work till date.</p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;NOW THEREFORE, you are directed to submit the online data by 28.12.2018 otherwise disciplinary action will be initiated against you under the provision of Representation of People Act 1951.</p>
      <br><br>
      </td>
      </tr>

      
      <tr>
        <th colspan="2" align="right">
		<img src="../img/dm_sign_new.jpg"><br>
          District Election Officer, &  District Magistrate,<br><strong><u>Hooghly</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
        </th>
      </tr>

      <tr>
        <th colspan="2"><hr></th>
      </tr>

      <tr>
      <td width="50%" align="left">
          Received the copy with Memo No. 10/PPCELL(Dist)  dated. 24/12/2018<br><br>
          <strong>Office Code: <?php echo $res['id'];?></strong>
      </td>
      <td width="50%" align="right"><br><br><br><br>
        Signature of the Receiving Officer with Ph. No. & office seal.
      </td>
    </tr>
      
	</table>
  <p style="page-break-after: always;"></p>
  <?php
    }
   ?>
</body>
</html>
