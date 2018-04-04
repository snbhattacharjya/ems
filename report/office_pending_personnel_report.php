<?php
session_start();
require("../config/config.php");
?>
  <div class="row">

    <div class="col-sm-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Polling Personnel Pending Update Report
                </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->



        <div class="box-body">


          <table class="table table-bordered table-hover table-condensed small" id="pp2_table" border="1" cellpadding="5" cellspacing="0">
            <?php
$user_id=$_SESSION['Office'];

$emp_names=array();
$emp_query=$mysqli->prepare("SELECT personcd, officer_name, off_desg, gender FROM personnel WHERE officecd='$user_id' AND DATE_FORMAT(personnel.posted_date,'%Y') != 2018 ORDER BY personcd") or die($mysqli->error);
$emp_query->execute() or die($emp_query->error);
$emp_query->bind_result($emp_code,$emp_name,$desg,$gender) or die($emp_query->error);
while($emp_query->fetch()){
	$emp_names[]=array("EmpCode"=>$emp_code,"EmpName"=>$emp_name,"Desg"=>$desg,"Gender"=>$gender);
}
$emp_query->close();
?>
              <thead>
                <tr class="bg-teal-gradient">
                  <th>Sl No</th>
                  <th>Employee ID</th>
                  <th>Employee Name</th>
                  <th>Designation</th>
                  <th>Gender</th>
                </tr>
              </thead>
              <tbody>
                <?php
	for($i=0;$i<count($emp_names);$i++){
?>
                  <tr>
                    <td>
                      <?php echo $i+1; ?>
                    </td>

                    <td><?php echo $emp_names[$i]['EmpCode']; ?></td>
                    <td><?php echo $emp_names[$i]['EmpName']; ?></td>
                    <td><?php echo $emp_names[$i]['Desg']; ?></td>
                    <td><?php echo $emp_names[$i]['Gender']; ?></td>

                  </tr>
                  <?php
}
?>
              </tbody>

          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
