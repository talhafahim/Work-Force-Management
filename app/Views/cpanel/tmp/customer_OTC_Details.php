<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End
?>
<style>
	


</style>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">Customer <small>OTC</small></h4>
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

							<!-- Nav tabs -->
							<ul class="nav nav-pills nav-justified" role="tablist" style="background-color: #222324;border-radius: 5px;">
								<li class="nav-item waves-effect waves-light">
									<a class="nav-link active" data-toggle="tab" href="#home-1" role="tab">
										<span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
										<span class="d-none d-sm-block">OTC Detail</span> 
									</a>
								</li>
								<li class="nav-item waves-effect waves-light">
									<a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">
										<span class="d-block d-sm-none"><i class="fas fa-file"></i></span>
										<span class="d-none d-sm-block">OTC Bill Detail</span> 
									</a>
								</li>
							</ul>


							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane active p-3" id="home-1" role="tabpanel">


									<form id="OTCForm">
										<input type="hidden" name="custID" id="custID" value="<?= $custID;?>">
										<div class="row">
											<div class="col-md-12">
												<!-- <h4 class="mt-0 header-title">OTC Detail</h4> -->
												<div class="table-responsive">
													<table class="table table-bordered" id="table1">
														<thead>
															<tr>

																<th>Description</th>
																<th style="width:10%;">Amount</th>
																<th style="width:10%;">
																	<?php if(empty($otc)){?>
																		<div class="btn-group btn-group-toggle" data-toggle="buttons">
																			<button title="add" type="button" class="btn btn-success btn-sm addRow"><i class="fas fa-fw fa-plus"></i></button>
																			<button title="delete" type="button" class="btn btn-danger btn-sm deleteRow"><i class="fas fa-fw fa-minus"></i></button>
																		</div>
																	<?php } ?>
																</th>
															</tr>
														</thead>
														<tbody>
															<?php if(!empty($otc)){ 
																foreach($otc_detail->get()->getResult() as $value){
																	?>
																	<tr>
																		<td><input class="form-control" type="text" name="des[]" required value="<?= $value->description;?>" > </td>
																		<td colspan="2"><input class="form-control" type="number" name="amount[]" required min="0" step="0.1" value="<?= $value->amount;?>"></td>
																	</tr>	
																<?php } }else{?>
																	<tr id="1">
																		<td><input class="form-control" type="text" name="des[]" required></td>
																		<td colspan="2"><input class="form-control amount" type="number" name="amount[]" required min="0" step="0.1" value="0"></td>
																	</tr>
																<?php } ?>
															</tbody>
															<tfoot>
																<tr>
																	<td style="text-align:right;"><b>Total OTC Amount</b></td>
																	<td colspan="2"><input class="form-control" type="number" name="otcAmt" id="otcAmt" readonly value="<?= (empty($otc)) ? 0 : $otc->total_amount; ?>"></td>
																</tr>
																<tr>
																	<td style="text-align:right;"><b>Installment Amount</b></td>
																	<td colspan="2"><input class="form-control" type="number" name="installAmt"  required value="<?= (empty($otc)) ? 0 : $otc->installment; ?>" min="0" step="0.1"></td>
																</tr>
															</tfoot>

														</table> 

													</div>
												</div>
											</div>


											<div class="row">
												<div class="col-sm-12" style="margin-top:20px;">
													<?php if(empty($otc)){?>
														<button type="button" id="otcSaveBtn" class="btn btn-primary mr-1 waves-effect waves-light m-3" style="float:right;"><i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
													<?php } ?>
												</div>
											</div>
										</form>
									</div>



									<div class="tab-pane p-3" id="profile-1" role="tabpanel">
										<div class="row">
											<div class="col-sm-12">
												<button type="button" id="otcBillGenBtn" class="btn btn-success mr-1 waves-effect waves-light m-3" style="float:right;"><i class="fa fa-file"></i>&nbsp;&nbsp;Generate New OTC Bill</button>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12">
												<div style="overflow-x: auto;padding-bottom:10px;">
													<table id="OTCBillTable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;border: 0; ">
														<thead>
															<tr>
																<th>#</th>
																<th>OTC Invoice No.</th>
																<th>OTC No.</th>
																<th>Generate On</th>
																<th>Amount</th>
																<th>Status</th>
																<th>View</th>
															</tr>
															<tbody>
																<?php 
																if(!empty($otc)){
																foreach($otc_bill->get()->getResult() as $key => $value){?>
																	<tr>
																		<td><?= $key+1;?></td>
																		<td><?= $value->id;?></td>
																		<td><?= $value->otc_id;?></td>
																		<td><?= $value->date;?></td>
																		<td><?= number_format($value->amount,2);?></td>
																		<td><span style="width:100%;font-size:15px;" class="badge badge-soft-<?= (($value->status == 'paid') ? 'success' : (($value->status == 'unpaid') ? 'warning' : 'danger')); ?>"> <?= $value->status;?> </span></td>
																		<td><center><a href="<?= base_url();?>/billing/invoice/<?= $value->id;?>" target="_blank"><i class="fa fa-file-pdf" style="font-size:20px;color:#e55151;"></i></a></center></td>
																	</tr>
																<?php } } ?>

															</tbody>

														</thead>
													</table>
												</div>

											</div>
										</div>


									</div>



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
				$(document).ready( function () {
					$('#OTCBillTable').DataTable();
				} );
			</script>
			<script type="text/javascript">
				$(document).on("keyup change",".amount", function(e) {
					var total = 0;
					var i;

					$('.amount').each(function (index, element) {
						total = total + parseFloat($(element).val());
					});
					$('#otcAmt').val(total.toFixed(2));
				});
			</script>
			<script type="text/javascript">
				var num1 = 1;
				$(".addRow").on('click',function(){
					num1++;
					var markup = "<tr id='"+num1+"'><td><input class='form-control' type='text' name='des[]' required></td><td colspan='2'><input class='form-control amount' type='number' name='amount[]' required min='0' step='0.1' value='0'></td></tr>";

					$("#table1 tbody").append(markup);

				});
				$(".deleteRow").on('click',function(){
					if(num1 > 1){
						$("#table1 tbody tr:last-child").remove();
						num1--;
					}
				});
				$(".removeRow").on('click',function(){
					$rowid = $(this).attr('data-id');
					$("#"+$rowid).remove();
				});
			</script>

			<script type="text/javascript">
				$(document).ready(function() {
					$(document).on('click','#otcSaveBtn',function(){
						if(confirm("Are you sure you want to save?")){ 
							$('#action_loader').modal('show');
							var custID = $('#custID').val();
							$.ajax({
								type: "POST",
								url: '<?php echo base_url();?>/billing/otc_save',
								data:$("#OTCForm").serialize(),
								success: function (data) {
									toastr.success(data);
									setTimeout(function(){ 
										window.location.href = '<?= base_url();?>/customer/update/'+custID;
									}, 2000);	
								},
								error: function(jqXHR, text, error){
									toastr.error(error);
									setTimeout(function(){ 
										$('#action_loader').modal('hide');
									}, 1000);
								}
							});
							return false;
						}
					});
				});
			</script>
			<script type="text/javascript">
				$(document).ready(function() {
					$(document).on('click','#otcBillGenBtn',function(){
						if(confirm("Are you sure you want to generate bill?")){ 
							$('#action_loader').modal('show');
							var custID = $('#custID').val();
							$.ajax({
								type: "POST",
								url: '<?php echo base_url();?>/billing/otc_generate_bill',
								data:'custID='+custID,
								success: function (data) {
									toastr.success(data);
									setTimeout(function(){ 
										window.location.href = '<?= base_url();?>/billing/otc/'+custID;
									}, 2000);	
								},
								error: function(jqXHR, text, error){
									toastr.error(error);
									setTimeout(function(){ 
										$('#action_loader').modal('hide');
									}, 1000);
								}
							});
							return false;
						}
					});
				});
			</script>