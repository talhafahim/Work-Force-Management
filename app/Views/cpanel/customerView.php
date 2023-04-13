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
	.img-thumbnail{
		height:60px !important;
	}
</style>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">Task <small>View Details</small></h4>
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
				<div class="col-md-4">
					<div class="card">
						<div class="card-body">
							
							<table class="table table-bordered">

								<tr>
									<td><b>Name</b></td>
									<td><?= $info->name;?></td>
								</tr>
								<tr>
									<td><b>Email</b></td>
									<td><?= $info->email;?></td>
								</tr>
								<tr>
									<td><b>Mobile</b></td>
									<td><?= $info->mobile;?></td>
								</tr>
								<tr>
									<td><b>UN#</b></td>
									<td><?= $info->un_number;?></td>
								</tr>
								<tr>
									<td><b>Meter#</b></td>
									<td><?= $info->meter_number;?></td>
								</tr>
								<tr>
									<td><b>Number of meter</b></td>
									<td><?= $info->no_of_meter;?></td>
								</tr>
								<tr>
									<td><b>Priority</b></td>
									<td><?= $info->priority;?></td>
								</tr>
								<tr>
									<td><b>Latitude</b></td>
									<td><?= $info->latitude;?></td>
								</tr>
								<tr>
									<td><b>Longitude</b></td>
									<td><?= $info->longitude;?></td>
								</tr>
								<tr>
									<td><b>Protocol</b></td>
									<td><?= $info->protocol;?></td>
								</tr>
								<tr>
									<td><b>MFG CD</b></td>
									<td><?= $info->mfg_cd;?></td>
								</tr>
								<tr>
									<td><b>Meter Model</b></td>
									<td><?= $info->meter_model;?></td>
								</tr>
								<tr>
									<td><b>Prem Type</b></td>
									<td><?= $info->prem_type;?></td>
								</tr>
								<tr>
									<td><b>Sector</b></td>
									<td><?= $info->sector;?></td>
								</tr>
								<tr>
									<td><b>Plot</b></td>
									<td><?= $info->plot;?></td>
								</tr>
								<tr>
									<td><b>Address</b></td>
									<td><?= $info->address;?></td>
								</tr>
								<tr>
									<td><b>Prem Name EN</b></td>
									<td><?= $info->per_name_en;?></td>
								</tr>
								<tr>
									<td><b>Created On</b></td>
									<td><?= $info->created_on;?></td>
								</tr>


							</table>


						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<iframe style="width: 100%;height: 500px;" src="https://maps.google.com/maps?q=<?= $info->latitude;?>,<?= $info->longitude;?>&hl=es;z=14&output=embed"></iframe>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<h5>Progress Detail</h5>
									<table class="table table-bordered">
										<tr>
											<td><b>Task Current Status</b></td>
											<td><span class="badge badge-soft-info" style="font-size:15px;"><?= ($info->status == 'complete') ? 'installed' : ( ($info->status == 'reject') ? 'return' : ($info->status) );
										?></span></td>
									</tr>
								</table>

								<div id="accordion">
									<?php foreach ($get_task_detail->get()->getResult() as $key => $value) { 
										$status = ($value->status == 'complete') ? 'installed' : ( ($value->status == 'reject') ? 'return' : ($value->status) );
										?>
										<div class="card mb-1">
											<div class="card-header p-3" id="headingOne">
												<h6 class="m-0 font-14">
													<a href="#collapse<?= $key;?>" class="text-dark" data-toggle="collapse"
														aria-expanded="true"
														aria-controls="collapseOne">
														<?= ucfirst($status);?> Detail
														<span style="float:right;"><?= $value->created_on;?></span>
													</a>
												</h6>
											</div>

											<div id="collapse<?= $key;?>" class="collapse"
												aria-labelledby="headingOne" data-parent="#accordion">
												<div class="card-body" style="overflow-x:scroll;">
													<table class="table table-bordered">
														<?php if($status == 'return'){ ?>
															<tr>
																<td><b>Return Reason</b></td>
																<td><?= $modelGeneral->get_return_reason($value->reject_reason)->get()->getRow()->reason;?></td>
															</tr>
														<?php }if($status == 'installed' || $status == 'commission'){ ?>
															<tr>
																<td><b>Gateway Serial#</b></td>
																<td><?php 
																$taskGateways = $modelGeneral->get_task_gateway(null,$value->task_id,null,$value->id);
																foreach($taskGateways->get()->getResult() as $gateways){ echo $gateways->gateway_serial.'  '; }?></td>
															</tr>
															<tr>
																<td><b>Equipment</b></td>
																<td>
																	<table class="table table-bordered">
																		<tr><td>Name</td><td>Quantity</td></tr>
																		<?php
																		$taskEquipment = $modelGeneral->get_task_misc_equipment($value->task_id,null,$value->id);
																		foreach ($taskEquipment->get()->getResult() as $eqValue) { ?>
																			<tr><td><?= $modelGeneral->get_misc_equipment($eqValue->equip_id)->get()->getRow()->name;?></td><td><?= $eqValue->qty;?></td></tr>
																		<?php } ?>
																	</table>
																</td>
															</tr>
														<?php } ?>
														<tr>
															<td><b>Picture</b></td>
															<td>
																<?php if(file_exists('./picture/'.$value->picture1)){?>
																	<img src="<?= base_url();?>/picture/<?= $value->picture1;?>" alt="..." class="img-thumbnail taskImg">
																<?php }if(file_exists('./picture/'.$value->picture2)){?>
																	<img src="<?= base_url();?>/picture/<?= $value->picture2;?>" alt="..." class="img-thumbnail taskImg">
																<?php }if(file_exists('./picture/'.$value->picture3)){?>
																	<img src="<?= base_url();?>/picture/<?= $value->picture3;?>" alt="..." class="img-thumbnail taskImg">
																<?php }if(file_exists('./picture/'.$value->picture4)){?>
																	<img src="<?= base_url();?>/picture/<?= $value->picture4;?>" alt="..." class="img-thumbnail taskImg">
																<?php }if(file_exists('./picture/'.$value->picture5)){?>
																	<img src="<?= base_url();?>/picture/<?= $value->picture5;?>" alt="..." class="img-thumbnail taskImg">
																<?php } ?>
															</td>
														</tr>
														<tr>
															<td><?= ucfirst($status);?> By</td>
															<td><?php
															$userInfo = $modelUser->get_users($value->user_id)->get()->getRow();
															echo $userInfo->firstname.' '.$userInfo->lastname;
														?></td>
														</tr>
													</table>
												</div>
											</div>
										</div>
									<?php } ?>


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


<!-- sample modal content -->

<!-- content -->
<div id="taskImgModel" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<img  src="" style="height: 500px;">
	</div>
</div>
<?php 
echo view('cpanel-layout/footer');
?>

<script type="text/javascript">
	$(document).on('click','.taskImg',function(){
		var img = $(this).attr('src');
		$('#taskImgModel img').attr('src', img);
		$('#taskImgModel').modal('show');
	});
</script>
