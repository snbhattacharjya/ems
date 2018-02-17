// JavaScript Document
//Categorywise Office details for X-chart
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
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/categorywiseoffice_details.php',
		type: 'POST',
		
		success: function(data) {
			var retObj=JSON.parse(JSON.stringify(data));
			centralgovt=retObj[0].OfficeCode;
			stategovt=retObj[1].OfficeCode;
			centralgovtundertaking=retObj[2].OfficeCode;
			stategovtundertaking=retObj[3].OfficeCode;
			localbodies=retObj[4].OfficeCode;
			govtaidedorg=retObj[5].OfficeCode;
			autonomousbody=retObj[6].OfficeCode;
			other=retObj[7].OfficeCode;	
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	var data = {
		"xScale": "ordinal",
	    "yScale": "linear",
	    "main": [
		{
		"className": ".xchart-class-2",
		"data": [
			{
			  "x": "Central Govt.",
			  "y": centralgovt
			},
			{
			  "x": "StateGovt",
			  "y": stategovt
			},
			{
			  "x": "CentralGovtUndertaking",
			  "y": centralgovtundertaking
			},
			{
			  "x": "StateGovtUndertaking",
			  "y": stategovtundertaking
			},
			{
			  "x": "LocalBodies",
			  "y": localbodies
			},
			{
			  "x": "GovtAidedOrg",
			  "y": govtaidedorg
			},
			{
			  "x": "AutonomousBody",
			  "y": 20
			},
			{
			  "x": "Others",
			  "y": 50
			}
		]
		}
		]
	};
		var myChart = new xChart('bar',data,'#xchart-2');
}



////Categorywise Office details for Pie-chart

function LoadCategoryWiseOfficeDetailsReport()
{
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/categorywiseoffice_details.php',
		type: 'POST',
		success: function(data) {
		    var retObj=JSON.parse(JSON.stringify(data));
			centralgovt=retObj[0].OfficeCode;
			stategovt=retObj[1].OfficeCode;
			centralgovtundertaking=retObj[2].OfficeCode;
			stategovtundertaking=retObj[3].OfficeCode;
			localbodies=retObj[4].OfficeCode;
			govtaidedorg=retObj[5].OfficeCode;
			autonomousbody=retObj[6].OfficeCode;
			other=retObj[7].OfficeCode;		
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	
	var chart_data = [
		['Height','Width'],
		['CentralGovt',centralgovt],
		['CentralGovtUndertaking',centralgovtundertaking],
		['StateGovtUndertaking',stategovtundertaking],
		['LocalBodies',localbodies],
		['GovtAidedOrg',govtaidedorg],
		['AutonomousBody',20],
		['Others',50],
		
	];
	var chart_options = {
		title: 'Categorywise Office Report',
		backgroundColor: '#fcfcfc'
	};
	var chart_element = 'category-wise-office-piechart';
	var chart_type = google.visualization.PieChart;
	drawGoogleChart(chart_data, chart_options, chart_element, chart_type);
}