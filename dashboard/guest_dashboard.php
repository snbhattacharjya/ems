<script>
$('.ajax_link').click(function (e) {
		
		e.preventDefault();
			
		var url = $(this).attr('href');
			
		$('#content').load(url);
			
});
</script>
<!--Start Breadcrumb-->


<div class="row">
	<div id="breadcrumb" class="col-xs-12">
		<ol class="breadcrumb">
			<li><a href="dashboard/guest_dashboard.php" class="ajax_link">Home</a></li>
			<li><a href="#">Dashboard</a></li>
		</ol>
	</div>
</div>
<!--End Breadcrumb-->
<!--Start Dashboard 1-->
<div id="dashboard-header" class="row">
<div class="col-xs-10 col-sm-10">
		<h3>Guest Dashboard</h3>
</div>
</div>
