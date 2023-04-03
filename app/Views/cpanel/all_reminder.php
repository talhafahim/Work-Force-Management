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
						<h4 class="page-title">All Messages</h4>
					</div>
					<div class="col-sm-6">
                        <div class="float-right">
                          <a class="btn btn-primary mb-3" href="<?= base_url();?>/message/create"><i class="fa fa-plus"></i> Create New
                        </a>
                    </div>
                </div>
				</div>
			</div>
			<!-- end row -->
			<div class="row">
				<div class="col-md-12">
					


					<div class="card shadow mb-4 border-left-secondary">
			<!-- <div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary" style="float:left;">All Notifications</h6>
			</div> -->
			<div class="card-body">

				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link tabclick active" id="requested" data-toggle="tab" href="#tab1" role="tab" aria-controls="Reqtable" aria-selected="true">My Messages</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link tabclick" id="issued" data-toggle="tab" href="#tab2" role="tab" aria-controls="Isstable" aria-selected="false">Messages For Me</a>
					</li>

				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="requested">
						<div style="overflow-x: auto;margin-top: 22px;">
							<table id="Reqtable" class="table table-striped table-bordered  ">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th class="">Title</th>
										<th class="text-center">Date</th>
										<th class="text-center">Time</th>
										<th style="width:200px;" class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php if (count($myreminderlist) > 0): ?>
										<?php foreach ($myreminderlist as $key => $value): ?>
											<tr>
												<td class="text-center"><?php echo $key+1; ?></td>
												<td><?php echo $value->title;?></td>
												<td class="text-center"><?php echo $value->remind_date;?></td>
												<td class="text-center"><?php echo date("g:i a", strtotime($value->time));?></td>
												<td class="text-center">
													<?php 
													$dateTimeStored = $value->remind_date.' '.$value->time;
													$date = strtotime($dateTimeStored);
													$current = strtotime(date('Y-m-d H:i:s'));
													?>
													<button class="btn btn-primary btn-sm ViewRemind" data-my_reminder="1" data-rem_id="<?php echo $value->rem_id?>"><i class="fa fa-info"></i></button>
													<?php if ($date > $current && $value->user_id == session()->get('id')): ?>
													<button class="btn btn-danger btn-sm" onclick="deleteid('<?php echo $value->rem_id?>')"><i class="fa fa-trash"></i></button>

												<?php endif ?>
											</td>
										</tr>
									<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="issued">
					<div style="overflow-x: auto;margin-top: 22px;">
						<table id="Isstable" class="table table-striped table-bordered  ">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">From</th>
									<th class="">Title</th>
									<th class="text-center">Date</th>
									<th class="text-center">Time</th>
									<th style="width:200px;" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if (count($reminderlist) > 0): ?>
									<?php foreach ($reminderlist as $key => $value): ?>
										<tr>
											<td class="text-center"><?php echo $key+1; ?></td>
											<td><?php echo ucfirst($value->firstname); ?></td>
											<td><?php echo $value->title;?></td>
											<td class="text-center"><?php echo $value->remind_date;?></td>
											<td class="text-center"><?php echo date("g:i a", strtotime($value->time));?></td>
											<td class="text-center">
												<button class="btn btn-primary btn-sm ViewRemind" data-my_reminder="0" data-rem_id="<?php echo $value->rem_id?>"><i class="fa fa-info"></i></button>
											</td>
										</tr>
									<?php endforeach ?>
								<?php endif ?>
							</tbody>
						</table>
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
echo view('cpanel/popup/notification_view');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#Isstable').dataTable();
		$('#Reqtable').dataTable();
	});
</script>
