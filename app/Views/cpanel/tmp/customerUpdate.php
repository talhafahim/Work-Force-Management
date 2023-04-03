<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End
?>
<link href="<?= base_url();?>/assets/css/tree.css" rel="stylesheet" type="text/css">
<style>
	.flip-card {
		/*background-color: transparent;*/
		width: auto;
		height: 115px;
		perspective: 1000px;
	}

	.flip-card-inner {
		position: relative;
		width: 100%;
		height: 100%;
		text-align: center;
		transition: transform 0.6s;
		transform-style: preserve-3d;
		/*box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);*/
	}

	.flip-card:hover .flip-card-inner {
		transform: rotateY(180deg);
	}

	.flip-card-front, .flip-card-back {
		position: absolute;
		width: 100%;
		height: 100%;
		-webkit-backface-visibility: hidden;
		backface-visibility: hidden;
	}

	.flip-card-front {
/*background-color: #bbb;
color: black;*/
}

.flip-card-back {
/* background-color: #2980b9;
color: white;*/
transform: rotateY(180deg);
}

.custom-badge{
	font-weight: normal;
	background: white;
	color: #000;
	padding: 1px 4px;
	display: inline-block;
	border-radius: 5px;
}
.child{
	color: #facd00 !important;
}


</style>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">Customer <small>Update</small></h4>
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
								<div class="col-md-10">
									<h4 class="mt-0 header-title">Username</h4>
									<h2><?= $info->username;?></h2>
								</div>
								
								<div class="col-md-2">
									<!-- <div class="col-sm-4 col-xs-6 "> -->
										<form id="enableDisableForm">
											<input type="hidden" name="custID" id="custID" value="<?= $info->id;?>">
											<div class="form-group">
												<label class="control-label">Block Panel</label><br>
												<input type="hidden" name="block" value="no"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="checkbox" name="block" id="blockPanel" switch="danger" value="yes" <?= ($info->block == 'yes') ? 'checked' : '';?>/>
												<label for="blockPanel" data-on-label="Yes" data-off-label="No"></label>										
											</div>
										</form>
										<!-- </div> -->
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
											<span class="d-none d-sm-block">Customer Detail</span> 
										</a>
									</li>
									<li class="nav-item waves-effect waves-light">
										<a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-boxes"></i></span>
											<span class="d-none d-sm-block">Contract Detail</span> 
										</a>
									</li>
									<li class="nav-item waves-effect waves-light">
										<a class="nav-link" data-toggle="tab" href="#messages-1" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-file"></i></span>
											<span class="d-none d-sm-block">Billing Detail</span>   
										</a>
									</li>
									<li class="nav-item waves-effect waves-light">
										<a class="nav-link" data-toggle="tab" href="#tree-1" role="tab">
											<span class="d-block d-sm-none"><i class="fas fa-file"></i></span>
											<span class="d-none d-sm-block">Network Tree</span>   
										</a>
									</li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									<div class="tab-pane active p-3" id="home-1" role="tabpanel">


										<!-- <h4 class="mt-0 header-title">Customer Info</h4> -->
										<!-- <i class="text-muted mb-4"><small>The field labels marked with * are required input fields.</small></i><br> -->

										<form id="custUpdateForm">
											<input type="hidden" name="custID" id="custID" value="<?= $info->id;?>">
											<div class="row">
												<div class="col-sm-4">
													<div class="form-group"> 
														<label>First Name*</label>
														<input name="fname" type="text" class="form-control" required value="<?= $info->firstname;?>" >
													</div>
													<div class="form-group"> 
														<label>Last Name*</label>
														<input name="lname" type="text" class="form-control" required value="<?= $info->lastname;?>">
													</div>
													<div class="form-group"> 
														<label>CNIC#*</label>
														<input name="cnic" type="text" class="form-control" placeholder="42501-3554268-8" data-mask="99999-9999999-9" required value="<?= $info->nic;?>">
													</div>
													<div class="form-group"> 
														<label>Mobile#*</label>
														<input name="mobile" type="text" class="form-control" placeholder="03006548832" data-mask="03999999999" required value="<?= $info->mobilephone;?>">
													</div>
													<div class="form-group"> 
														<label>Phone#</label>
														<input name="phone" type="text" class="form-control" value="<?= $info->phone;?>">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group"> 
														<label>Email Address*</label> 
														<input name="email" type="email" class="form-control" placeholder="name@example.com" required value="<?= $info->email;?>">
													</div>

													<div class="form-group"> 
														<label>Passport#</label>
														<input name="passport" type="text" class="form-control" value="<?= $info->passport;?>">
													</div>
													<div class="form-group">
														<label class="control-label">City*</label>
														<select class="form-control select2" required name="city" >
															<option value="">Select City</option>
															<?php foreach($cities->get()->getResult() as $value){?>
																<option value="<?= $value->city;?>" <?= ($value->city == $info->city) ? 'selected' : '';?> > <?= $value->city;?></option>
															<?php } ?>
														</select>
													</div>
													<div class="form-group">
														<label>Home Address*</label>
														<textarea class="form-control" name="address" rows="5" required ><?= $info->address;?></textarea>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="row">
												<!-- <div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Activate Panel</label><br>
														<input type="hidden" name="active" value="no"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<input type="checkbox" name="active" id="activate" switch="success" value="yes" <?= ($info->active == 'yes') ? 'checked' : '';?> />
														<label for="activate" data-on-label="Yes" data-off-label="No"></label>									
													</div>
												</div> -->
												<!-- <div class="col-sm-4 col-xs-6 ">
													<div class="form-group">
														<label class="control-label">Block Panel</label><br>
														<input type="hidden" name="block" value="no"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<input type="checkbox" name="block" id="panel" switch="danger" value="yes" <?= ($info->block == 'yes') ? 'checked' : '';?>/>
														<label for="panel" data-on-label="Yes" data-off-label="No"></label>										
													</div>
												</div> -->
												<!-- <div class="col-sm-8 col-xs-6 ">
													<label class="control-label">One Time Cost Detail</label><br>
													<a type="button" class="btn btn-secondary btn-block waves-effect waves-light" href="<= base_url();?>/billing/otc/<= $info->id;?>">&nbsp;&nbsp;Show OTC Details </a>
												</div> -->
												<!-- <div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Disable PKG</label><br>
														<input type="hidden" name="pkgBlock" value="no"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<input type="checkbox" name="pkgBlock" id="disable" switch="danger" value="yes"/>
														<label for="disable" data-on-label="Yes" data-off-label="No"></label>
													</div>
												</div> -->
											</div>
											<?php
											if(!file_exists('./customer_nic/'.$info->username.'-front.jpg')){
											?>
											<div class="form-group">
												<label>NIC Front Image</label>
												<div class="custom-file">
													<input type="file" class="custom-file-input customFile" id="customFile" placeholder="NIC front" name="nicFront">
													<label class="custom-file-label" for="customFile" placeholder="NIC front">select image</label>
												</div>
											</div>
											<div class="form-group">
												<label>NIC Back Image</label>
												<div class="custom-file">
													<input type="file" class="custom-file-input customFile" id="customFile" placeholder="NIC front" name="nicBack">
													<label class="custom-file-label" for="customFile" placeholder="NIC front">select image</label>
												</div>
											</div>
											<?php }else{ ?>
											<div class="form-group">
												<label>CNIC</label>
												<div class="flip-card">
													<div class="flip-card-inner">
														<div class="flip-card-front">
															<img src="<?= base_url();?>/customer_nic/<?= $info->username;?>-front.jpg" alt="Avatar" style="width:100%;">
														</div>
														<div class="flip-card-back">
															<img src="<?= base_url();?>/customer_nic/<?= $info->username;?>-back.jpg" alt="Avatar" style="width:100%;">
														</div>
													</div>
												</div>
											</div>
										 <?php } ?>

										</div>
									</div>
									<button type="submit" class="btn btn-success mr-1 waves-effect waves-light pull-right" style="float:right;"> <i class="fa fa-save"></i>&nbsp;&nbsp;Save</button>
									<!-- <button type="submit" class="btn btn-secondary waves-effect">Cancel</button> -->
								</form>
							</div>
							<!--  -->
							<div class="tab-pane p-3" id="profile-1" role="tabpanel">
								
								<div class="row">
									<?php if(empty($openCont->id)){?>
										<center><span class="badge badge-soft-warning"><h4>&nbsp;&nbsp; No active contract &nbsp;&nbsp;</h4></span></center>
									<?php }else{?>

										<div class="col-sm-12" style="display:block;">
											<div class="row">
												<div class="col-sm-4">
													<label class="control-label">Internet Package</label>
													<h5 id="city"><span class="badge badge-soft-warning"><?= $intPkgDetail->name;?></span></h5>
												</div>
												<div class="col-sm-4">
													<label class="control-label">Phone Package</label>
													<h5 id="pkgName"><span class="badge badge-soft-warning"><?= (!empty($phonePkgDetail->name)) ? $phonePkgDetail->name : null;?></span></h5>
												</div>
												<div class="col-sm-4">
													<label class="control-label">TV Package</label>
													<h5 id="bandwidth"><span class="badge badge-soft-warning"><?= (!empty($tvPkgDetail->name)) ? $tvPkgDetail->name : null;?></span></h5>
												</div>
											</div>
											

											<div class="row">
												<div class="col-sm-12">
													<div style="overflow-x:auto;">
														<label class="control-label">Package Summary</label>
														<table id="table1" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">

															<tr style="background-color:#42464b;">
																<th>Service</th>
																<th>Specs</th>
																<th>Rate</th>
																<th>SS Tax</th>
																<th>Adv Tax</th>
																<th>Total</th>
															</tr>
															<tr style="background-color:#ffc10729;">
																<th style="background-color:#42464b;">Internet</th>
																<td id="int-rate"><?= $intPkgDetail->bandwidth;?> Mbps</td>
																<td id="int-rate"><?= $intPkgDetail->rate;?></td>
																<td id="int-sst"><?= $intPkgTax->int_sst;?></td>
																<td id="int-adv"><?= $intPkgTax->int_adv;?></td>
																<td id="int-total"><?= number_format($total['int'],2);?></td>
															</tr>
															<?php if(!empty($openCont->tv_pkg_id)){?>
																<tr style="background-color:#28a74530;">
																	<th style="background-color:#42464b;">TV</th>
																	<td id="tv-rate"><?= $tvPkgDetail->qty;?> TV Box</td>
																	<td id="int-rate"><?= $tvPkgDetail->rate;?></td>
																	<td id="tv-sst"><?= $tvPkgTax->tv_sst;?></td>
																	<td id="tv-adv"><?= $tvPkgTax->tv_adv;?></td>
																	<td id="tv-total"><?= number_format($total['tv'],2);?></td>
																</tr>
															<?php } if(!empty($openCont->ph_pkg_id)){?>
																<tr style="background-color:#17a2b830;">
																	<th style="background-color:#42464b;">Phone</th>
																	<td id="ph-rate"><?= $phonePkgDetail->minutes;?> Minutes</td>
																	<td id="int-rate"><?= $phonePkgDetail->rate;?></td>
																	<td id="ph-sst"><?= $phonePkgTax->phone_sst;?></td>
																	<td id="ph-adv"><?= $phonePkgTax->phone_adv;?></td>
																	<td id="ph-total"><?= number_format($total['ph'],2);?></td>
																</tr>
															<?php } ?>
															<tr style="background-color:#0800ff1f;">
																<th colspan="5" style="text-align:right;background-color:#42464b;">Discount</th>
																<td><?= number_format($openCont->discount);?></td>
															</tr>
															<tr style="background-color:#f05e5e38;">
																<th colspan="5" style="text-align:right;background-color:#42464b;">Grand Total</th>
																<td><?= number_format( ($total['int']+$total['ph']+$total['tv']) - $openCont->discount );?></td>
															</tr>

														</table>
													</div>
												</div>
											</div>




										</div>
									<?php } ?>
								</div>

								<div class="row">
									<div class="col-sm-12">
										<div class="d-flex justify-content-between w-100" style="margin-top:20px;">
											<?php if(!empty($openCont->id)){?>
												<button type="button" class="btn btn-danger" id="deactiveBtn" style="float:left;margin-right:10px;"> <i class="fa fa-ban"></i>&nbsp;&nbsp;Deactive Current Contract </button>
											<?php }else{ ?>
												<button type="button" class="btn btn-success" id="activeBtn" style="float:left;margin-right:10px;"> <i class="fa fa-heart"></i>&nbsp;&nbsp;Active Now </button>
											<?php } ?>
											<a type="button" class="btn btn-primary" href="<?= base_url();?>/customer/create_contract/<?= $info->id;?>" style="float:right;"> <i class="fa fa-plus"></i>&nbsp;&nbsp;Create New Contract </a>
										</div>
									</div>
								</div>

								
								
								<div class="row">
									<div class="col-sm-12" style="margin-top:20px;overflow-x:auto;">
										<div id="accordion">
											<div class="card mb-0">
												<div class="card-header p-3 mb-3" id="headingThree">
													<h6 class="m-0 font-14">
														<a href="#collapseThree" class="text-dark collapsed" data-toggle="collapse"
														aria-expanded="false"
														aria-controls="collapseThree">
														Show contracts list
														<i class="fa fa-angle-double-down" style="float:right"></i>
													</a>
												</h6>
											</div>
											<div id="collapseThree" class="collapse"
											aria-labelledby="headingThree" data-parent="#accordion">
											<div class="card-body p-0">
												<div style="overflow-x: auto;padding-bottom:10px;">
													<table id="PreContTable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;border: 0;">
														<thead>
															<tr>
																<th>Contract ID</th>
																<th>Internet Package</th>
																<th>TV Package</th>
																<th>Phone Package</th>
																<th>Created On</th>
																<th>Start Date</th>
																<th>Status</th>
															</tr>
															<tbody>
																<?php
																foreach($allCont->get()->getResult() as $key => $value){?>
																	<tr>
																		<td><?= $key+1;?></td>
																		<td><?= (empty($value->int_pkg_id)) ? null : $modelpkg->get_package_internet($value->int_pkg_id)->get()->getRow()->name;?></td>
																		<td><?= (empty($value->tv_pkg_id)) ? null : $modelpkg->get_package_tv($value->tv_pkg_id)->get()->getRow()->name;?></td>
																		<td><?= (empty($value->ph_pkg_id)) ? null : $modelpkg->get_package_phone($value->ph_pkg_id)->get()->getRow()->name;?></td>
																		<td><?= $value->created_on;?></td>
																		<td><?= $value->start_date;?></td>
																		<td><span style="width:100%;font-size:15px;" class="badge badge-soft-<?= (($value->status == 'New') ? 'success' : (($value->status == 'Deactive') ? 'warning' : (($value->status == 'Active') ? 'primary' : 'danger'))); ?>"> <?= $value->status;?> </span></td>

																	</tr>
																<?php } ?>

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
					<!--  -->
					<div class="tab-pane p-3" id="messages-1" role="tabpanel">
						<div class="d-flex flex-column mb-4" style="width: 200px;">
							<!-- <a type="button" class="btn btn-primary btn-icon p-3" href="<?= $_SERVER['HTTP_REFERER'];?>">
								<span class="btn-icon-label"><i class="fa fa-eye mr-2"></i></span> Show OTC Detail
							</a> -->
							<label class="control-label">One Time Cost Detail</label>
							<a type="button" class="btn btn-secondary btn-block waves-effect waves-light" href="<?= base_url();?>/billing/otc/<?= $info->id;?>">&nbsp;&nbsp;Show OTC Details </a>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
								
								<div style="overflow-x: auto;padding-bottom:10px;">
									<table id="BillDetTable" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;border: 0; ">
										<thead>
											<tr>
												<th>#</th>
												<th>Invoice No.</th>
												<th>Contract No.</th>
												<th>Month</th>
												<th>Generate On</th>
												<th>Days</th>
												<th>Status</th>
												<th>View</th>
											</tr>
											<tbody>
												<?php 
												foreach($allBill->get()->getResult() as $key => $value){?>
													<tr>
														<td><?= $key+1;?></td>
														<td><?= $value->id;?></td>
														<td><?= $value->cont_id;?></td>
														<td><?= date('M Y',strtotime($value->bill_month));?></td>
														<td><?= date('M,d Y',strtotime($value->bill_date));?></td>
														<td><?= $value->bill_days;?></td>
														<td><span style="width:100%;font-size:15px;" class="badge badge-soft-<?= (($value->status == 'paid') ? 'success' : (($value->status == 'unpaid') ? 'warning' : 'danger')); ?>"> <?= $value->status;?> </span></td>
														<td><center>
															<!-- <a href="<?= base_url();?>/billing/invoice/<?= $value->id;?>" target="_blank"><i class="fa fa-file-pdf" style="font-size:20px;color:#e55151;"></i></a> -->
															<a href="<?= base_url();?>/report/customer_bill" target="_blank"><i class="fa fa-file-pdf" style="font-size:20px;color:#e55151;"></i></a>
														</center></td>
													</tr>
												<?php } ?>

											</tbody>

										</thead>
									</table>
								</div>

							</div>
						</div>
					</div>

					<!--  -->
					<div class="tab-pane p-3" id="tree-1" role="tabpanel">
						<div class="row">
							<div class="col-sm-12">
								<div style="overflow-x: auto;padding-bottom:10px;">
									
									<div class="body genealogy-body genealogy-scroll">
										<div class="genealogy-tree">
											<h3>Network Tree</h3>
											<!-- <ul>
												<li>
													<a href="javascript:void(0);">
														<div class="member-view-box">
															<div class="member-image">
																<i class="fa fa-satellite-dish"></i>
																<div class="member-details">
																	<h6>Data Center</h6>
																</div>
															</div>
														</div>
													</a> -->
													<?php if(!empty($ndt) && !empty($adt) && !empty($olt) && !empty($project) ){?>
														<ul class="active">
															<li>
																<a href="javascript:void(0);">
																	<div class="member-view-box">
																		<div class="member-image">
																			<h6><span class="custom-badge">City</span></h6>
																			<i class="fa fa-map"></i>
																			<div class="member-details">
																				<h6><?= $project->city;?></h6>
																			</div>
																		</div>
																	</div>
																</a>
															</li>
															<li>
																<a href="javascript:void(0);">
																	<div class="member-view-box">
																		<div class="member-image">
																			<h6><span class="custom-badge">Area</span></h6>
																			<i class="fa fa-map-marker"></i>
																			<div class="member-details">
																				<h6><?= $project->area;?></h6>
																			</div>
																		</div>
																	</div>
																</a>
															</li>
															<li>
																<a href="javascript:void(0);">
																	<div class="member-view-box">
																		<div class="member-image">
																			<h6><span class="custom-badge">OLT</span></h6>
																			<i class="fa fa-hdd child"></i>
																			<div class="member-details">
																				<!-- <h6>OLT</h6> -->
																			</div>
																		</div>
																	</div>
																</a>
																<ul>

																	<?php foreach($olt as $key => $value){?>
																		<li>
																			<a href="javascript:void(0);">
																				<div class="member-view-box">
																					<div class="member-image">
																						<h6><span class="custom-badge"><?= $key;?></span></h6>
																						<i class="fa fa-info"></i>
																						<div class="member-details">
																							<h6><?= wordwrap($value,10,"<br>\n");?></h6>
																						</div>
																					</div>
																				</div>
																			</a>
																		</li>
																	<?php } ?>

																</ul>
															</li>
															<li>
																<a href="javascript:void(0);">
																	<div class="member-view-box">
																		<div class="member-image">
																			<h6><span class="custom-badge">OLT Port</span></h6>
																			<i class="fa fa-plug"></i>
																			<div class="member-details">
																				<h6><?= $project->olt_port;?></h6>
																			</div>
																		</div>
																	</div>
																</a>
															</li>
															<li>
																<a href="javascript:void(0);">
																	<div class="member-view-box">
																		<div class="member-image">
																			<h6><span class="custom-badge">Project</span></h6>
																			<i class="fa fa-building"></i>
																			<div class="member-details">
																				<h6><?= $project->project;?></h6>
																			</div>
																		</div>
																	</div>
																</a>
															</li>
															<li>
																<a href="javascript:void(0);">
																	<div class="member-view-box">
																		<div class="member-image">
																			<h6><span class="custom-badge">NDT</span></h6>
																			<i class="fa fa-hdd child"></i>
																			<div class="member-details">
																				<h6></h6>
																			</div>
																		</div>
																	</div>
																</a>
																<ul>

																	<?php foreach($ndt as $key => $value){?>
																		<li>
																			<a href="javascript:void(0);">
																				<div class="member-view-box">
																					<div class="member-image">
																						<h6><span class="custom-badge"><?= $key;?></span></h6>
																						<i class="fa fa-info"></i>
																						<div class="member-details">
																							<h6><?php
																							if($key == 'core_color'){
																								echo '<i class="fa fa-square" style="font-size:17px;color:'.$value.'"></i>';
																							}else{
																								echo wordwrap($value,10,"<br>\n");
																							}
																						?></h6>
																					</div>
																				</div>
																			</div>
																		</a>
																	</li>
																<?php } ?>

															</ul>
														</li>
														<li>
															<a href="javascript:void(0);">
																<div class="member-view-box">
																	<h6><span class="custom-badge">ADT</span></h6>
																	<div class="member-image">
																		<i class="fa fa-hdd child"></i>
																		<div class="member-details">
																			<h6></h6>
																		</div>
																	</div>
																</div>
															</a>
															<ul>

																<?php foreach($adt as $key => $value){?>
																	<li>
																		<a href="javascript:void(0);">
																			<div class="member-view-box">
																				<div class="member-image">
																					<h6><span class="custom-badge"><?= $key;?></span></h6>
																					<i class="fa fa-info"></i>
																					<div class="member-details">
																						<h6><?= wordwrap($value,10,"<br>\n");?></h6>
																					</div>
																				</div>
																			</div>
																		</a>
																	</li>
																<?php } ?>
																
															</ul>
														</li>
														
														<li>
															<a href="javascript:void(0);">
																<div class="member-view-box">
																	<div class="member-image">
																		<h6><span class="custom-badge">Splitter Port</span></h6>
																		<i class="fa fa-plug"></i>
																		<div class="member-details">
																			<h6><?= $adt->splitter;?></h6>
																		</div>
																	</div>
																</div>
															</a>
														</li>
														<li>
															<a href="javascript:void(0);">
																<div class="member-view-box">
																	<div class="member-image">
																		<h6><span class="custom-badge">Customer</span></h6>
																		<i class="fa fa-user"></i>
																		<div class="member-details">
																			<h6><?= $adt->customer;?></h6>
																		</div>
																	</div>
																</div>
															</a>
														</li>
													</ul>
												<?php }else{ echo 'Can not create tree. Some data missing.';} ?>
												<!-- </li>
												</ul> -->
											</div>
										</div>	






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
echo view('cpanel/popup/otc_details');
echo view('cpanel-layout/footer');
?>
<script type="text/javascript">
	$(function () {
		$('.genealogy-tree ul').hide();
		$('.genealogy-tree>ul').show();
		$('.genealogy-tree ul.active').show();
		$('.genealogy-tree li').on('click', function (e) {
			var children = $(this).find('> ul');
			if (children.is(":visible")) children.hide('fast').removeClass('active');
			else children.show('fast').addClass('active');
			e.stopPropagation();
		});
	});

</script>

<script type="text/javascript">
	$(document).ready( function () {
		$('#PreContTable,#BillDetTable').DataTable();
	} );
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#custUpdateForm").submit(function() {
			$.ajax({
				type: "POST",
				url: '<?php echo base_url();?>/customer/update_action',
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function (data) {
					if(data.includes('Success')){
						toastr.success(data);
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
<script type="text/javascript">
	$(document).on('click','#deactiveBtn',function(){
		if(confirm("Do you really want to deactive this contract?")){
			$('#action_loader').modal('show');
			var custid = $('#custID').val();
			$.ajax({
				type: "POST",
				url: '<?php echo base_url();?>/customer/deactiveContract',
				data:'custid='+custid,
				success: function (data) {
					toastr.success(data);
					location.reload();
				},
				error: function(jqXHR, text, error){
					toastr.error(error);
					$('#action_loader').modal('hide');
				}
			});
		}
	});
</script>
<script type="text/javascript">
	$(document).on('click','#activeBtn',function(){
		if(confirm("Do you really want to active this?")){
			$('#action_loader').modal('show');
			var custid = $('#custID').val();
			$.ajax({
				type: "POST",
				url: '<?php echo base_url();?>/customer/activeContract',
				data:'custid='+custid,
				success: function (data) {
					toastr.success(data);
					location.reload();
				},
				error: function(jqXHR, text, error){
					toastr.error(error);
					$('#action_loader').modal('hide');
				}
			});
		}
	});
</script>
<script>
	$(document).on('change','#blockPanel',function(){

		$.ajax({
			type: "POST",
			url: '<?php echo base_url();?>/customer/enableDisableCustomer',
			data:$("#enableDisableForm").serialize(),
			success: function(data){
				toastr.success(data);
			},
				error: function(jqXHR, text, error){
					toastr.error(error);
				}
		});
	});
</script>

