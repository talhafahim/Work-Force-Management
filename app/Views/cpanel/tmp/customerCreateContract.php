<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End
?>
<style>
	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
	input[type=number] {
		-moz-appearance: textfield;
	}
</style>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">Contract <small>Create</small></h4>
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
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">

							<div class="row">
								<div class="col-md-6">
									<h4 class="mt-0 header-title">Username</h4>
									<h2><?= $info->username;?></h2>
								</div>
								<div class="col-md-6">
									<h4 class="mt-0 header-title">Instruction</h4>
									<ul>
										<li>The field labels marked with * are required input fields</li>
									</ul>
								</div>
							</div>


						</div>
					</div>
				</div>

				<div class="col-md-12">

					<div class="card">

						<div class="card-body">
							<form id="createContForm">
								<input type="hidden" name="custID" id="custID" value="<?= $custID;?>">

								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Internet Package</label>
											<select class="form-control select2 pkgDetail" name="intPkg" required>
												<option value="">select package</option>
												<?php foreach($int_package->get()->getResult() as $value){?>
													<option value="<?= $value->id;?>"><?= $value->name.' ('.$value->bandwidth.'Mbps)';?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">Phone Package</label>
											<select class="form-control select2 pkgDetail" name="phonePkg">
												<option value="">select package</option>
												<?php foreach($ph_package->get()->getResult() as $value){?>
													<option value="<?= $value->id;?>"><?= $value->name;?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label class="control-label">TV Package</label>
											<select class="form-control select2 pkgDetail" name="tvPkg">
												<option value="">select package</option>
												<?php foreach($tv_package->get()->getResult() as $value){?>
													<option value="<?= $value->id;?>"><?= $value->name.' (TV Box '.$value->qty.')';?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>


								<div class="row">
									
									<div class="col-md-12">
										
										<div class="row">
											<div class="col-sm-12">
												<div style="overflow-x:scroll;">
													<label class="control-label">Package Summary</label>
													<table id="table1" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">

														<tr style="background-color:#80808040;">
															<th>Service</th>
															<th>Specs</th>
															<th>Rate</th>
															<th>SS Tax</th>
															<th>Adv Tax</th>
															<!-- <th>Qty</th> -->
															<th style="width: 200px;">Total</th>
														</tr>
														<tr>
															<th style="background-color:#80808040;">Internet</th>
															
															<td id="int-specs"></td>
															<td id="int-rate"></td>
															<td id="int-sst"></td>
															<td id="int-adv"></td>
															<!-- <td id="int-qty"></td> -->
															<td id="int-total"></td>
														</tr>
														<tr>
															<th style="background-color:#80808040;">Phone</th>
															
															<td id="ph-specs"></td>
															<td id="ph-rate"></td>
															<td id="ph-sst"></td>
															<td id="ph-adv"></td>
															<!-- <td id="ph-qty"></td> -->
															<td id="ph-total"></td>
														</tr>
														<tr>
															<th style="background-color:#80808040;">TV</th>
															
															<td id="tv-specs"></td>
															<td id="tv-rate"></td>
															<td id="tv-sst"></td>
															<td id="tv-adv"></td>
															<!-- <td id="tv-qty"></td> -->
															<td id="tv-total"></td>
														</tr>
														
														<tr>
															<th colspan="5" style="text-align:right;background-color:#80808040;">Discount</th>
															<td><input type="number" min="0" name="discount" class="form-control pkgDetail" value="0" style="padding: 0"></td>
														</tr>
														<tr>
															<th colspan="5" style="text-align:right;background-color:#80808040;">Grand Total</th>
															<td id="gtotal"></td>
														</tr>

													</table>
												</div>
											</div>
										</div>
									</div>
								</div>








								<div class="row">
									<div class="col-sm-12" style="margin-top:20px;">
										<button type="submit" class="btn btn-success mr-1 waves-effect waves-light pull-right" style="float:right;">Save</button>
									</div>
								</div>

							</form>
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
				$("#createContForm").submit(function() {
					$('#action_loader').modal('show');
					var custID = $('#custID').val();
					$.ajax({
						type: "POST",
						url: '<?php echo base_url();?>/customer/create_contract_action',
						data:$("#createContForm").serialize(),
						success: function (data) {
							toastr.success(data);
							setTimeout(function(){ 
								window.location.href = '<?= base_url();?>/customer/update/'+custID;
							}, 2000);	
						},
						error: function(jqXHR, text, error){
							toastr.error(error);
							$('#action_loader').modal('hide');
						}
					});
					return false;
				});
			});
		</script>

		<script type="text/javascript">
			$(document).on('change keyup','.pkgDetail',function(){
				getPkgDetail();
			});
			$(document).on('click','.plus,.minus',function(){
				getPkgDetail();
			});

			function getPkgDetail(){
				$.ajax({
					dataType: "json",
					type: "POST",
					url: '<?php echo base_url();?>/package/get_PkgDetail',
					data:$("#createContForm").serialize(),
					success: function (data) {
						if(data.error == null){
					//
							if(data.intPkgDetail != null){
								$('#int-rate').html(data.intPkgDetail.rate);
								$('#int-sst').html(data.intPkgTax.int_sst);
								$('#int-adv').html(data.intPkgTax.int_adv);
								$('#int-specs').html(data.intPkgDetail.bandwidth+' Mbps');
								$('#int-total').html(data.total.int);
							}if(data.phonePkgDetail != null){
								$('#ph-rate').html(data.phonePkgDetail.rate);
								$('#ph-sst').html(data.phonePkgTax.phone_sst);
								$('#ph-adv').html(data.phonePkgTax.phone_adv);
								$('#ph-specs').html(data.phonePkgDetail.minutes+' Minutes');
								$('#ph-total').html(data.total.ph);
							}if(data.tvPkgDetail != null){
								$('#tv-rate').html(data.tvPkgDetail.rate);
								$('#tv-sst').html(data.tvPkgTax.tv_sst);
								$('#tv-adv').html(data.tvPkgTax.tv_adv);
								$('#tv-specs').html(data.tvPkgDetail.qty+' TV Box');
								$('#tv-total').html(data.total.tv);
							}
					// //
							$('#gtotal').html(data.gtotal);
						}else{
							toastr.error(data.error);	
						}
					},
					error: function(jqXHR, text, error){
						toastr.error(error);
					}
				});
				return false;
			}
		</script>