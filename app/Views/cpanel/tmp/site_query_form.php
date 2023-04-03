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
					<div class="col-sm-12">
						<h4 class="page-title">Query Form</h4>
					</div>
				</div>
			</div>
		</div>
		<!-- end row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div style="overflow-x:scroll;">
							<table id="queryTable" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Email</th>
										<th>Phone</th>
										<th>City</th>
										<th>Area</th>
										<th>Subject</th>
										<th>Messages</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="query_tbody">
                                <?php 
                                $sNo = 0;
                                foreach($contact as $value) {
                                    $sNo++; ?>
									<tr>
										<td><?= $sNo ?></td>
										<td><?= $value->name ?></td>
										<td><?= $value->email ?></td>
										<td><?= $value->phone ?></td>
										<td><?= $value->city ?></td>
										<td><?= $value->area ?></td>
										<td><?= $value->subject ?></td>
										<td><?= $value->message ?></td>
										<td><?= $value->datetime ?></td>
                                        <td>
                                            <a href="javascript:void(0);" class="text-danger delformtBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-formid="<?php echo $value->serial;?>"><i class="fa fa-trash-alt"></i></a>
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
	</div>
</div>

<footer class="footer">© 2021 <span class="d-none d-sm-inline-block">- Design & Developed with <i class="mdi mdi-heart text-danger"></i> by LOGON</span>.</footer>
</div>
<?php 
    echo view('cpanel-layout/footer');
?>

<script>
    $(document).ready(function() {
        $('#queryTable').DataTable();
    } );
</script>

<script>
    $(document).on('click','.delFormBtn',function(){
        var val = $(this).attr('data-formid');  

        if(confirm("Do you really want to delete this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>/Site_Home/delete_query",
                data:'id='+val,
                success: function(data){
                    toastr.success(data);
                    location.reload();
                },error: function(jqXHR, text, error){
                    toastr.error(error);
                }
            });
        }
    });
</script>


