<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End

?>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<!-- <h4 class="page-title">Welcome...</h4> -->
					</div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div id="chartContainer" style="height: 370px; width: 100%;"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="card">
						<div class="card-body">
							<div id="gatewaychartContainer" style="height: 370px; width: 100%;"></div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<div id="equipmentchartContainer" style="height: 370px; width: 100%;"></div>
						</div>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
		<!-- container-fluid -->
		
	</div>
	
	<!-- content -->
	
	<?php 
// echo view('cpanel-layout/action_loader');
	echo view('cpanel-layout/footer');
	?>
	<script src="<?= base_url();?>/assets/canvasjs/canvasjs.min.js"></script>

	<script>
		window.onload = function () {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				theme: "dark2",
				title:{
					text: "Daily Staff Wise Report"
				},	
				axisY: {
					title: "Number of Task",
					titleFontColor: "#4F81BC",
					lineColor: "#4F81BC",
					labelFontColor: "#4F81BC",
					tickColor: "#4F81BC"
				},	
				toolTip: {
					shared: true
				},
				legend: {
					cursor:"pointer",
					itemclick: toggleDataSeries
				},
				data: [

				{
					type: "column",
					name: "schedule",
					legendText: "Schedule",
					showInLegend: true, 
					dataPoints:[
			// { label: "a", y: 266.21 },
						<?php
						foreach ($dailyStaffWise['schedule'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['schedule'][$key]['username'].'", y: '.$dailyStaffWise['schedule'][$key]['count'].' },';
						}
						?>

						]
				},
				{
					type: "column",
					name: "travelling",
					legendText: "Travelling",
					showInLegend: true, 
					dataPoints:[
			// { label: "a", y: 266.21 },
						<?php
						foreach ($dailyStaffWise['travelling'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['travelling'][$key]['username'].'", y: '.$dailyStaffWise['travelling'][$key]['count'].' },';
						}
						?>

						]
				},
				{
					type: "column",
					name: "on site",
					legendText: "On Site",
					showInLegend: true, 
					dataPoints:[
			// { label: "a", y: 266.21 },
						<?php
						foreach ($dailyStaffWise['on site'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['on site'][$key]['username'].'", y: '.$dailyStaffWise['on site'][$key]['count'].' },';
						}
						?>

						]
				},
				{
					type: "column",
					name: "installed",
					legendText: "Installed",
					showInLegend: true, 
					dataPoints:[
			// { label: "a", y: 266.21 },
						<?php
						foreach ($dailyStaffWise['complete'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['complete'][$key]['username'].'", y: '.$dailyStaffWise['complete'][$key]['count'].' },';
						}
						?>

						]
				},
				{
					type: "column",
					name: "return",
					legendText: "Return",
					showInLegend: true, 
					dataPoints:[
			// { label: "a", y: 266.21 },
						<?php
						foreach ($dailyStaffWise['reject'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['reject'][$key]['username'].'", y: '.$dailyStaffWise['reject'][$key]['count'].' },';
						}
						?>

						]
				},
				{
					type: "column",
					name: "commission",
					legendText: "Commission",
					showInLegend: true, 
					dataPoints:[
			// { label: "a", y: 266.21 },
						<?php
						foreach ($dailyStaffWise['commission'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['commission'][$key]['username'].'", y: '.$dailyStaffWise['commission'][$key]['count'].' },';
						}
						?>

						]
				},

				]
			});
			chart.render();

			function toggleDataSeries(e) {
				if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
					e.dataSeries.visible = false;
				}
				else {
					e.dataSeries.visible = true;
				}
				chart.render();
			}

			//////////////////////////////////////////////////////////////////////////////////////////


			var chart2 = new CanvasJS.Chart("gatewaychartContainer", {
	theme: "dark2", // "light1", "light2", "dark1", "dark2"
	exportEnabled: true,
	animationEnabled: true,
	title: {
		text: "Gateway Report"
	},
	data: [{
		type: "doughnut",
		startAngle: 25,
		toolTipContent: "<b>{label}</b>: {y}",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - {y}",
		dataPoints: [
			// { y: 51.08, label: "In Stock",exploded: true },
			<?php
			foreach ($gatewayReport as $key => $value) {
				echo '{ y: '.$gatewayReport[$key]['count'].', label: "'.$gatewayReport[$key]['status'].'",exploded: true },';
			}
			?>
			]
	}]
});
			chart2.render();

		// }


		///////////////////////////////////////////////////////////////////////

// window.onload = function () {
	
var chart3 = new CanvasJS.Chart("equipmentchartContainer", {
	animationEnabled: true,
	theme: "dark2", // "light1", "light2", "dark1", "dark2"
	
	title:{
		text:"Equipment Stock"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: "Stock by UOM"
	},
	data: [{
		type: "bar",
		name: "companies",
		axisYType: "secondary",
		color: "#014D65",
		dataPoints: [
			// { y: 3, label: "Sweden" },
			<?php
			foreach ($equipmentReport as $key => $value) {
				echo '{ y: '.$value['stock'].', label: "'.$value['name'].'"},';
			}
			?>
		]
	}]
});
chart3.render();

}

	</script>

	