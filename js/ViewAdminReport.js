// JavaScript Document
LoadAdminReport()
{
	var chart1=document.getElementById("Chart 1").innerHTML;
	chart1="<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-search"></i>
					<span>Catagorywise Office(X-Chart)</span>
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
				<div id="xchart-1" style="height: 200px; width: 100%;"></div>
			</div>
		</div>
	</div>";
	
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