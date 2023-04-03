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
						<h4 class="page-title">Customer <small>Upload</small></h4>
					</div>
					<div class="col-sm-6">
                        <div class="float-right">
                    <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                          <a type="button" class="btn btn-secondary btn-icon" href="<?= $_SERVER['HTTP_REFERER'];?>">
                            <span class="btn-icon-label"><i class="fa fa-arrow-left mr-2"></i></span> Go Back
                        </a>
                    <?php } ?>
                    </div>
                </div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				

					<div class="col-md-8">
						<div class="card">
							<div class="card-body">

								<!-- <h4 class="mt-0 header-title">Customer Form</h4> -->
								<!-- <i class="text-muted mb-4"><small>The field labels marked with * are required input fields.</small></i><br> -->

								<form oldid="custAddForm" id="form-horizontal" class="form-horizontal form-wizard-wrapper">
									<!-- <h3>Customer Detail</h3> -->
									<fieldset>
										<div class="row">
											
											<div class="col-md-6">
												<div class="form-group">
													<label>Upload CSV</label>
													<div class="custom-file">
														<input type="file" name="file" required>
														<!-- <label class="" for="customFile" placeholder="NIC front"></label> -->
													</div>
												</div>
												<!-- <div class="form-group"></div> -->
											</div>

												<div class="col-md-6">
												<div class="form-group" style="float:right;">
													<label>CSV Sample File</label><br>
													<a href="<?= base_url();?>/sampleFile.csv?t=<?php echo time(); ?>" type="button" class="btn btn-info" style="color:white;">Download Sample File</a>
												</div>
												<!-- <div class="form-group"></div> -->
											</div>

										</div>
									</fieldset>


									
									
									<button type="submit" class="btn btn-primary waves-effect" style="float:right;"><i class="fa fa-save"></i>&nbsp;&nbsp;Submit</button>
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
	<script>
		$('.customFile').change(function() {
			var i = $(this).next('label').clone();
			var file = $('.customFile')[0].files[0].name;
			$(this).next('label').text(file);

		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#form-horizontal").submit(function() {
				$('#action_loader').modal('show');
				$.ajax({
					type: "POST",
					url: '<?php echo base_url();?>/customer/upload_csv_action',
					data:  new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					success: function (data) {
							setTimeout(function(){ 
								$('#action_loader').modal('hide');
								toastr.success(data);
							}, 500);	
					},
					error: function(jqXHR, text, error){
						setTimeout(function(){ 
							$('#action_loader').modal('hide');
							toastr.error(error);
						}, 500);
					}
				});
				return false;
			});
		});
	</script>