<?php
session_start();
require("../config/config.php");
?>
  <div class="row">

    <div class="col-sm-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Counting Personnel Online Report
                </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->



        <div class="box-body">


          <table class="table table-bordered table-hover table-condensed small" id="pp2_table">
            <?php
$user_id=$_SESSION['UserID'];

if($user_id == 'ADMIN' || $user_id == 'ppcell_hug'){
  $subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, block_muni.blockminicd, block_muni.blockmuni, COUNT(CASE personnel.gender WHEN 'M' THEN 1 END) AS pp2_male_count FROM ((subdivision INNER JOIN block_muni ON subdivision.subdivisioncd=block_muni.subdivisioncd) INNER JOIN office ON office.blockormuni_cd = block_muni.blockminicd) INNER JOIN personnel ON office.officecd = personnel.officecd AND personnel.gender = 'M' AND personnel.remarks NOT IN ('05','91','94','96','97') AND DATE_FORMAT(personnel.posted_date,'%Y') = 2018 GROUP BY subdivision.subdivisioncd, subdivision.subdivision, block_muni.blockminicd, block_muni.blockmuni ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
}
else{
  $subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, block_muni.blockminicd, block_muni.blockmuni, COUNT(CASE personnel.gender WHEN 'M' THEN 1 END) AS pp2_male_count FROM ((subdivision INNER JOIN block_muni ON subdivision.subdivisioncd=block_muni.subdivisioncd) INNER JOIN office ON office.blockormuni_cd = block_muni.blockminicd) INNER JOIN personnel ON office.officecd = personnel.officecd AND block_muni.block_or_muni = 'B' AND personnel.gender = 'M' AND personnel.remarks NOT IN ('05','91','94','96','97') AND DATE_FORMAT(personnel.posted_date,'%Y') = 2018 GROUP BY subdivision.subdivisioncd, subdivision.subdivision, block_muni.blockminicd, block_muni.blockmuni ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
}
$subdiv_names=array();

$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($subdiv_code,$subdiv_name,$block_muni_code,$block_muni_name,$pp2_male_count) or die($subdiv_query->error);
while($subdiv_query->fetch()){
	$subdiv_names[]=array("SubDivCode"=>$subdiv_code,"SubDivName"=>$subdiv_name,"BlockMuniCode"=>$block_muni_code,"BlockMuniName"=>$block_muni_name,"PP2MaleCount"=>$pp2_male_count);
}
$subdiv_query->close();
?>
              <thead>
                <tr class="bg-teal-gradient">
                  <th>Sl No</th>
                  <th>Subdivision</th>
                  <th>Block</th>
                  <th>Personnel Count</th>
                  <th>Print Records</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total_male_pp2 = 0;
	for($i=0;$i<count($subdiv_names);$i++){
?>
                  <tr>
                    <td>
                      <?php echo $i+1; ?>
                    </td>

                    <td><?php echo $subdiv_names[$i]['SubDivName']; ?></td>
                    <td><?php echo $subdiv_names[$i]['BlockMuniName']; ?></td>
                    <td><?php echo $subdiv_names[$i]['PP2MaleCount']; ?></td>
                    <td><?php echo "<a href='pp_counting/pp_counting_block_report_print.php?opt=blockmuni&code=".$subdiv_names[$i]['BlockMuniCode']."&block_name=".$subdiv_names[$i]['BlockMuniName']."' target='_blank' class='text-red'><i class='fa fa-print'></i> print</a>"; ?></td>
                    <?php
                      $total_male_pp2 += $subdiv_names[$i]['PP2MaleCount'];
                    ?>
                  </tr>
                  <?php
}
?>
              </tbody>
              <tfoot>
                <tr class="bg-danger">
                  <th colspan="3">Total</th>
                  <th><?php echo $total_male_pp2; ?></th>
                  <th>&nbsp;</th>
                </tr>
              </tfoot>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <script>
    table = $('#pp2_table').DataTable({
      "paging": false,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  </script>
