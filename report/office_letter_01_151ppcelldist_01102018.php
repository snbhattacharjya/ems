<?php
session_start();
require("../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>General Loksabha Election 2019 - Office Letter 01(151) 01.10.2018</title>
</head>
<body>
<?php
$opt = $_GET['opt'];
$code = $_GET['code'];
	$query_get_office=mysqli_query($DBLink,"SELECT office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.email, office.phone, office.mobile, office.tot_staff AS pp1_count, office.male_staff, office.female_staff, office.posted_date FROM ((office INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN office_no_pp ON office.officecd = office_no_pp.officecd WHERE office.blockormuni_cd='$code' ORDER BY office.officecd") or die(mysqli_error($DBLink));
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
      <th width="50%" align="left">Memo No: 01(151)/PP Cell(Dist)</th>
      <th width="50%" align="right">Dated: 01.10.2018 </th>
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
      <td colspan="2">
        Sub :  Submission of filled in PP-2  in connection with ensuing General  Parliament  Election 2019.
      </td>
    </tr>
    <tr>
      <td colspan="2">
        Ref: No. 1475 Home (Elec.) dt. 22 /05 /2018 of the Joint CEO, West Bengal & this office memo. No. 466(200) / Elec dated 02.08.2018 and Memo No 504(146)/Elec dated 16.08.2018.
      </td>
    </tr>
    <tr>
      <td colspan="2">
        Sir/Madam,
      </td>
    </tr>
		<tr>
      <td colspan="2" align="justify">
        &nbsp;&nbsp;&nbsp;&nbsp;As per direction of the Chief Electoral Officer, West Bengal, you are requested to furnish PP-1 (Office Details) & PP-2 (Employee Details) format duly filled in web portal <strong>http://www.hooghly.gov.in, at <u>Online Polling Personnel Management System (EMS)</u></strong> by 08/08/2018 positively. But no reply has yet been received at your end.
      <br><br>
        &nbsp;&nbsp;&nbsp;You are further requested to update your PP2 format through online positively by 10/10/2018. Otherwise action will be taken against you as per Representation of People Act 1951.
      </td>
      </tr>
      <tr>
        <th colspan="2" align="right">
		<img src="../img/dm_sign_new.jpg"><br>
          District Election Officer, &  District Magistrate,<br><strong><u>Hooghly</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
        </th>
      </tr>
      <tr>
        <th width="50%" align="left">
          Enclo: As stated<br><br>
          User ID: <?php echo $res['officecd'];?><br><br><br>
          Password: <?php echo $res['officecd'];?>
        </th>
      </tr>
	</table>
  <p style="page-break-after: always;"></p>
  <?php
    }
   ?>
</body>
</html>
