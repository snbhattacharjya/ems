<?php
session_start();
require("../config/config.php");
?>
<script>

</script>
<div class="row">

    <div class="col-sm-12">
    	<div class="box box-info">
            <div class="box-header with-border">
            	<h3 class="box-title text-red"><strong>Apply Rule for PP Post Status</strong></h3>              
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                          </div>
            </div><!-- /.box-header -->



	<div class="box-body">

            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-app" id="analyzeRuleBtn">
                        <i class="fa fa-refresh text-red icon"></i> Analyze Rules
                    </a>
                    <a class="btn btn-app" id="applyRuleBtn">
                        <i class="fa fa-check-square text-green icon"></i> Apply Rules
                    </a>
                </div>
            </div><!-- /.box-header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success" style="display: none" id="report_panel">
                        <div class="panel-heading" id="report_result">
                            <label class="pull-left">Progress: </label> <span id="progress"></span>, 
                            <label>Records Affected: </label> <span id="records"></span>
                            <span class="pull-right">Hide</span>
                        </div>
                    </div>
                </div>
            </div>
<table class="table table-bordered table-datatable table-condensed" id="rule_table">
<thead>
<tr class="bg-maroon-gradient">
<th>Rule ID</th>
<th>From Post Status</th>
<th>To Post Status</th>
<th>Rule Definition</th>
<th>Query</th>
<th>Apply Rule</th>
<th>Rule Application Details</th>
</tr>
</thead>
<tbody>
<?php
$rule_query="SELECT RuleID, PostStatFrom, PostStatTo, Subdivision, OfficeCategory, Office, BasicPay, GradePay, Qualification, NotQualification, Designation, NotDesignation, Remarks, NotRemarks, Gender, Age, RecordsAffected, AppliedDate, RecordsRevoked, RevokedDate FROM pp_post_rules ORDER BY RuleID";

$rule_result=mysql_query($rule_query,$DBLink) or die(mysql_error());

$count=0;

while($res=mysql_fetch_assoc($rule_result))
{
	$count=$count+1;
?>
<tr>
<td><?php echo $res['RuleID']; ?></td>
<td><?php echo $res['PostStatFrom'];?></td>
<td><?php echo $res['PostStatTo'];?></td>
<td>
<?php
$not_qualification=$res['NotQualification'] == 0 ? 'IN ' : 'NOT IN ';
$not_designation=$res['NotDesignation'] == 0 ? 'IN ' : 'NOT IN ';
$not_remarks=$res['NotRemarks'] == 0 ? 'IN ' : 'NOT IN ';

echo '<strong>Subdivision: </strong>'.$res['Subdivision'].'<br>'.
     '<strong>Office Category: </strong>'.$res['OfficeCategory'].'<br>'.
	 '<strong>Office: </strong>'.$res['Office'].'<br>'.
	 '<strong>Basic Pay: </strong>'.$res['BasicPay'].'<br>'.
	 '<strong>Grade Pay: </strong>'.$res['GradePay'].'<br>'.
	 '<strong>Qualification: </strong>'.$not_qualification.$res['Qualification'].'<br>'.
	 '<strong>Designation: </strong>'.$not_designation.$res['Designation'].'<br>'.
	 '<strong>Remarks: </strong>'.$not_remarks.$res['Remarks'].'<br>'.
	 '<strong>Gender: </strong>'.$res['Gender'].'<br>'.
	 '<strong>Age: </strong>'.$res['Age'].'<br>';
?>
</td>
<td>
<div id="query_loader" hidden="">
	<i class='fa fa-spinner fa-spin text-orange'></i>
</div>
<div id="query_result" hidden=""></div>
<a href="#" class="query_rule">Query</a></td>
<td>
<a href="#" class="grant_rule" style="display:block"><i class="fa fa-check-square text-green"></i> Grant</a>
<a href="#" class="revoke_rule" style="display:block"><i class="fa fa-undo text-red"></i> Revoke</a>
<a href="#" class="shortlist_rule" style="display:block"><i class="fa fa-star text-yellow"></i> Shortlist</a>
</td>
<td>
<div id="rule_loader" hidden="">
	<i class='fa fa-spinner fa-spin text-orange'></i>
</div>
<div id="grant_result" style="display:block">
<?php
	if($res['AppliedDate'] == '0000-00-00 00:00:00'){
		echo 'Last Applied Date: NA <br>'.
		     'Records Affected: NA';
	}
	else{
		echo 'Last Applied Date: '.$res['AppliedDate'].'<br>'.
		     'Records Affected: '.$res['RecordsAffected'];
	}
?>
</div>
<div id="revoke_result" style="display:block">
<?php
	if($res['RevokedDate'] == '0000-00-00 00:00:00'){
		echo 'Last Revoked Date: NA <br>'.
		     'Records Revoked: NA';
	}
	else{
		echo 'Last Revoked Date: '.$res['RevokedDate'].'<br>'.
		     'Records Revoked: '.$res['RecordsRevoked'];
	}
?>
</div>
</td>
</tr>
<?php
	}
?>
</tbody>
</table>
			</div><!-- /.box-body -->
       	</div><!-- /.box -->
  	</div><!-- /.col -->
</div><!-- /.row -->   
<script>
var rule_table=$('#rule_table').DataTable({
		"paging": true,
	 	"lengthChange": true,
	  	"searching": true,
	  	"ordering": true,
	  	"info": true,
	  	"autoWidth": true
		});
		
$('#rule_table tbody').on('click', 'td > a', function (e) {
	e.preventDefault();
	var select_row = $(this).closest('tr');
	var row_data = rule_table.row(select_row).data();
	var ops=$.parseHTML($(this).html());
			
	if($(this).hasClass('query_rule')){
		$(this).hide();
		$(this).parent('td').find('#query_loader').show();
		$(this).parent('td').find('#quey_result').hide();
		var result;
		$.ajax({
			mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
			url: 'pp_category/query_rule.php',
			type: 'POST',
			data: {
					RuleID: row_data[0]
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
		$(this).parent('td').find('#query_result').show().html('Record Count: '+result.Status+'<br>');
		$(this).show();
		$(this).parent('td').find('#query_loader').hide();	
	}
	else if($(this).hasClass('grant_rule')){
		$(this).parent('td').next('td').find('#rule_loader').show();
		$(this).parent('td').next('td').find('#grant_result').hide();
		var result;
		$.ajax({
			mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
			url: 'pp_category/grant_rule.php',
			type: 'POST',
			data: {
					RuleID: row_data[0]
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
		$(this).parent('td').next('td').find('#rule_loader').hide();
		$(this).parent('td').next('td').find('#grant_result').show().html('Last Applied Date: '+result.AppliedDate+'<br>Records Affected: '+result.Status);
	}
	else if($(this).hasClass('revoke_rule')){
		$(this).parent('td').next('td').find('#rule_loader').show();
		$(this).parent('td').next('td').find('#revoke_result').hide();
		var result;
		$.ajax({
			mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
			url: 'pp_category/revoke_rule.php',
			type: 'POST',
			data: {
					RuleID: row_data[0]
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
		$(this).parent('td').next('td').find('#rule_loader').hide();
		$(this).parent('td').next('td').find('#revoke_result').show().html('Revoke Date: '+result.RevokeDate+'<br>Records Revoked: '+result.Status);
	}
	else if($(this).hasClass('shortlist_rule')){
		alert('Shortlist Will be implemented Shortly');
	}
});

$('#analyzeRuleBtn').click(function(e){
    e.preventDefault();
    var table_rows;
    var row_data;
    var rule_id;
    var result;
    var progress=0;
    var records=0;
    $('#progress').html(progress+'% ');
    $('#records').html(records);
    $('#report_panel').show();
    table_rows=rule_table.rows().data();
    for(var i=0; i < table_rows.length; i++){
        row_data=table_rows.row(i).data();
        rule_id=row_data[0];
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: 'pp_category/query_rule.php',
                type: 'POST',
                data: {
                        RuleID: rule_id
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
        progress=Math.round((i+1)/table_rows.length*100);
        records+=parseInt(result.Status);
        $('#progress').html(progress+'% ');
        $('#records').html(records);
    }
});

$('#applyRuleBtn').click(function(e){
    e.preventDefault();
    var table_rows;
    var row_data;
    var rule_id;
    var result;
    var progress=0;
    var records=0;
    $('#progress').html(progress+'% ');
    $('#records').html(records);
    $('#report_panel').show();
    table_rows=rule_table.rows().data();
    for(var i=0; i < table_rows.length; i++){
        row_data=table_rows.row(i).data();
        rule_id=row_data[0];
        $.ajax({
                mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
                url: 'pp_category/grant_rule.php',
                type: 'POST',
                data: {
                        RuleID: rule_id
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
        progress=Math.round((i+1)/table_rows.length*100);
        records+=parseInt(result.Status);
        $('#progress').html(progress+'% ');
        $('#records').html(records);
    }
});
</script>