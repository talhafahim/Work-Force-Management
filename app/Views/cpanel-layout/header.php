<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
	<title><?= session()->get('appTitle');?></title>
	<meta content="Admin Dashboard" name="description">
	<meta content="Themesbrand" name="author">
	
	<meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="expires" content="0" />

	<meta http-equiv='cache-control' content='no-cache'>
	<meta http-equiv='expires' content='0'>
	<meta http-equiv='pragma' content='no-cache'>
	<link rel="manifest" href="/manifest.json">
	<link rel="shortcut icon" href="<?= base_url();?>/assets/images/logo-sm.png?t=<?php echo time(); ?>">
	<!--Chartist Chart CSS -->
	<!-- datepicker -->
	<link href="<?= base_url();?>/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<!-- jvectormap -->
	<link href="<?= base_url();?>/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
	<!--  -->
	<link href="<?= base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url();?>/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url();?>/assets/css/icons.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url();?>/assets/css/style.css" rel="stylesheet" type="text/css">
	<!-- Toast -->
	<link href="<?= base_url();?>/assets/css/toastr.min.css" rel="stylesheet" type="text/css">
	<!-- DATATABLE -->
	<link href="<?= base_url();?>/assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url();?>/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<!-- Responsive datatable examples -->
	<link href="<?= base_url();?>/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />   

	<link href="<?= base_url();?>/assets/css/responsive.css" rel="stylesheet" type="text/css" />   
	<link href="<?= base_url();?>/assets/css/notification_style.css" rel="stylesheet" type="text/css" />   
	<!--  -->
	<style>
		::-webkit-scrollbar {
			height: 4px;
			width: 4px;
		}

		/* Track */
		::-webkit-scrollbar-track {
			background: #383c40; 
		}
		
		/* Handle */
		::-webkit-scrollbar-thumb {
			background: #9ea5ab; 
		}
	</style>
</head>
<body>
	<?php echo view('cpanel/popup/notification_alert.php');?>
	<!-- Begin page -->
	<div id="wrapper">