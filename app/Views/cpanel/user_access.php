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
						<h4 class="page-title">User <small>Access Control</small></h4>
					</div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-md-12">

					<div class="card">
						<div class="card-body">

							<!-- <h4 class="mt-0 header-title">Accordion example</h4> -->
							<!-- <p class="text-muted mb-4">Extend the default collapse behavior to create an accordion.</p> -->


							<div id="accordion">
								<?php
								foreach ($data1->get()->getResult() as $value) {
									?>
									<div class="card mb-1">
										<div class="card-header p-3" id="headingOne">
											<h6 class="m-0 font-14">
												<a href="#<?= $value->username;?>" class="text-dark" data-toggle="collapse"
													aria-expanded="true"
													aria-controls="<?= $value->username;?>">
													<?= ucfirst($value->firstname).' '.ucfirst($value->lastname);?><small><?=" (".$value->status.")"?></small>
												</a>
											</h6>
										</div>

										<div id="<?= $value->username;?>" class="collapse"
											aria-labelledby="headingOne" data-parent="#accordion">
											<div class="card-body">

												<div class="panel-body table-responsive" style="height: 250px;overflow-y: scroll;">
													<table class="table table-striped responsive" style="overflow-x: auto;">
														<thead>
															<tr>
																<th>#</th>
																<th>Category</th>
																<th>Module</th>
																<th>View</th>
																<th>Create</th>
																<th>Update</th>
																<th>Delete</th>

															</tr>
														</thead>
														<tbody>
															<?php
															$user='user'.$value->id;
															$id = $value->id;
															$num=0;
															//
															$data2 = $modelUser->submenu_list();
															//
															foreach($data2->get()->getResult() as $value){
																$module=$value->id;
																$modelUser->get_main_menu($value->menu_id)->get()->getRow()->menu;
																$num++;
																?>
																<tr>
																	<th scope="row"><?php echo $num;?></th>
																	<td><?php echo $modelUser->get_main_menu($value->menu_id)->get()->getRow()->menu;?></td>
																	<td><?php echo $value->submenu;?></td>
																	
																	<?php if(access_crud($value->submenu,'view',$id)){
																		$check='checked';
																	}else{
																		$check='';
																	}?>
																	<td><!-- create switch -->

																		<input type="checkbox" name="block" class="switchBtn" id="view<?= $id.$module;?>" switch="success" onchange="crud_flip('<?php echo $module;?>','<?php echo $id;?>','view')" <?php echo $check;?>/>
																		<label for="view<?= $id.$module;?>" data-on-label="ON" data-off-label="OFF"></label>

																	</td>
																	<?php if(access_crud($value->submenu,'create',$id)){
																		$check='checked';
																	}else{
																		$check='';
																	}?>
																	<td><!-- create switch -->
																		<input type="checkbox" name="block" class="switchBtn" id="create<?= $id.$module;?>" switch="success" onchange="crud_flip('<?php echo $module;?>','<?php echo $id;?>','create')" <?php echo $check;?>/>
																		<label for="create<?= $id.$module;?>" data-on-label="ON" data-off-label="OFF"></label>
																	</td>
																	<?php if(access_crud($value->submenu,'update',$id)){
																		$check='checked';
																	}else{
																		$check='';
																	}?>
																	<td><!-- create switch -->
																		<input type="checkbox" name="block" class="switchBtn" id="update<?= $id.$module;?>" switch="success" onchange="crud_flip('<?php echo $module;?>','<?php echo $id;?>','update')" <?php echo $check;?>/>
																		<label for="update<?= $id.$module;?>" data-on-label="ON" data-off-label="OFF"></label>
																	</td>
																	<?php if(access_crud($value->submenu,'delete',$id)){
																		$check='checked';
																	}else{
																		$check='';
																	}?>
																	<td><!-- create switch -->
																		<input type="checkbox" name="block" class="switchBtn" id="delete<?= $id.$module;?>" switch="success" onchange="crud_flip('<?php echo $module;?>','<?php echo $id;?>','delete')" <?php echo $check;?>/>
																		<label for="delete<?= $id.$module;?>" data-on-label="ON" data-off-label="OFF"></label>
																	</td>

																</tr>

															<?php } ?>
														</tbody>
													</table>
												</div>

											</div>
										</div>
									</div>
								<?php } ?>
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
// echo view('cpanel-layout/action_loader');
echo view('cpanel-layout/footer');
?>

<script>
	function crud_flip(mod,user,operation) {
//
$.ajax({
	type: "POST",
	url: "<?php echo base_url();?>/user/crud_flip",
	data:'module='+mod+'&user='+user+'&operation='+operation,
	success: function(data){

// for get return data
$("#output").html(data);
}
});
}
</script>
