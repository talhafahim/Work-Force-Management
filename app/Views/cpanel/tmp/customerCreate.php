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
						<h4 class="page-title">Customer <small>Create</small></h4>
					</div>
					<div class="col-sm-6">
                        <div class="float-right">
                    <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                          <a type="button" class="btn btn-secondary btn-icon" href="<?= $_SERVER['HTTP_REFERER'];?>">
                            <span class="btn-icon-label"><i class="fa fa-arrow-left mr-2"></i></span> Go Back
                        </a>
                    <?php } ?>
                    <a type="button" class="btn btn-primary btn-icon" href="<?= base_url();?>/customer/upload">
                            <span class="btn-icon-label"><i class="fa fa-user-plus mr-2"></i></span> Upload CSV
                        </a>
                    </div>
                </div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="mt-0 header-title">Instruction</h4>
							<ul>
								<li>The field labels marked with <span class="red">*</span> are required input fields</li>
								<!-- <li>Don't use any capital letter in Customer ID</li>
									<li>First character of user id should be alphabet</li> -->
								</ul>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="card">
							<div class="card-body">

								<!-- <h4 class="mt-0 header-title">Customer Form</h4> -->
								<!-- <i class="text-muted mb-4"><small>The field labels marked with * are required input fields.</small></i><br> -->

								<form oldid="custAddForm" id="form-horizontal" class="form-horizontal form-wizard-wrapper">
									<!-- <h3>Customer Detail</h3> -->
									<fieldset>
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group"> 
													<label>First Name<span class="red">*</span></label>
													<input name="fname" type="text" class="form-control" required>
												</div>
												<div class="form-group"> 
													<label>Last Name<span class="red">*</span></label>
													<input name="lname" type="text" class="form-control" required>
												</div>
												<div class="form-group"> 
													<label>CNIC#<span class="red">*</span></label>
													<input name="cnic" type="text" class="form-control" placeholder="42501-3554268-8" data-mask="99999-9999999-9" required>
												</div>
												<div class="form-group"> 
													<label>Mobile#<span class="red">*</span></label>
													<input name="mobile" type="text" class="form-control" placeholder="03006548832" data-mask="03999999999" required>
												</div>
												<div class="form-group"> 
													<label>Phone#</label>
													<input name="phone" type="text" class="form-control">
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group"> 
													<label>Email Address<span class="red">*</span></label> 
													<input name="email" type="email" class="form-control" placeholder="name@example.com" required>
												</div>

												<div class="form-group"> 
													<label>Passport#</label>
													<input name="passport" type="text" class="form-control">
												</div>
												<div class="form-group">
													<label class="control-label">City<span class="red">*</span></label>
													<select class="form-control select2" name="city" required>
														<option value="">Select City</option>
														<?php foreach($cities->get()->getResult() as $value){?>
															<option value="<?= $value->city;?>"><?= $value->city;?></option>
														<?php } ?>
													</select>
												</div>
												<div class="form-group">
													<label>Home Address<span class="red">*</span></label>
													<textarea class="form-control" name="address" rows="5" required></textarea>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<label>NIC Front Image</label>
													<div class="custom-file">
														<input type="file" class="custom-file-input customFile" name="nicFront" id="customFile" placeholder="NIC front" required>
														<label class="custom-file-label" for="customFile" placeholder="NIC front"></label>
													</div>
												</div>
												<div class="form-group">
													<label>NIC Back Image</label>
													<div class="custom-file">
														<input type="file" class="custom-file-input customFile" name="nicBack"  id="customFile" required>
														<label class="custom-file-label" for="customFile" placeholder="NIC front"></label>
													</div>
												</div>
											</div>

										</div>
									</fieldset>


									
									
									<button type="submit" class="btn btn-primary waves-effect" style="float:right;"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
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
					url: '<?php echo base_url();?>/customer/save_customer',
					data:  new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					success: function (data) {
						if(data.includes('Success')){
							var arr = data.split("-");
							//
							toastr.success("Customer Added Successfully");
							setTimeout(function(){ 
								window.location.href = "<?= base_url();?>/customer/update/"+arr[1];
							}, 3000);
						}else{
							setTimeout(function(){ 
								$('#action_loader').modal('hide');
								toastr.error(data);
							}, 500);	
						}
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