<?php
session_start();
require("../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>General panchayat Election 2018 - Office PP2 Showcause Letter</title>
</head>
<body>
<?php
$opt = $_GET['opt'];
$code = $_GET['code'];
	$query_get_office=mysqli_query($DBLink,"SELECT office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.email, office.phone, office.mobile, office.tot_staff AS pp1_count, office.male_staff, office.female_staff, office.posted_date, COUNT(personnel.personcd) AS pp2_count, COUNT(CASE DATE_FORMAT(personnel.posted_date,'%Y') WHEN '2018' THEN 1 END) AS pp2_update_count FROM ((office INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN personnel ON office.officecd = personnel.officecd WHERE office.blockormuni_cd='$code' GROUP BY office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.email, office.phone, office.mobile, office.tot_staff, office.male_staff, office.female_staff, office.posted_date HAVING pp2_count > pp2_update_count ORDER BY office.officecd") or die(mysqli_error($DBLink));

	while($res=mysqli_fetch_assoc($query_get_office))
	{
?>
  <span style="page-break-after: always;"><br></span>
	<table cellspacing = 0 cellpadding = 5>
    <tr>
  		<th colspan="2"><div>Government of West Bengal<br>
  			Office of the District Panchayat Election Office & District Magistrate, Hooghly<br>
  			<u>District Polling Personel Cell, Hooghly</u></div>
  			<hr style="border : 1px solid black;">
	  </th>
    </tr>
		<tr>
      <th width="50%" align="left">Memo No: 12(95)</th>
      <th width="50%" align="right">Dated: 04/04/2018</th>
		</tr>
		<tr>
			<th width="50%" align="left">
				To <br>
				<?php echo $res['officer_desg'];?> <br>
        <?php echo $res['office'];?> <br>
				<?php echo $res['address1'].', '.$res['address2'].'; <strong>Block/Muni</strong> - '.$res['blockmuni'].'; <strong>P.S. </strong>- '.$res['policestation'].'; <strong>PO: </strong>'.$res['postoffice'].'; <strong>Pin </strong>- '.$res['pin'];?>
			</th>

  		<th style="width: 50%;">
  					<strong>Office Code : <?php echo $res['officecd'];?></strong><br>
  				<strong>Block/Municipality: <?php echo $res['blockmuni'];?></strong>
  		</span>
		</tr>
    <tr>
      <th colspan="2">
        Sub :  Show Cause Notice.
      </th>
    </tr>
		<tr>
      <td colspan="2" align="justify">&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, it has been found that inspite of service of PP1 and PP2 for updating office details and Employees details in connection with performing of Polling Duty to the Panchyayat General Election 2018 under this office memo. No.s 01(1600) / PP Cell (Dist) dated 23.02.2018 and 03(1600) PP Cell (Dist) dated 16.03.2018, you have intentionally and deliberately not updated office details and employees details till date.
        <br><br>
        &nbsp;&nbsp;&nbsp;NOW THEREFORE, you are directed to show-cause as to why disciplinary action of the Representation of People Act 1951 will not be taken against you.
         <br><br>
  &nbsp;&nbsp;&nbsp;Your written reply should reach the undersigned within 03 (three) days from the date of receipt of this letter. <br>

      </tr>
      <tr>
        <th colspan="2" align="right">
		<img src="../img/dm_sign.jpg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
          District Panchayat Election Officer, &  District Magistrate,<br><strong><u>Hooghly</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
        </th>
      </tr>
      <tr>
        <td colspan="2" align="center">
  			   <hr>
        </td>
      </tr>
      <tr>
        <td colspan="2">
  			     <div align="left">Received the copy with Memo. No.  12(95) Dated: 04/04/2018<br>
  			     <strong>OFFICE CODE : <?php echo $res['officecd'];?></strong></div>
  			     <div align="right"> Signature of the receiving officer <br> with phone no. and office seal</div>
        </td>
      </tr>
	</table>
  <span style="page-break-after: always;"><br></span>
  <?php
    }
   ?>
</body>
</html>
