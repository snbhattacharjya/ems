<?php
session_start();
require("../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>General Loksabha Election 2019 - Office Letter 04/PPCELL(Dist) 29.11.2018</title>
</head>
<body>
<?php
$opt = $_GET['opt'];
$code = $_GET['code'];
	$query_get_office=mysqli_query($DBLink,"SELECT office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.email, office.phone, office.mobile, office.tot_staff AS pp1_count, office.male_staff, office.female_staff, office.posted_date, user_random_password.rand_password FROM (((office INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd) INNER JOIN user_random_password ON office.officecd = user_random_password.rand_id) INNER JOIN training2_office_hooghly ON office.officecd = training2_office_hooghly.office_id WHERE office.blockormuni_cd='$code' ORDER BY office.officecd") or die(mysqli_error($DBLink));
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
      <th width="50%" align="left">Memo No: 07/PPCELL(Dist)</th>
      <th width="50%" align="right">Dated: 13/12/2018 </th>
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
        Sub :  Submission of filled in PP-I and PP-2 in connection with ensuing General Parliament Election 2019.
      </td>
    </tr>
    <tr>
      <td colspan="2">
        Ref: No. 3228 Home(Elec.) dt. 02/11/2018 of the CEO, West Bengal.
      </td>
    </tr>
    <tr>
      <td colspan="2">
        Sir/Madam,
      </td>
    </tr>
		<tr>
      <td colspan="2" align="justify">
        &nbsp;&nbsp;&nbsp;&nbsp;As per direction of the Chief Electoral Officer, West Bengal, you are requested to furnish PP-1 (Office Details) & PP-2 (Employee Details) format duly filled in web portal www.wbppms.gov.in by 17/12/2018 positively. Please note that no column should be left blank. The credential of the online application as given below. After first login you must change your password.
      <br><br>
      </td>
      </tr>

      <tr>
        <th width="25%" align="left" style="border: 1px solid black">
          User ID: <?php echo $res['officecd'];?><br><br>
          Password: <?php echo $res['rand_password'];?>
        </th>
      </tr>

      <tr>
          <td colspan="2" align="center"><br><br>
          <table border="1" cellspacing="0" cellpadding="5">
            <tr>
              <td colspan="3">For this purpose a training will be held as per the following schedule. You are requested to attend the training as per schedule.</td>
            </tr>
            <tr>
              <td>Name of Sub-division</td>
              <td>Training Venue</td>
              <td>Date & Time</td>
            </tr>
            <tr>
              <td>Sadar</td>
              <td rowspan="4">Rabindra Bhaban, Chinsurah</td>
              <td rowspan="4">17.12.2018. 12 noon.</td>
            </tr>
            <tr>
              <td>Serampore</td>
              
            </tr>
            <tr>
              <td>Chandannagar</td>
              
            </tr>
            <tr>
              <td>Arambagh</td>
              
            </tr>
          </table>
        </td>
      </tr>
      <tr>
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
          Received the copy with Memo No. 07/PPCELL(Dist)  dated. 13/12/2018<br><br>
          <strong>Office Code: <?php echo $res['officecd'];?></strong>
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
