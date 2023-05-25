<!-- sample modal content -->
<div id="addUserModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="myModalLabel">Add New User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="adduserform" class="form-horizontal form-label-left input_mask">
				<div class="modal-body">

					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Full Name</label>
									<input type="text" class="form-control" name="f_name" id="exampleFormControlInput1" required="">
								</div>
							</div>
							<!-- <div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Lastname</label>
									<input type="text" class="form-control" name="l_name" id="exampleFormControlInput1" required="">
								</div>
							</div> -->
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Unique ID</label>
									<input type="text" class="form-control" name="uniq_id" id="exampleFormControlInput1" required="">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Email</label>
									<input type="email" class="form-control" name="email" id="exampleFormControlInput1" required="">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Mobile#</label>
									<input type="text" class="form-control" name="mobile" id="exampleFormControlInput1" required="">
								</div>
							</div>
							<!-- <div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">CNIC</label>
									<input type="text" class="form-control" name="nic" id="exampleFormControlInput1" required="">
								</div>
							</div> -->
							
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Username</label>
									<input type="text" class="form-control" name="username" id="exampleFormControlInput1" required="">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Password</label>
									<input type="password" class="form-control" name="password" id="exampleFormControlInput1" required="">
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6 col-xs-12">
								<div class="form-group"> 
									<label>Staff Cost</label>
									<input type="number" name="staffCost" class="form-control">
								</div>
							</div>
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Status</label>
									<select class="form-control" required="" name="status">
										<option value="">select status</option>
										<option value="admin">Admin</option>
										<option value="manager">Manager</option>
										<option value="controller">Controller</option>
										<option value="engineer">Engineer</option>
										<option value="technician">Technician</option>
										<option value="driver">Driver</option>
										<option value="back office">Back Office</option>
										<option value="trainee">Trainee</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="col-md-12">
						<div class="row">
							
							<div class="col-md-6 col-xs-12">
								<div class="form-group">
									<label for="exampleFormControlInput1">Unique ID</label>
									<input type="text" class="form-control" name="uniq_id" id="exampleFormControlInput1" required="">
								</div>
							</div>

						</div>
					</div> -->







				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary waves-effect waves-light">Add</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
