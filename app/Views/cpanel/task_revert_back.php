<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End

?>
<!--Jquery steps CSS -->
<link rel="stylesheet" href="<?= base_url();?>/assets/plugins/jquery-steps/jquery.steps.css">
<!-- <link href="<?= base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
<link href="<?= base_url();?>/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
<!-- <link href="<?= base_url();?>/assets/css/icons.css" rel="stylesheet" type="text/css"> -->
<link href="<?= base_url();?>/assets/css/style.css" rel="stylesheet" type="text/css">
<style>
	.red{
		color: red;
	}
</style>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">Work Order Revert Back <small></small></h4>
					</div>
					<div class="col-sm-6">
						<div class="float-right">
							<?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
								<!-- <a type="button" class="btn btn-secondary btn-icon" href="<?= $_SERVER['HTTP_REFERER'];?>">
									<span class="btn-icon-label"><i class="fa fa-arrow-left mr-2"></i></span> Go Back
								</a> -->
							<?php } ?>

						</div>
					</div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<!-- <h4 class="mt-0 header-title">Assign by UN#</h4> -->
							<form id="byUnform">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleFormControlInput1">UN Number#</label>
											<input type="text" class="form-control" name="un" placeholder="type un number here" id="un" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="exampleFormControlInput1">Meter Serial#</label>
											<input type="text" class="form-control" name="meter_serial" placeholder="type meter serial number here" id="meter_serial" required>
										</div>
									</div>
									
									<div class="col-md-12">
										<div class="form-group">
											<button class="btn btn-primary" style="float:right;" type="submit">Submit</button>
										</div>
									</div>
								</div>
							</form>

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
	echo view('cpanel-layout/footer');
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#byUnform").submit(function() {

				if(confirm('Do you really want to revert it back?')){
				if(confirm('Are you sure? Think again.')){

				$('#action_loader').modal('show');
				$.ajax({
					type: "POST",
					url: '<?php echo base_url();?>/task/task_revert_back_action',
					data:$("#byUnform").serialize(),
					success: function (data) {
						setTimeout(function(){ 
							toastr.success(data);
							$('#action_loader').modal('hide');
							$("#byUnform").trigger("reset");
						}, 500);

					},
					error: function(jqXHR, text, error){
						setTimeout(function(){ 
							toastr.error(error);
							$('#action_loader').modal('hide');
						}, 500);
					}

				});

			}
			}
				return false;
			});
		});

	</script>

	
