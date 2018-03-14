<?php
session_start();
require("../config/config.php");
$office_code = $_SESSION['Office'];
?>

<script>
$(document).ready(function(e) {
    	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/check_declaration.php',
		type: 'POST',
		success: function(data) {
			retObj = JSON.parse(JSON.stringify(data));
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(jqXHR+ textStatus+errorThrown);
		},
		dataType: "json",
		async: false
		});
		if(retObj=="TRUE")
		{$('#checkboxdiv').hide();
		$('#div_message').html("<h2>You have already checked the declaraiton.</h2>");
		$('#div_message').show();
		$('.box-footer').hide();
		}

		if(retObj=="NOTELIGIBLE")
		{$('#checkboxdiv').hide();
		$('#div_message').html("<h2>You have not yet completed all your employee entry.</h2>");
		$('#div_message').show();
		$('.box-footer').hide();}

	$('#Save').click(function(e) {

		if($('#dc_check').prop('checked'))
		{
    	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'php/mark_declaration.php',
		type: 'POST',
		success: function(data) {
			$('#checkboxdiv').html("<h2>Declaration Successfully Checked.</h2>");
					$('.box-footer').hide();
		},
			error: function (jqXHR, textStatus, errorThrown) {
			alert(jqXHR+ textStatus+errorThrown);
		},
		dataType: "html",
		async: false
		});
		}
		else
		{
			alert("Please Check the CheckBox");
		}
    });
});
</script>
<div class="row">

	<div class="col-sm-12">
    	<div class="box box-info">
        	<div class="box-header with-border">
            	<h4 class="box-title">DECLARATION FORM</h4>
         	</div><!-- /.box-header -->
			<div class="box-body">

           	<div id="div_message" class="callout callout-danger" hidden="">

    		</div>
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h4 class="text-red">Office Details</h4>
            <?php
              $query_get_office=mysqli_query($DBLink,"SELECT office.officecd, office.office, office.officer_desg, office.address1, office.address2, block_muni.blockmuni, policestation.policestation, office.postoffice, office.pin, office.email, office.phone, office.mobile, office.tot_staff AS pp1_count, office.male_staff, office.female_staff, office.posted_date FROM (office INNER JOIN block_muni ON block_muni.blockminicd=office.blockormuni_cd) INNER JOIN policestation ON policestation.policestationcd=office.policestn_cd WHERE office.officecd='$office_code'") or die(mysqli_error($DBLink));
              $res=mysqli_fetch_assoc($query_get_office)
            ?>
            <dl class="dl-horizontal">
              <dt>Office Code</dt>
              <dd>: <?php echo $res['officecd'];?></dd>
              <dt>Office Name</dt>
              <dd>: <?php echo $res['office'];?></dd>
              <dt>Head Of Office</dt>
              <dd>: <?php echo $res['officer_desg'];?></dd>
              <dt>Office Address</dt>
              <dd>: <?php echo $res['address1'].', '.$res['address2'].'; <strong>Block/Muni</strong> - '.$res['blockmuni'].'; <strong>P.S. </strong>- '.$res['policestation'].'; <strong>PO: </strong>'.$res['postoffice'].'; <strong>Pin </strong>- '.$res['pin'];?></dd>
              <dt>Email</dt>
              <dd>: <?php echo $res['email'];?></dd>
              <dt>Contact Details</dt>
              <dd>: <?php echo $res['phone']." / ".$res['mobile']; ?></dd>
              <dt>Total Employees</dt>
              <dd>: <?php echo $res['pp1_count']; ?></dd>
              <dt>Male</dt>
              <dd>: <?php echo $res['male_staff']; ?></dd>
              <dt>Female</dt>
              <dd>: <?php echo $res['female_staff']; ?></dd>
              <dt>PP1 Update Date</dt>
              <dd>: <?php
                if(date_format(date_create($res['posted_date']),'Y') == 2018){
                  echo date_format(date_create($res['posted_date']),'d-M-Y H:i:s');
                }
                else {
                  echo "Not Updated";
                }
              ?></dd>
            </dl>
          </div>
        </div>

        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h4 class="text-red">Employee Details</h4>
            <?php
              $query_employee = mysqli_query($DBLink, "SELECT COUNT(CASE gender WHEN 'M' THEN 1 END) AS MaleCount, COUNT(CASE gender WHEN 'F' THEN 1 END) AS FemaleCount FROM personnel WHERE officecd = '$office_code'") or die(mysqli_error($DBLink));

              $res = mysqli_fetch_assoc($query_employee);
            ?>
            <dl class="dl-horizontal">
              <dt>Total Employees Added</dt>
              <dd>: <?php echo $res['MaleCount'] + $res['FemaleCount']; ?></dd>
              <dt>Male</dt>
              <dd>: <?php echo $res['MaleCount']; ?></dd>
              <dt>Female</dt>
              <dd>: <?php echo $res['FemaleCount']; ?></dd>
            </dl>
          </div>
        </div>

        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <h4 class="text-red">Employee Remarks</h4>
            <?php
              $remarks_names=array();
              $remarks_query=$mysqli->prepare("SELECT remarks.remarks_cd, remarks.remarks, COUNT(personnel.personcd) FROM personnel INNER JOIN remarks ON personnel.remarks=remarks.remarks_cd WHERE personnel.officecd = ? GROUP BY remarks.remarks_cd, remarks.remarks ORDER BY remarks.remarks_cd") or die($mysqli->error);
              $remarks_query->bind_param('s',$office_code);
              $remarks_query->execute() or die($remarks_query->error);
              $remarks_query->bind_result($remarks_code,$remarks_name,$tot_remarks_count) or die($remarks_query->error);
              while($remarks_query->fetch()){
                $remarks_names[]=array("RemarksCode"=>$remarks_code,"RemarksName"=>$remarks_name,"TotalRemarksCount"=>$tot_remarks_count);
              }
              $remarks_query->close();
            ?>
            <table class="table table-bordered table-hover table-condensed" id="pp2_table">
              <thead>
                <th>Remarks</th>
                <th>Employee Count</th>
              </thead>
              <tbody>
                <?php
                  for($i=0; $i < count($remarks_names); $i++){
                ?>
                    <tr>
                      <td><?php echo $remarks_names[$i]['RemarksName'];?></td>
                      <td><?php echo $remarks_names[$i]['TotalRemarksCount'];?></td>
                    </tr>
                <?php
                  }
                  $mysqli->close();
                ?>
              </tbody>
            </table>
          </div>
        </div>

            <div class="row" id="checkboxdiv">
                <div class="col-sm-12">
                  <div class="input-group">
                    <span class="input-group-addon">
                      <input type="checkbox" id="dc_check">
                    </span>
                    <textarea class="form-control" disabled="disabled" rows="3">Certified that the detail information furnished earlier in PP-1 format and also PP-2 format are verified with office record and genuine. Names of all officials have been included in the PP-2 format and no information has been concealed.</textarea>
                  </div>
                </div>
         	</div>
        	</div>
            <div class="box-footer text-center">
    	<button type="button" class="btn btn-success btn-lg"  id="Save" ><span><i class="fa fa-save"></i></span>&nbsp;&nbsp;Save</button>
        </div>
     	</div>
	</div>
</div>
