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
			<?php if(access_crud('Profit & Loss Report','view')){ ?>
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<div id="profitChartContainer" style="height: 370px; width: 100%;"></div>
						</div>
					</div>
				</div>
			</div>
			<?php } if(access_crud('All work Orders','view')){ ?>
				<div class="row">
					<div class="col-md-8">
						<div class="card">
							<div class="card-body">
								<div id="chartContainer" style="height: 370px; width: 100%;"></div>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="card-body">
								<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<?php if(access_crud('Gateway','view')){ ?>
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
								<div id="gatewaychartContainer2" style="height: 370px; width: 100%;"></div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="row">
				<?php if(access_crud('Equipment','view')){ ?>
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div id="equipmentchartContainer" style="height: 370px; width: 100%;"></div>
							</div>
						</div>
					</div>
				<?php } ?>
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

			//////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				theme: "dark2",
				title:{
					text: "Daily Staff Wise Report",
					fontSize: 20
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
						if(!empty($dailyStaffWise)){
						foreach ($dailyStaffWise['schedule'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['schedule'][$key]['username'].'", y: '.$dailyStaffWise['schedule'][$key]['count'].' },';
						}}
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
						if(!empty($dailyStaffWise)){
						foreach ($dailyStaffWise['travelling'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['travelling'][$key]['username'].'", y: '.$dailyStaffWise['travelling'][$key]['count'].' },';
						}}
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
						if(!empty($dailyStaffWise)){
						foreach ($dailyStaffWise['on site'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['on site'][$key]['username'].'", y: '.$dailyStaffWise['on site'][$key]['count'].' },';
						}}
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
						if(!empty($dailyStaffWise)){
						foreach ($dailyStaffWise['complete'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['complete'][$key]['username'].'", y: '.$dailyStaffWise['complete'][$key]['count'].' },';
						}}
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
						if(!empty($dailyStaffWise)){
						foreach ($dailyStaffWise['reject'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['reject'][$key]['username'].'", y: '.$dailyStaffWise['reject'][$key]['count'].' },';
						}}
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
						if(!empty($dailyStaffWise)){
						foreach ($dailyStaffWise['commission'] as $key => $value) {
							echo '{ label: "'.$dailyStaffWise['commission'][$key]['username'].'", y: '.$dailyStaffWise['commission'][$key]['count'].' },';
						}}
						?>

						]
				},

				]
			});
			setTimeout(function() { 
				chart.render();
			}, 1000);

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
			///////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////


			var chart2 = new CanvasJS.Chart("gatewaychartContainer", {
	theme: "dark2", // "light1", "light2", "dark1", "dark2"
	exportEnabled: true,
	animationEnabled: true,
	title: {
		text: "Gateway Report",
		fontSize: 20
	},
	data: [{
		type: "doughnut",
		startAngle: 25,
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - {y}",
		toolTipContent: "<b>{label}:</b> {y} (#percent%)",
		dataPoints: [
			// { y: 51.08, label: "In Stock",exploded: true },
			<?php
			if(!empty($gatewayReport)){
			foreach ($gatewayReport as $key => $value) {
				echo '{ y: '.$gatewayReport[$key]['count'].', label: "'.$gatewayReport[$key]['status'].'",exploded: true },';
			}}
			?>
			]
	}]
});
			setTimeout(function() { 
				chart2.render();
			}, 1500);
			



		//////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////

			var chart3 = new CanvasJS.Chart("equipmentchartContainer", {
				animationEnabled: true,
	theme: "dark2", // "light1", "light2", "dark1", "dark2"
	
	title:{
		text:"Equipment Stock",
		fontSize: 20
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
			if(!empty($equipmentReport)){
			foreach ($equipmentReport as $key => $value) {
				echo '{ y: '.$value['stock'].', label: "'.$value['name'].'"},';
			}}
			?>
			]
	}]
});
			setTimeout(function() { 
				chart3.render();
			}, 2000);



			//////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////


			var chart4 = new CanvasJS.Chart("profitChartContainer", {
				animationEnabled: true,
	theme: "dark2", // "light1", "light2", "dark1", "dark2"
	title:{
		text:"Profit & Loss",
		fontSize: 20
	},
	axisX:{
		valueFormatString: "",
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
	axisY: {
		title: "",
		valueFormatString: "##0.00",
		crosshair: {
			enabled: true,
			snapToDataPoint: true,
			labelFormatter: function(e) {
				return "$" + CanvasJS.formatNumber(e.value, "##0.00");
			}
		}
	},
	data: [{
		type: "area",
		xValueFormatString: "",
		yValueFormatString: "##0.00",
		dataPoints: [
			// { 'label': 'April 17', y: 76.727997 },
			<?php
			if(!empty($profit)){
				foreach ($profit as $key => $value) {
					echo '{ y: '.$profit[$key]['profit'].', label: "'.$profit[$key]['date'].'"},';
				}}
				?>
				]
	}]
});
			setTimeout(function() { 
				chart4.render();
			}, 500);


			//////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////

			var chart5 = new CanvasJS.Chart("chartContainer2", {
	theme: "dark2", // "light1", "light2", "dark1", "dark2"
	exportEnabled: true,
	animationEnabled: true,
	title: {
		text: "Task Report Status Wise",
		fontSize: 20
	},
	data: [{
		type: "doughnut",
		startAngle: 25,
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 16,
		indexLabel: "{label} - {y}",
		toolTipContent: "<b>{label}:</b> {y} (#percent%)",
		dataPoints: [
			// { y: 51.08, label: "In Stock",exploded: true },
			<?php
			if(!empty($taskPieGraph)){
			foreach ($taskPieGraph as $key => $value) {
				echo '{ y: '.$taskPieGraph[$key]['count'].', label: "'.$taskPieGraph[$key]['status'].'",exploded: true },';
			}}
			?>
			]
	}]
});
			setTimeout(function() { 
				chart5.render();
			}, 1500);
			

		///////////////////////////////////////////////////////////////////////

			var chart6 = new CanvasJS.Chart("gatewaychartContainer2", {
	theme: "dark2", // "light1", "light2", "dark1", "dark2"
	animationEnabled: true,
	title:{
		text: "Gateway Utilized Report",
		fontSize: 20
	},
	// axisX: {
	// 	valueFormatString: "DDD"
	// },
	// axisY: {
	// 	prefix: "$"
	// },
	toolTip: {
		shared: true
	},
	legend:{
		cursor: "pointer",
		itemclick: toggleDataSeries2
	},
	data: [{
		type: "stackedBar",
		name: "complete",
		showInLegend: "true",
		// xValueFormatString: "DD, MMM",
		yValueFormatString: "",
		dataPoints: [
			// { x: new Date(2017, 0, 30), y: 56 },
			<?php
			if(!empty($taskStatusWise)){
			foreach ($taskStatusWise['complete'] as $key => $value) {
				echo '{ label: "'.$taskStatusWise['complete'][$key]['username'].'", y: '.$taskStatusWise['complete'][$key]['count'].' },';
			}}
			?>
			]
	},
	{
		type: "stackedBar",
		name: "commission",
		showInLegend: "true",
		// xValueFormatString: "DD, MMM",
		yValueFormatString: "",
		dataPoints: [
			// { x: new Date(2017, 0, 30), y: 52 },
			<?php
			if(!empty($taskStatusWise)){
			foreach ($taskStatusWise['commission'] as $key => $value) {
				echo '{ label: "'.$taskStatusWise['commission'][$key]['username'].'", y: '.$taskStatusWise['commission'][$key]['count'].' },';
			}}
			?>
			]
	}]
});

			setTimeout(function() { 
				chart6.render();
			}, 1500);

			function toggleDataSeries2(e) {
				if(typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
					e.dataSeries.visible = false;
				}
				else {
					e.dataSeries.visible = true;
				}
				chart6.render();
			}


			$(document).on('click','.open-left',function(){
				chart6.render();
				chart5.render();
				chart4.render();
				chart3.render();
				chart2.render();
				chart.render();
			});

		}

		

	</script>

	