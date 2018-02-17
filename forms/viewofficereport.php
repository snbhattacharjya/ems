<script type="text/javascript">
$('document').ready(function() {
	$.getScript('http://www.google.com/jsapi?autoload={%22modules%22%3A[{%22name%22%3A%22visualization%22%2C%22version%22%3A%221%22%2C%22packages%22%3A[%22corechart%22%2C%22geochart%22]%2C%22callback%22%3A%22LoadGenderDetailsOfficeReport%22}]}');
	
	$.getScript('http://www.google.com/jsapi?autoload={%22modules%22%3A[{%22name%22%3A%22visualization%22%2C%22version%22%3A%221%22%2C%22packages%22%3A[%22corechart%22%2C%22geochart%22]%2C%22callback%22%3A%22LoadGenderDetailsOfficeMorrisReport%22}]}');
	// This need for correct resize charts, when box open or drag
	var graphxChartsResize1;
	var graphxChartsResize2;
	$(".box").resize(function(event){
		event.preventDefault();
		clearTimeout(graphxChartsResize1);
		clearTimeout(graphxChartsResize2);
		graphxChartsResize1 = setTimeout(LoadGenderDetailsOfficeReport, 500);
	    graphxChartsResize2 = setTimeout(LoadGenderDetailsOfficeMorrisReport,500);
	});
	// Add Drag-n-Drop action for .box
	WinMove();
});
</script>
<div class="row">
	<div id="breadcrumb" class="col-md-12">
		<ul class="breadcrumb">
			<li><a href="index.html">Dashboard</a></li>
			<li><a href="#">Reports</a></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-search"></i>
					<span>Displaying Male and Female staffs of Office(Pie Chart)</span>
				</div>
				<div class="box-icons"
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content">
				<div id="office-emp-gender-piechart" style="height: 200px;"></div>
			</div>
             <img src="img/devoops_getdata.gif" class="devoops-getdata" alt="preloader"/>
		</div>
	</div>
    <div class="col-xs-12 col-sm-6">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-search"></i>
					<span>Displaying Male and Female staffs of Office(Morris Chart)</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content">
				<div id="office-emp-gender-morrischart" style="height: 200px;"></div>
			</div>
		</div>
	</div>
</div>
</div>

	