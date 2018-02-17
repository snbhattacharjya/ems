<div class="row">
	<div id="breadcrumb" class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.html">Dashboard</a></li>
			<li><a href="#">Charts</a></li>
			<li><a href="#">xCharts</a></li>
		</ol>
	</div>
</div>
<script>
function LoadXChartScript(callback){
	function LoadXChart(){
		$.getScript('plugins/xcharts/xcharts.min.js', callback);
	}
	function LoadD3Script(){
		if (!$.fn.d3){
			$.getScript('plugins/d3/d3.v3.min.js', LoadXChart)
		}
		else {
			LoadXChart();
		}
	}
	if (!$.fn.xcharts){
		LoadD3Script();
	}
	else {
		if (callback && typeof(callback) === "function") {
			callback();
		}
	}
}
function xGraph2(){
	var centralgovt;
	var stategovt;
	var centralgovtundertaking;
	var stategovtundertaking;
	var localbodies;
	var govtaidedorg;
	var autonomousbody;
	var other;
	var subdiv;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/admincategorywiseoffice_details.php',
		type: 'POST',
		
		success: function(data) {
			var retObj=JSON.parse(JSON.stringify(data));
			subdiv=retObj[0].subdivisioncd;
			for(var i=0;i<retObj.length;i++)
			{
			  if(retObj[i].subdivisioncd==subdiv)
			  {
				
				centralgovt=retObj[i].OfficeCode;
				stategovt=retObj[i].OfficeCode;
				centralgovtundertaking=retObj[i].OfficeCode;
				stategovtundertaking=retObj[i].OfficeCode;
				localbodies=retObj[i].OfficeCode;
				govtaidedorg=retObj[i].OfficeCode;
				autonomousbody=retObj[i].OfficeCode;
				other=retObj[i].OfficeCode;
				LoadAdminReport();
    }//end of if statement
	 else
	     {
		 subdiv=subdiv+1;
		}//end of else statement
	}//end of for loop
},//end of success function
	error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});//end of ajax
}//end of X-Graph2()
</script>
<script type="text/javascript">
function DrawAllxCharts(){
	xGraph2();
}
$(document).ready(function() {
	// Load required scripts and callback to draw
	LoadXChartScript(DrawAllxCharts);
	// Required for correctly resize charts, when boxes expand
	var graphxChartsResize;
	$(".box").resize(function(event){
		event.preventDefault();
		clearTimeout(graphxChartsResize);
		graphxChartsResize = setTimeout(DrawAllxCharts, 500);
	});
	WinMove();
});
</script>