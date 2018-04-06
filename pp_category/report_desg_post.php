<?php
session_start();
require("../config/config.php");
?>

<table class="table table-bordered table-hover table-condensed" id="desg_post_table">
<thead>
<tr class="bg-teal">
<th class="dropdown">
    Officer Post Status <a href="#" class="dropdown-toggle pull-right" data-toggle="dropdown">
    <i class="fa fa-filter text-yellow"></i></a>
    <ul class="dropdown-menu">
        <li><a href="NA" class="poststat">NA - NOT ASSIGNED</a></li>
        <?php
			$new_post_stat="<select id='new_post_stat' class='select2' style='width: 100%;'>";

			$post_stat_query="SELECT post_stat, poststatus FROM poststat ORDER BY post_stat";
			$post_stat_result=$mysqli->query($post_stat_query);
			$post_status=array();
			while($row = $post_stat_result->fetch_assoc()){
				$post_status[]=array("PostCode"=>$row['post_stat'],"PostName"=>$row['poststatus']);
				$new_post_stat.="<option value='".$row['post_stat']."'>".$row['poststatus']."</option>";
		?>
			<li><a href="<?php echo $row['post_stat']; ?>" class="poststat"><?php echo $row['post_stat'].' - '.$row['poststatus']; ?></a></li>
		<?php
			}
			$post_stat_result->close();
			$new_post_stat.="</select>";
		?>
    </ul>
</th>
<th>
Remarks
</th>
<th>
Officer Designation
</th>
<th>
Qualification
</th>
<th>Total Available</th>
<th>Basic Pay Range</th>
<th>Grade Pay Range</th>
<th>Age Group</th>
<th>Change Post Status</th>
</tr>
</thead>
<tbody>
<?php
$desg_query="SELECT personnel.poststat, remarks.remarks_cd, remarks.remarks, personnel.off_desg, qualification.qualification, COUNT(personnel.personcd) AS pp_count, MAX(personnel.basic_pay) AS max_basic_pay, MIN(personnel.basic_pay) AS min_basic_pay, MAX(personnel.grade_pay) AS max_grade_pay, MIN(personnel.grade_pay) AS min_grade_pay, MIN(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(personnel.dateofbirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(personnel.dateofbirth, '00-%m-%d'))) AS min_age, MAX(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(personnel.dateofbirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(personnel.dateofbirth, '00-%m-%d'))) AS max_age FROM ((personnel INNER JOIN office ON personnel.officecd=office.officecd) INNER JOIN qualification ON qualification.qualificationcd=personnel.qualificationcd) INNER JOIN remarks ON personnel.remarks=remarks.remarks_cd WHERE personnel.gender='M' GROUP BY personnel.poststat, remarks.remarks, personnel.off_desg,  qualification.qualification ORDER BY personnel.off_desg";
$desg_result=$mysqli->query($desg_query);

$desg=array();
while($desg_row = $desg_result->fetch_assoc()){
	$desg[]=array("PostStat"=>$desg_row['poststat'],"RemarksCode"=>$desg_row['remarks_cd'],"Remarks"=>$desg_row['remarks'],"Designation"=>$desg_row['off_desg'],"Qualification"=>$desg_row['qualification'],"PPCount"=>$desg_row['pp_count'],"MaxBasicPay"=>$desg_row['max_basic_pay'],"MinBasicPay"=>$desg_row['min_basic_pay'],"MaxGradePay"=>$desg_row['max_grade_pay'],"MinGradePay"=>$desg_row['min_grade_pay'],"MinAge"=>$desg_row['min_age'],"MaxAge"=>$desg_row['max_age']);
}
$desg_result->close();

$total_desg_post=0;
for($i = 0 ; $i < count($desg) ; $i++){
	$total_desg_post+=$desg[$i]['PPCount'];
?>
<tr>
<td class="from_post_stat"><?php echo $desg[$i]['PostStat'] != '' ? $desg[$i]['PostStat'] : 'NA' ; ?></td>
<td class="remarks"><?php echo $desg[$i]['RemarksCode'].'-'.$desg[$i]['Remarks']; ?></td>
<td class="designation"><?php echo $desg[$i]['Designation']; ?></td>
<td class="qualification"><?php echo $desg[$i]['Qualification']; ?></td>
<td><?php echo $desg[$i]['PPCount']; ?></td>
<td class="basic_pay"><?php echo $desg[$i]['MinBasicPay'].' - '.$desg[$i]['MaxBasicPay']; ?></td>
<td class="grade_pay"><?php echo $desg[$i]['MinGradePay'].' - '.$desg[$i]['MaxGradePay']; ?></td>
<td><?php echo $desg[$i]['MinAge'].' - '.$desg[$i]['MaxAge']; ?></td>
<td class="change-btn-cell">
<button class="btn btn-sm btn-primary pull-right change-btn">Click Here</button>
</td>
</tr>
<?php
}
?>
</tbody>
</table>
<!-- Modal -->
<div id="change-post-status-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-green">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Change Post Status</h3>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
		<thead>
        	<tr class="bg-aqua">
            	<th>Parameter Name</th>
                <th>Parameter Value</th>
            </tr>
        </thead>
        <tbody>
        	<tr>
            	<td>Subdivision</td>
                <td>All</td>
            </tr>
            <tr>
            	<td>Office Category</td>
                <td>All</td>
            </tr>
            <tr>
            	<td>Office</td>
                <td>All</td>
            </tr>
            <tr>
            	<td>Basic Pay</td>
                <td id="basic_pay">&nbsp;</td>
            </tr>
            <tr>
            	<td>Grade Pay</td>
                <td id="grade_pay">&nbsp;</td>
            </tr>
            <tr>
            	<td>Qualification</td>
                <td id="qualification">&nbsp;</td>
            </tr>
            <tr>
            	<td>Designation</td>
                <td id="designation">&nbsp;</td>
            </tr>
            <tr>
            	<td>Gender</td>
                <td>
                	<select id="gender" class="select2" style="width: 100%;">
                        <option value="ALL">ALL</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </td>
            </tr>
            <tr>
            	<td>Age</td>
                <td>Less Than 60</td>
            </tr>
            <tr>
            	<td>Remarks</td>
                <td id="remarks">&nbsp;</td>
            </tr>
            <tr>
            	<td>Existing Post Status</td>
                <td id="from_post_stat">&nbsp;</td>
            </tr>
            <tr>
            	<td>New Post Status</td>
                <td><?php echo $new_post_stat; ?></td>
            </tr>
        </tbody>
        </table>
      </div>
      <div class="modal-footer" style="background-color: #f9f9f9">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="CreateApplyRuleBtn">Create and Apply Rule</button>
      </div>
    </div>

  </div>
</div>
<script>
//$('.select2').select2();
var row;
var table=$('#desg_post_table').DataTable({
	"paging": false,
	"lengthChange": true,
	"searching": true,
	"ordering": false,
	"info": true,
	"autoWidth": true,
});

$('.poststat').click(function(e) {
    e.preventDefault();
	var post_stat=$(this).attr('href').toString();

	table
        .column( 0 )
        .search( post_stat )
        .draw();

});

$('.change-btn').click(function(e) {
    e.preventDefault();
	row=$(this).closest('tr');
	var basic_pay=row.find('.basic_pay').html().toString();
	var grade_pay=row.find('.grade_pay').html().toString();
	var designation=row.find('.designation').html().toString();
	var qualification=row.find('.qualification').html().toString();
	var remarks=row.find('.remarks').html().toString();

	var from_post_stat=row.find('.from_post_stat').html().toString();

	$('#basic_pay').html(basic_pay);
	$('#grade_pay').html(grade_pay);
	$('#designation').html(designation);
	$('#qualification').html(qualification);
	$('#remarks').html(remarks);
	$('#from_post_stat').html(from_post_stat);

	$('#change-post-status-modal').modal();
});

$('#CreateApplyRuleBtn').click(function(e) {
    e.preventDefault();
	row.find('.change-btn').hide();
	row.find('.change-btn-cell').append("<i class='fa fa-spinner fa-spin text-orange'></i>");

	var basic_pay=$('#basic_pay').html().toString();
	var grade_pay=$('#grade_pay').html().toString();
	var designation=$('#designation').html().toString();
	var qualification=$('#qualification').html().toString();
	var remarks=$('#remarks').html().toString();
	remarks=remarks.split('-');
	var from_post_stat=$('#from_post_stat').html().toString();
	var gender=$('#gender').val();
	var to_post_stat=$('#new_post_stat').val();

	var result;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'pp_category/create_adhoc_rule.php',
		type: 'POST',
		data: {
				BasicPay: basic_pay,
				GradePay: grade_pay,
				Designation: designation,
				Qualification: qualification,
				Remarks: remarks[0],
				FromPostStat: from_post_stat,
				Gender: gender,
				ToPostStat: to_post_stat
			  },
		success: function(data) {
			result=JSON.parse(JSON.stringify(data));
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	if(result.Status == "Success"){
		$.ajax({
			mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
			url: 'pp_category/grant_rule.php',
			type: 'POST',
			data: {
					RuleID: result.RuleID
				  },
			success: function(data) {
				result=JSON.parse(JSON.stringify(data));
				if(result.Status > 0){
					row.find('.change-btn-cell').html("Rule Applied for Records: "+result.Status);
				}
				else{
					row.find('.change-btn-cell').html("Rule Created with no Records Affected");
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert(errorThrown);
			},
			dataType: "json",
			async: false
		});
	}
	else{
		row.find('.change-btn-cell').html("Rule Creation Error: "+result.Status);
	}
});
</script>
