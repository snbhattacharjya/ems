// JavaScript Document
function LoadGenderDetailsOfficeReport()
{
	var ppcount;
	var percentagempp;
	var percentagefpp;
	var totppcount;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/gender_details.php',
		type: 'POST',
		success: function(data) {
			ppcount=JSON.parse(JSON.stringify(data));
			totppcount=ppcount.MalePP+ppcount.FemalePP;
			percentagempp=ppcount.MalePP/totppcount*100;
			percentagefpp=ppcount.FemalePP/totppcount*100;
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
	
	var chart_data = [
		['Height','Width'],
		['Male',percentagempp],
		['Female',percentagefpp]
		
	];
	var chart_options = {
		title: 'Office Employee Gender Report',
		backgroundColor: '#fcfcfc'
	};
	var chart_element = 'office-emp-gender-piechart';
	var chart_type = google.visualization.PieChart;
	drawGoogleChart(chart_data, chart_options, chart_element, chart_type);
}


function LoadGenderDetailsOfficeMorrisReport()
{
	var ppcount;
	var total;
	$.ajax({
		mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
		url: 'json/gender_details.php',
		type: 'POST',
		success: function(data) {
			ppcount=JSON.parse(JSON.stringify(data));	
			total=Number(ppcount.MalePP) + Number(ppcount.FemalePP);
	var chart_data = [
		{"period": "2013-10-01","Male": ppcount.MalePP, "Female": ppcount.FemalePP,"Total": total}
	];
	Morris.Bar({
		element: 'office-emp-gender-morrischart',
		data: chart_data,
		xkeys: 'period',
		ykeys: ['Male','Female','Total'],
		labels: ['Male','Female','Total']
	});
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		},
		dataType: "json",
		async: false
	});
}

function drawMorrisChart(){
	LoadGenderDetailsOfficeMorrisReport();
}
$(document).ready(function() {
	// Load required scripts and draw graphs
	LoadMorrisScripts(drawMorrisChart);
});
function LoadMorrisScripts(callback){
	function LoadMorrisScript(){
		if(!$.fn.Morris){
			$.getScript('plugins/morris/morris.min.js', callback);
		}
		else {
			if (callback && typeof(callback) === "function") {
				callback();
			}
		}
	}
	if (!$.fn.raphael){
		$.getScript('plugins/raphael/raphael-min.js', LoadMorrisScript);
	}
	else {
		LoadMorrisScript();
	}
}