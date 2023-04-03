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
						<h4 class="page-title">Empty Page</h4>
					</div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-md-12">
					<p>Page content here with seprate rows</p>
				</div>
			</div>
			<!-- end row -->
		</div>
		<!-- container-fluid -->
		
	</div>
	
	<!-- content -->
	
<?php 
echo view('cpanel-layout/footer');
?>
<script>
$(document).ready(function(){
	$('#action_loader').modal('show');
});


</script>