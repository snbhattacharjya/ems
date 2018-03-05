<script>
  $(document).ready(function(e) {
		show_pp1_number('OFFICE');
    show_number_of_emp('OFFICE');
    show_number_of_male_emp('OFFICE');
    show_number_of_female_emp('OFFICE');
  });
</script>
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-blue">
      <div class="inner">
        <h3 id="pp1_count"></h3>
        <p>Number Of Employee in Office (PP1)</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <span class="small-box-footer"><i class="fa fa-star"></i>&nbsp;&nbsp;&nbsp;Till date&nbsp;&nbsp;&nbsp;<i class="fa fa-star"></i></span>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3 id="no_emp"></h3>
        <p>Number Of Employee Registered</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <span class="small-box-footer"><i class="fa fa-star"></i>&nbsp;&nbsp;&nbsp;Till date&nbsp;&nbsp;&nbsp;<i class="fa fa-star"></i></span>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3 id="no_male_emp"></h3>
        <p>Male Employees Registered</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <span class="small-box-footer"><i class="fa fa-star"></i>&nbsp;&nbsp;&nbsp;Till date&nbsp;&nbsp;&nbsp;<i class="fa fa-star"></i></span>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3 id="no_female_emp"></h3>
        <p>Female Employees Registered</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <span class="small-box-footer"><i class="fa fa-star"></i>&nbsp;&nbsp;&nbsp;Till date&nbsp;&nbsp;&nbsp;<i class="fa fa-star"></i></span>
    </div>
  </div>
  <!-- ./col -->
</div>
<div class="callout callout-success">
  <h3><i class="fa fa-star"></i>&nbsp;&nbsp;&nbsp;&nbsp;Please do not forget Tick the Declaration after completion of all your Employee Entry</h3></div>
  <div class="callout callout-info">
    <h3><i class="fa fa-star"></i>&nbsp;&nbsp;&nbsp;&nbsp;As per letter with  Memo No. 01(1600)/PPCELL Dated 23.02.2018, please fill up the office details (PP1). For employee details (PP2), you will receive a separate communication shortly.</h3></div>


<!-- Modal -->
<div id="pageModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure to submit?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="yes">Ok</button>
        <button type="button" class="btn btn-default" data-dismiss="modal" id="no">Cancel</button>
      </div>
    </div>

  </div>
</div>
