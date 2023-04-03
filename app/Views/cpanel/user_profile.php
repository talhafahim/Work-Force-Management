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

			<div class="row">

				<div class="col-lg-6">
					<div class="card">
						<div class="card-body">

							<h4 class="mt-0 header-title">Profile Info</h4>
							<small class="text-muted mb-4"><i>The field labels marked with * are required input fields.</i></small>

							<form id="updateProfile">
								<input type="hidden" name="id" value="<?= $info->id;?>">
								<div class="form-group mb-4">
									<label>Full Name</label>
									<div>
										<div class="input-group">
											<input type="text" class="form-control" name="f_name" readonly value="<?= $info->firstname.' '.$info->lastname;?>">
										</div><!-- input-group -->
									</div>
								</div>

								<div class="form-group mb-4">
									<label>Email</label>
									<div>
										<div class="input-group">
											<input type="email" class="form-control" name="email" readonly value="<?= $info->email;?>">
										</div><!-- input-group -->
									</div>
								</div>
								<div class="form-group mb-4">
									<label>CNIC</label>
									<div>
										<div class="input-group">
											<input type="text" class="form-control" name="cnic" readonly value="<?= $info->nic;?>">
										</div><!-- input-group -->
									</div>
								</div>

								<div class="form-group mb-4">
									<label>Mobile No.*</label>
									<div>
										<div class="input-group">
											<input type="text" class="form-control" name="mobile" placeholder="03009999999" value="<?= $info->mobilephone;?>">
										</div><!-- input-group -->
									</div>
								</div>

								<div class="form-group mb-4">
									<label>Address*</label>
									<div>
										<div class="input-group">
											<input type="text" class="form-control" name="address" placeholder="" value="<?= $info->address;?>">
										</div><!-- input-group -->
									</div>
								</div>
								<button type="submit" class="btn btn-primary waves-effect waves-light float-right">Save</button>
							</form>
						</div>
					</div>

				</div>
				<!-- <hr> -->
				<div class="col-lg-6">
					<div class="card">
						<div class="card-body">

							<h4 class="mt-0 header-title">Change Password</h4>
							<small class="text-muted mb-4"><i>The field labels marked with * are required input fields.</i></small>

							<form id="changePassword">
								<input type="hidden" name="id" value="<?= $info->id;?>">
								<div class="form-group mb-4">
									<label>Old Password*</label>
									<div>
										<div class="input-group">
											<input type="password" class="form-control" name="old">
										</div><!-- input-group -->
									</div>
								</div>

								<div class="form-group mb-4">
									<label>New Password*</label>
									<div>
										<div class="input-group">
											<input type="password" class="form-control" name="new">
										</div><!-- input-group -->
									</div>
								</div>

								<div class="form-group mb-4">
									<label>Confirm New Password*</label>
									<div>
										<div class="input-group">
											<input type="password" class="form-control" name="confirm">
										</div><!-- input-group -->
									</div>
								</div>
								<button type="submit" class="btn btn-primary waves-effect waves-light float-right">Save</button>
							</form>
						</div>
					</div>

				</div>


			</div>
		</div>
		
	</div>
	
	<!-- content -->
	<?php
	echo view('cpanel-layout/footer');
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#updateProfile").submit(function() {
				$.ajax({
					type: "POST",
					url: '<?php echo base_url();?>/user/update_profile',
					data:$("#updateProfile").serialize(),
					success: function (data) {
						toastr.success(data);
					},
					error: function(jqXHR, text, error){
						toastr.error(error);

					}
				});
				return false;
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#changePassword").submit(function() {
				$.ajax({
					type: "POST",
					url: '<?php echo base_url();?>/user/change_password',
					data:$("#changePassword").serialize(),
					success: function (data) {
						if(data.includes('Success')){
							toastr.success(data);
							$('#changePassword').trigger('reset');
						}else{
							toastr.error(data);
						}
					},
					error: function(jqXHR, text, error){
						toastr.error(error);

					}
				});
				return false;
			});
		});
	</script>