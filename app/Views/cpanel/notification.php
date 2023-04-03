<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End
?>
<link href="<?= base_url();?>/assets/css/select2.min.css" rel="stylesheet" type="text/css">
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">Create New Message</h4>
					</div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">


							<form id="myform">
								<div class="form-group">
									<!-- <label for="datetime">Reminder Date Time:</label> -->
									<input id="datetime" type="hidden" name="reminderDate" class="form-control" placeholder="Reminder Date Time" required value="<?= date('Y-m-d H:i:s');?>">
								</div>
								<div class="form-group" id="reminder_for_group">
									<label for="remind_for">Message For:</label>
									<select name="remind_for[]" class="form-control js-example-basic-multiple" id="remind_for" multiple="multiple" required>
										<?php if (count($all_users_result) > 0): ?>
											<?php foreach ($all_users_result as $key => $user): ?>
												<option value="<?php echo $user->id ?>"><?= $user->firstname.' '.$user->lastname.' ('.$user->status.')' ?></option>
											<?php endforeach ?>
										<?php endif ?>
									</select>
								</div>
						    <!-- <div class="checkbox">
						        <label><input id="select_all_users" type="checkbox" name="select_all"> <i class="fa fa-broadcast-tower"></i> Broadcast</label>
						    </div> -->
				            <!-- <div class="form-group hide" id="except_users_group">
				              <label for="except_users">Except users if any:</label>
				              <select name="except_users[]" class="form-control js-example-basic-multiple" id="except_users" multiple="multiple" style="width:100%;">
				              	<?php if (count($all_users_result) > 0): ?>
				              		<?php foreach ($all_users_result as $key => $user): ?>
				        		      	<option value="<?php echo $user->id ?>"><?php echo $user->username .' ('.$user->firstname.' '.$user->lastname.')' ?></option>
				              		<?php endforeach ?>
				              	<?php endif ?>
				              </select>
				          </div> -->
				          <div class="form-group">
				          	<label for="remindTitle">Title:</label>
				          	<input id="remindTitle" type="text" name="title" class="form-control" placeholder="Reminder Title" required>
				          </div>
				          <div class="form-group">
				          	<label for="ckEditor">Text:</label>
				          	<textarea name="content" class="form-control" cols="30" rows="5"></textarea>
				          </div>
				          <div class="form-group">
				          	<button type="submit" class="btn btn-primary" style="float:right;"><i class="fa fa-send"></i> Send </button>
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
<script src="<?= base_url();?>/assets/js/select2.min.js"></script>
<script type="text/javascript">
	$('.js-example-basic-multiple').select2({
		placeholder: 'Select User',
		allowClear: true
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#myform").submit(function() {
			$('#action_loader').modal('show');
			$.ajax({
				type: "POST",
				url: '<?php echo base_url();?>/tools/set_reminder',
				data:$("#myform").serialize(),
				success: function (data) {
					setTimeout(function(){ 
						$('#action_loader').modal('hide');
						toastr.success(data);
						$('#myform').trigger('reset');
						
					}, 1000);
					
				},
				error: function(jqXHR, text, error){
					toastr.error(error);	
				}
			});
			return false;
		});
	});
</script>
