<?php
session_start();
require("../config/config.php");
?>
  <div class="row">

    <div class="col-sm-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Training Taken and No PP
                </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->



        <div class="box-body">


          <table class="table table-bordered table-hover table-condensed small" id="pp2_table">
            <?php
//$user_id=$_SESSION['UserID'];

$subdiv_names=array();
$subdiv_query=$mysqli->prepare("SELECT subdivisions.id, subdivisions.name, block_munis.id, block_munis.name, COUNT(offices.id) FROM ((subdivisions INNER JOIN block_munis ON subdivisions.id=block_munis.subdivision_id) INNER JOIN offices ON offices.block_muni_id = block_munis.id) INNER JOIN training_yes_office_nopp ON offices.id = training_yes_office_nopp.office_id GROUP BY subdivisions.id, subdivisions.name, block_munis.id, block_munis.name ORDER BY subdivisions.id, block_munis.id") or die($mysqli->error);
$subdiv_query->execute() or die($subdiv_query->error);
$subdiv_query->bind_result($subdiv_code,$subdiv_name,$block_muni_code,$block_muni_name,$office_count) or die($subdiv_query->error);
while($subdiv_query->fetch()){
	$subdiv_names[]=array("SubDivCode"=>$subdiv_code,"SubDivName"=>$subdiv_name,"BlockMuniCode"=>$block_muni_code,"BlockMuniName"=>$block_muni_name,"OfficeCount"=>$office_count);
}
$subdiv_query->close();
?>
              <thead>
                <tr class="bg-teal-gradient">
                  <th>Sl No</th>
                  <th>Subdivision</th>
                  <th>Block/Municipality</th>
                  <th>Office Total</th>
                  <th>Letter - 10 PPCELL (Dist) 24122018</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total_office = 0;
	for($i=0;$i<count($subdiv_names);$i++){
?>
                  <tr>
                    <td>
                      <?php echo $i+1; ?>
                    </td>

                    <td><?php echo "<a href='report/print_office_progress.php?opt=subdiv&code=".$subdiv_names[$i]['SubDivCode']."' target='_blank'>".$subdiv_names[$i]['SubDivName']."</a>"; ?></td>
                    <td><?php echo "<a href='report/print_office_progress.php?opt=blockmuni&code=".$subdiv_names[$i]['BlockMuniCode']."' target='_blank'>".$subdiv_names[$i]['BlockMuniName']."</a>"; ?></td>
                    <td><?php echo $subdiv_names[$i]['OfficeCount']; ?></td>
                    
                    <td><?php echo "<a href='office_letter_10_ppcelldist_24122018.php?opt=blockmuni&code=".$subdiv_names[$i]['BlockMuniCode']."' target='_blank' class='text-red'><i class='fa fa-print'></i> print</a>"; ?></td>

                    <?php
                      $total_office += $subdiv_names[$i]['OfficeCount'];
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
