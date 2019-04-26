<title>
    Subdivision wise - Dummy 1st Appointment Letter
</title>
<?php
require("../config/config.php");
$env_query=$mysqli->prepare("SELECT environment, distnm_sml, apt1_orderno, apt1_date FROM environment") or die($mysqli->error);
$env_query->execute() or die($env_query->error);
$env_query->bind_result($env, $dist, $apt1_order_no, $apt1_date) or die($env_query->error);
$env_query->fetch() or die($env_query->error);
$env_query->close();


?>
<table width="100%" style="font-family: sans-serif; font-size: 11">
    <tr>
        <th width="20%">&nbsp;Election Urgent </th>
        <th width="60%">
            <img src="../pp_training/indian-symbol4.jpg" alt=""/><br>
            ORDER OF APPOINTMENT FOR<br>
            <?php echo $env.", ".$dist; ?>
        </th>
        <th width="20%">&nbsp;</th>
    </tr>
    <tr>
        <th width="20%">Memo No: 21/PP CELL Dist(24525) </th>
      <th width="60%">&nbsp;
            
        </th>
        <th width="20%">Dated: 09/04/2018</th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15; text-align: justify">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In exercise of the power conferred upon vide Section 26 of the R. P. Act, 1951 read with sub section(5) of section 6 of West Bengal State Election Commission Act 1994 (WB Act VIII of 1994) read with section 28 of the West Bengal Panchayat Election Act 2003, I do hereby appoint the officer specified below as Polling Officer for undergoing training in connection with the conduct of West Bengal Panchayat Election, 2018 in district of Hooghly. </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 15;">
            <table width="98%" border="1" align="center" cellpadding="5" cellspacing="0" style="font-family: sans-serif; font-size: 11">
                <tr>
                    <th width="25%">Polling Officer</th>
                    <th width="50%">Office Address</th>
                    <th width="25%">Post Status</th>
                </tr>
                <tr>
                    <th align="left">ASHISH SHARMA OFFICER PIN - 13040106206</th>
                    <td align="left">BANK OF INDIA, KABLE BRANCH (1304010001), DAKSHIN RASULPUR, KABLE P.O.- DAKSHIN RASULPUR, SUBDIV- ARAMBAGH, P.S.- ARAMBAGH, DIST - HOOGHLY, PINCODE- 712143</td>
                    <th align="center">Micro Observer</th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10;">
            The Officer should report for Training as per following Schedule:
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10;">
            <table width="98%" border="1" align="center" cellpadding="5" cellspacing="0" style="font-family: sans-serif; font-size: 11">
                <tr>
                    <th colspan="3">
                        Training Schedule
                    </th>
                </tr>
                <tr>
                    <th width="25%">Training</th>
                    <th width="50%">Venue & Address</th>
                    <th width="25%">Date and Time</th>
                </tr>
                <tr>
                    <th align="center">First Training </th>
                    <th align="left">Arambagh girls college, Room No - 2, Arambagh, Pin-712601, Dist - Hooghly</th>
                    <th align="center">14/04/2018 10.00 AM</th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 10; text-align: justify">This is a compulsory duty on your part to attend the said programme,as per the provisions of the Representation of the People's Act, 1951, remaining absent in attending training and performing subsequent duties will invite strict penal action. </td>
    </tr>
    
    <tr>
        <td style="padding-top: 10; text-align: left;">
            Place: Hooghly<br>
            Date: <?php echo date_format(date_create_from_format("Y-m-d", $apt1_date), "d/m/Y"); ?>
        </td>
        <th style="padding-top: 10; text-align: left">&nbsp;</th>
        <td style="padding-top: 10; text-align: left;">
            <img src="../pp_training/dm-sign1.jpg" alt=""/><br>
            District Election Officer&nbsp;&nbsp;&nbsp;&nbsp;<br>
            District Hooghly
        </td>
    </tr>
    <tr>
    	<td>
        	<table>
            	<tr>
                	<td>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <th colspan="3">
            <hr>
        </th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 5; text-align: justify">
            NB <br>
            <ol>
                <li>
                Please check your electoral data and bank details given below. For any inconsistency please inform the authority. <strong><br> 
                EPIC N0. - Dummy, Sl. No.- Dummy <br>Bank - Dummy Bank, Branch - Dummy Branch <br>A/c No.- Dummy Ac/no, IFS Code- Dummy IFSC</strong></li>
            </ol>
        </td>
    </tr>
    <tr>
        <th colspan="3" style="padding-top: 10; text-align: justify">
            <hr style="border-style: dashed">
        </th>
    </tr>
    <tr>
        <th colspan="3" style="padding-top: 5; text-align: justify">
            Copy to DDO / Head of Office to serve the Letter and Letter and submit the service return.
        </th>
    </tr>
    <tr>
        <th colspan="3" style="padding-top: 5; text-align: justify">
            <hr style="border-style: dashed">
        </th>
    </tr>
    <tr>
        <td colspan="3" style="padding-top: 50">
            <table width="100%" style="font-family: sans-serif; font-size: 11">
                <tr>
                    <td width="33%">
                        Receipt of Appointment Letter
                    </td>
                    <td width="33%" align="center">
                        Block/Municipality: <br>
                        <strong>Dummy Block/Muni</strong>
                    </td>
                    <td width="33%">
                        Signature of the Recipient<br>
                        Date:
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<p style="page-break-after: always"></p>
