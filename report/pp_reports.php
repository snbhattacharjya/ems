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
$subdiv_query=$mysqli->prepare("SELECT subdivision.subdivisioncd, subdivision.subdivision, block_muni.blockminicd, block_muni.blockmuni, COUNT(office.officecd), COUNT(CASE DATE_FORMAT(office.posted_date,'%Y') WHEN 2018 THEN 1 END), SUM(CASE DATE_FORMAT(office.posted_date,'%Y') WHEN 2018 THEN office.tot_staff END), SUM(CASE DATE_FORMAT(office.posted_date,'%Y') WHEN 2018 THEN office.male_staff END), SUM(CASE DATE_FORMAT(office.posted_date,'%Y') WHEN 2018 THEN office.female_staff END) FROM (subdivision INNER JOIN block_muni ON subdivision.subdivisioncd=block_muni.subdivisioncd) INNER JOIN office ON office.blockormuni_cd = block_muni.blockminicd GROUP BY subdivision.subdivisioncd, subdivision.subdivision, block_muni.blockminicd, block_muni.blockmuni ORDER BY subdivision.subdivisioncd") or die($mysqli->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($subdiv_code,$subdiv_name,$block_muni_code,$block_muni_name,$office_count,$office_updated,$total_staff,$male_staff,$female_staff) or die($subdiv_query->error);
while($subdiv_query->fetch()){
	$subdiv_names[]=array("SubDivCode"=>$subdiv_code,"SubDivName"=>$subdiv_name,"BlockMuniCode"=>$block_muni_code,"BlockMuniName"=>$block_muni_name,"OfficeCount"=>$office_count,"OfficeUpdated"=>$office_updated,"TotalStaff"=>$total_staff,"MaleStaff"=>$male_staff,"FemaleStaff"=>$female_staff);
}
$subdiv_query->close();
?>
              <thead>
                <tr class="bg-teal-gradient">
                  <th>Sl No</th>
                  <th>Subdivision</th>
                  <th>Block/Municipality</th>
                  <th>Office Total</th>
                  <th>Office Updated</th>
                  <th>Progress</th>
                  <th>Total Staff PP1</th>
                  <th>Male Staff PP1</th>
                  <th>Female Staff PP1</th>
                  <th>PP2 Letter</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total_office = 0;
                $total_office_updated = 0;
                $total_staff = 0;
                $total_male = 0;
                $total_female = 0;
	for($i=0;$i<count($subdiv_names);$i++){
?>
                  <tr>
                    <td>
                      <?php echo $i+1; ?>
                    </td>

                    <td><?php echo "<a href='report/print_office_progress.php?opt=subdiv&code=".$subdiv_names[$i]['SubDivCode']."' target='_blank'>".$subdiv_names[$i]['SubDivName']."</a>"; ?></td>
                    <td><?php echo "<a href='report/print_office_progress.php?opt=blockmuni&code=".$subdiv_names[$i]['BlockMuniCode']."' target='_blank'>".$subdiv_names[$i]['BlockMuniName']."</a>"; ?></td>
                    <td><?php echo $subdiv_names[$i]['OfficeCount']; ?></td>
                    <td><?php echo $subdiv_names[$i]['OfficeUpdated']; ?></td>
                    <td><?php echo round($subdiv_names[$i]['OfficeUpdated']/$subdiv_names[$i]['OfficeCount']*100).'%'; ?></td>
                    <td><?php echo $subdiv_names[$i]['TotalStaff']; ?></td>
                    <td><?php echo $subdiv_names[$i]['MaleStaff']; ?></td>
                    <td><?php echo $subdiv_names[$i]['FemaleStaff']; ?></td>
                    <td><?php echo "<a href='report/office_pp2_letter_print.php?opt=blockmuni&code=".$subdiv_names[$i]['BlockMuniCode']."' target='_blank' class='text-red'><i class='fa fa-print'></i> print</a>"; ?></td>
                    <?php
                      $total_office += $subdiv_names[$i]['OfficeCount'];
                      $total_office_updated += $subdiv_names[$i]['OfficeUpdated'];
                      $total_staff += $subdiv_names[$i]['TotalStaff'];
                      $total_male += $subdiv_names[$i]['MaleStaff'];
                      $total_female += $subdiv_names[$i]['FemaleStaff'];
                    ?>
                  </tr>
                  <?php
}
?>
              </tbody>
              <tfoot>
                <tr class="bg-danger">
                  <th colspan="3">Total</th>
                  <th><?php echo $total_office; ?></th>
                  <th><?php echo $total_office_updated; ?></th>
                  <th><?php echo round($total_office_updated/$total_office*100).'%'; ?></th>
                  <th><?php echo $total_staff; ?></th>
                  <th><?php echo $total_male; ?></th>
                  <th><?php echo $total_female; ?></th>
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
