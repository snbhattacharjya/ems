<script>

	 $(document).ready(function(){
		$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/categorywiseoffice_details.php',
		type: 'POST',
		success: function(data) {
		var retObj=JSON.parse(JSON.stringify(data));
		for(var i=0;i<retObj.length;i++)
			   {
					$('#table1 tbody:last').append("<tr><td>"+retObj[i].govt+"</td> <td>"+retObj[i].govt_description+"</td> <td>"+retObj[i].OfficeCode+"</td></tr>");
			   }
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
});
</script>
<div class="row">
	<div id="breadcrumb" class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.html">Dashboard</a></li>
			<li><a href="#">Reports</a></li>
			<li><a href="#">xCharts</a></li>
		</ol>
	</div>
</div>
<div class="col-xs-12 col-sm-10">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-search"></i>
					<span>Categorywise Office Report(X-Chart)</span>
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
				<div id="xchart-2" style="height: 200px; width:100%;"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-10">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-search"></i>
					<span>Categorywise Office Report(Pie Chart)</span>
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
				<div id="category-wise-office-piechart" style="height: 200px;"></div>
			</div>
		</div>
	</div>
</div>
    
<!--Design of combined table-->
    
<div class="row">
	<div class="col-xs-12 col-sm-10">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-table"></i>
					<span>Combined Table</span>
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
            
			<div class="box-content no-padding">
				<table class="table table-striped table-bordered table-hover table-heading no-border-bottom" id='table1'>
					<thead>
						<tr>
							<th>Office Category Code</th>
							<th>Office Category Name</th>
							<th>Office Count</th>
						</tr>
					</thead>
                    <tbody>
                    </tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script language="javascript" type="text/javascript">
function DrawxChart(){
	xGraph2();
	}
	$(document).ready(function() {
	// Load required scripts and callback to draw
	$.getScript('js/CategoryWiseOffice.js');
	LoadXChartScript(DrawxChart);
	// Required for correctly resize charts, when boxes expand
	var graphxChartsResize;
	$(".box").resize(function(event){
		event.preventDefault();
		clearTimeout(graphxChartsResize);
		graphxChartsResize = setTimeout(DrawxChart, 500);
	});
	
	
	
	//Categorywise office report for piechart
	$.getScript('http://www.google.com/jsapi?autoload={%22modules%22%3A[{%22name%22%3A%22visualization%22%2C%22version%22%3A%221%22%2C%22packages%22%3A[%22corechart%22%2C%22geochart%22]%2C%22callback%22%3A%22LoadGenderDetailsOfficeReport%22}]}');
	// This need for correct resize charts, when box open or drag
	var graphxChartsResize1;
	$(".box").resize(function(event){
		event.preventDefault();
		clearTimeout(graphxChartsResize1);
		graphxChartsResize1 = setTimeout(LoadCategoryWiseOfficeDetailsReport, 500);
	});
	// Add Drag-n-Drop action for .box
	WinMove();
});
</script>
