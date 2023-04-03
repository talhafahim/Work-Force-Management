<!-- sample modal content -->
<div id="viewCustomerModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="myModalLabel">Customer Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="viewDiv">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<center>
								<div class="spinner-border text-primary" role="status" id="loading">
									<span class="sr-only">Loading...</span>
								</div>
							</center>
						</div>

						<div class="col-md-6">
							<div class="table-responsive">
								<h5><center>Personal Details</center></h5>
								<table class="table table-bordered mb-0 table-striped" id="viewTable">

									
										<tr>
											<th>Username</th>
											<td id="username"></td>
										</tr>
										<tr>
											<th>First Name</th>
											<td id="fname"></td>
										</tr>
										<tr>
											<th>Last Name</th>
											<td id="lname"></td>
										</tr>
										<tr>
											<th>CNIC#</th>
											<td id="cnic"></td>
										</tr>
										<tr>
											<th>Mobile#</th>
											<td id="mobile"></td>
										</tr>
										<tr>
											<th>Phone#</th>
											<td id="phone"></td>
										</tr>
										<tr>
											<th>Email Address</th>
											<td id="email"></td>
										</tr>
										<tr>
											<th>Passport#</th>
											<td id="passport"></td>
										</tr>
										<tr>
											<th>City</th>
											<td id="city"></td>
										</tr>
										<tr>
											<th>Address</th>
											<td id="address"></td>
										</tr>
										<tr>
											<th>Creation Date</th>
											<td id="createDate"></td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="table-responsive">
								<h5><center>Active Contract Details</center></h5>
								<center><span id="noActCont" class="badge badge-soft-danger"></span></center>
								<table class="table table-bordered mb-0 table-striped" id="contTable">
										<tr>
											<th>Package Name</th>
											<td id="package"></td>
										</tr>
										<tr>
											<th>Internet Bandwidth</th>
											<td id="bandwidth"></td>
										</tr>
										<tr>
											<th>Internet Service</th>
											<td id="intQty"></td>
										</tr>
										<tr>
											<th>TV Service</th>
											<td id="tvQty"></td>
										</tr>
										<tr>
											<th>Phone Service</th>
											<td id="phQty"></td>
										</tr>
										<tr>
											<th>Start Date</th>
											<td id="startDate"></td>
										</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
	$(document).on('click','.infoBtn',function(){
		var val = $(this).attr('data-userid');
		$('#viewTable,#contTable').hide();
		$('#noActCont').html('');

		$('#viewDiv #loading').show();
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "<?php echo base_url();?>/customer/view",
			data:'custID='+val,
			success: function(data){
				$('#viewCustomerModel').modal('show');
				setTimeout(function(){ 
                    //
                    $('#viewDiv #username').html(data.info.username);
                    $('#viewDiv #fname').html(data.info.firstname);
                    $('#viewDiv #lname').html(data.info.lastname);
                    $('#viewDiv #cnic').html(data.info.nic);
                    $('#viewDiv #mobile').html(data.info.mobilephone);
                    $('#viewDiv #phone').html(data.info.phone);
                    $('#viewDiv #email').html(data.info.email);
                    $('#viewDiv #passport').html(data.info.passport);
                    $('#viewDiv #city').html(data.info.city);
                    $('#viewDiv #address').html(data.info.address);
                    $('#viewDiv #createDate').html(data.info.created_at);
                    //
                   	$('#viewTable').show();
                    //
                    if ( jQuery.isEmptyObject( data.cont ) ) {
                    	$('#noActCont').html('No Active Contract');
                    }else{

                    	$('#viewDiv #package').html(data.pkg.name);
                    	$('#viewDiv #bandwidth').html(data.pkg.bandwidth+' Mbps');
                    	$('#viewDiv #intQty').html(data.cont.int_qty);
                    	$('#viewDiv #tvQty').html(data.cont.tv_qty);
                    	$('#viewDiv #phQty').html(data.cont.ph_qty);
                    	$('#viewDiv #startDate').html(data.cont.start_date);
                    	//
                    	$('#contTable').show();
                    }
                    
                    //
                    $('#viewDiv #loading').hide();
                }, 1000);
			}
		});
	});
</script>