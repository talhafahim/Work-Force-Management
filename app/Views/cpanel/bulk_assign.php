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
						<h4 class="page-title">Assign Work Order <small></small></h4>
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
							<h4 class="mt-0 header-title">Assign by UN#</h4>
							<form id="byUnform">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleFormControlInput1">UN#</label>
											<input type="text" class="form-control" name="un_number" placeholder="type un number here" id="un_number" required>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="exampleFormControlInput1">Water Meter</label>
											<h4 id="waterMeterCount">0</h4>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="exampleFormControlInput1">Electric Meter</label>
											<h4 id="electricMeterCount">0</h4>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleFormControlInput1">Assign To</label>
											<select class="form-control js-select2" required name="technician_id" placeholder="select technician">
												<option value="">select technician</option>
												<?php foreach ($technicianList->get()->getResult() as $value) { ?>
													<option value="<?= $value->id;?>"><?= $value->firstname.' '.$value->lastname;?></option>
												<?php } ?>
											</select>
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


				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<h4 class="mt-0 header-title">Assign by Meter#</h4>
							<form id="byMeterform">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleFormControlInput1">Upload CSV file</label><br>
											<input type="file" name="file" required>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleFormControlInput1">Assign To</label>
											<select class="form-control js-select2" required name="technician_id" placeholder="select technician">
												<option value="">select technician</option>
												<?php foreach ($technicianList->get()->getResult() as $value) { ?>
													<option value="<?= $value->id;?>"><?= $value->firstname.' '.$value->lastname;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleFormControlInput1">CSV File Sample</label><br>
											<a href="<?= base_url();?>/csv_sample_files/assign_by_meter.csv" class="btn btn-info">Download Sample File</a>
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
				$('#action_loader').modal('show');
				$.ajax({
					type: "POST",
					url: '<?php echo base_url();?>/Customer/assign_by_un',
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
				return false;
			});
		});

	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#byMeterform").submit(function() {
				$('#action_loader').modal('show');
				$.ajax({
					type: "POST",
					url: '<?php echo base_url();?>/Customer/assign_by_meter',
					data:  new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					success: function (data) {
						setTimeout(function(){ 
							toastr.success(data);
							$('#action_loader').modal('hide');
							$("#byMeterform").trigger("reset");
						}, 500);

					},
					error: function(jqXHR, text, error){
						setTimeout(function(){ 
							toastr.error(error);
							$('#action_loader').modal('hide');
						}, 500);
					}

				});
				return false;
			});
		});

	</script>
	<script type="text/javascript">
		$(document).on('keyup change','#un_number',function(){
			var data = $(this).val();
			//
			$.ajax({
				dataType: "json",
				type: "POST",
				url: '<?php echo base_url();?>/Customer/count_meter_type',
				data:'data='+data,
				success: function(data){
					$('#waterMeterCount').html(data.waterMeterCount);
					$('#electricMeterCount').html(data.electricMeterCount);
				}
			});
		});
	</script>