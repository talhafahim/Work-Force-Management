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
						<h4 class="page-title">Allow Access <br><small><?= $userInfo->firstname.' '.$userInfo->lastname ;?> </small></h4>
					</div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-md-12">

					<div class="card">


						<div class="card-body">

							<div style="overflow-x:scroll;">
								<table id="table1" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
									<thead>
										<tr>
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
										//
										foreach($data2->get()->getResult() as $key => $value){
											$module=$value->id;

											?>
											<tr>
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
	<script type="text/javascript">
		$(document).ready( function () {
			$('#table1').DataTable();
		} );
	</script>
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
