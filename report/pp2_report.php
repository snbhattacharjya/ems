<?php
session_start();
require("../config/config.php");
?>
  <div class="row">

    <div class="col-sm-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Polling Personnel Progress Report
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

$subdiv_names=array();
$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, block_muni.blockminicd, block_muni.blockmuni, COUNT(CASE DATE_FORMAT(personnel.posted_date,'%Y') WHEN 2018 THEN 1 END) FROM ((subdivision INNER JOIN block_muni ON subdivision.subdivisioncd=block_muni.subdivisioncd) INNER JOIN office ON office.blockormuni_cd = block_muni.blockminicd) INNER JOIN personnel ON office.officecd = personnel.officecd GROUP BY subdivision.subdivisioncd, subdivision.subdivision, block_muni.blockminicd, block_muni.blockmuni ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($subdiv_code,$subdiv_name,$block_muni_code,$block_muni_name,$pp2_count) or die($subdiv_query->error);
while($subdiv_query->fetch()){
	$subdiv_names[]=array("SubDivCode"=>$subdiv_code,"SubDivName"=>$subdiv_name,"BlockMuniCode"=>$block_muni_code,"BlockMuniName"=>$block_muni_name,"PP2Count"=>$pp2_count);
}
$subdiv_query->close();
?>
              <thead>
                <tr class="bg-teal-gradient">
                  <th>Sl No</th>
                  <th>Subdivision</th>
                  <th>Block/Municipality</th>
                  <th>PP2 Updated</th>
                  <th>Remarks Report</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total_pp1 = 0;
                $total_pp2 = 0;
	for($i=0;$i<count($subdiv_names);$i++){
?>
                  <tr>
                    <td>
                      <?php echo $i+1; ?>
                    </td>

                    <td><?php echo "<a href='report/print_office_remarks_progress.php?opt=subdiv&code=".$subdiv_names[$i]['SubDivCode']."' target='_blank'>".$subdiv_names[$i]['SubDivName']."</a>"; ?></td>
                    <td><?php echo "<a href='report/print_office_remarks_progress.php?opt=blockmuni&code=".$subdiv_names[$i]['BlockMuniCode']."' target='_blank'>".$subdiv_names[$i]['BlockMuniName']."</a>"; ?></td>
                    <td><?php echo $subdiv_names[$i]['PP2Count']; ?></td>
                    <td><?php echo "<a href='report/office_remarks_detail_print.php?opt=blockmuni&code=".$subdiv_names[$i]['BlockMuniCode']."' target='_blank' class='text-red'><i class='fa fa-print'></i> print</a>"; ?></td>
                    <?php
                      $total_pp2 += $subdiv_names[$i]['PP2Count'];
                    ?>
                  </tr>
                  <?php
}
?>
              </tbody>
              <tfoot>
                <tr class="bg-danger">
                  <th colspan="3">Total</th>
                  <th><?php echo $total_pp2; ?></th>
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
