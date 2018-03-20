<?php
session_start();
require("../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>General panchayat Election 2018 - Office PP2 Letter</title>
</head>
<body>
<?php
$opt = $_GET['opt'];
$code = $_GET['code'];
	$query_get_office=mysqli_query($DBLink,"SELECT office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.email, office.phone, office.mobile, office.tot_staff AS pp1_count, office.male_staff, office.female_staff, office.posted_date FROM (office INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd WHERE office.blockormuni_cd='$code' ORDER BY office.officecd") or die(mysqli_error($DBLink));
	while($res=mysqli_fetch_assoc($query_get_office))
	{
?>
	<table cellspacing = 0 cellpadding = 5>
    <tr>
  		<th colspan="2"><div>Government of West Bengal<br>
  			Office of the District Panchayat Election Office & District Magistrate, Hooghly<br>
  			<u>District Polling Personel Cell, Hooghly</u></div>
  			<hr style="border : 1px solid black;">
	  </th>
    </tr>
		<tr>
      <th width="50%" align="left">Memo No: 03(1600)/PP Cell(Dist)</th>
      <th width="50%" align="right">Dated: 16.03.2018 </th>
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
        Sub :  Online employee data entry and updation in PP-2 format and checking office data in PP-1 Format during 16<sup>th</sup> to 26<sup>th</sup> March' 2018
      </td>
    </tr>
		<tr>
      <td colspan="2" align="justify">&nbsp;&nbsp;&nbsp;&nbsp;This office has received office data in PP-1 format in connection with ensuing Panchayat General Election' 2018 from your end and the data has been incorporated in the district database hosted online which is available at <strong><u>www.hooghly.gov.in</u> --->  Hooghly Online PP Cell for PGE 2018</strong>. This time it has been decided that instead of receiving hard copy of report on empolyee data in PP-2 format, the office itself will make online data entry and updation of employee details in the prescribed format at the URL given.<br>&nbsp;&nbsp;&nbsp;The head of the office/Officer-in-Charge are requested to login in the portal and update the existing employees, also add the new employee in all respect. All the fields should be filled in cautiously without hiding any information since the same will be required not only for generation of PP appointment letter but also to inform  training schedule and other information through SMS and for e-payment of election allowance, if necessary.
  <br>
        &nbsp;&nbsp;&nbsp;The PP-1 office details have been incorporated as per online report submitted from your end. However, if there is any anomaly in respect of any field particularly, office staff strength,mobile no. & mail_id of Officer-in-Charge etc., the same may be modified online. <br>
  &nbsp;&nbsp;&nbsp;The application will be available online during the period from 16/03/2018 to 26/03/2018. All the Officer-in-Charge/Head of the Offices are requested to complete employee data entry and updation on existing data by 26/03/2018 without fail. In case of any difficulty, the concerned office may contact the election cell at the office of the <strong> Sub-Divisionl Officer</strong> for respective Sub-Division or at the nearset <strong>Block Office</strong>. <br>
  &nbsp;&nbsp;&nbsp;&nbsp;* Before start the employee entry/updation online, you must read carefully the guideline '<strong>HOW TO ENTER / UPDATE THE EMPLOYEES IN PP2 FORMAT ONLINE</strong>' which is available in the download option. <br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This is <strong>Election Urgent</strong></td>
      </tr>
      <tr>
        <th colspan="2" align="right">
		<img src="../img/sign.png">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
          District Panchayat Election Officer, &  District Magistrate,<br><strong><u>Hooghly</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
        </th>
      </tr>
      <tr>
        <td colspan="2" align="center">
  			   <strong>---------------------------------------------------------------------------------------------------------------</strong>
        </td>
      </tr>
      <tr>
        <td colspan="2">
  			     <div align="left">Received the copy with Memo. No. 03(1600)/PP Cell(Dist) dt. 16.03.2018 <br>
  			     <strong>OFFICE CODE : <?php echo $res['officecd'];?></strong></div>
  			     <div align="right"> Signature of the receiving officer <br> with phone no. and office seal</div>
        </td>
      </tr>
	</table>
  <span style="page-break-after: always;"></span>
  <?php
    }
   ?>
</body>
</html>
