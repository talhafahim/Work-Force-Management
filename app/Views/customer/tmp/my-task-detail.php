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
                        <h4 class="page-title">My Task <small>Detail List</small></h4>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right">

                            <h4 class="page-title">UN# <small><?= $un;?></small></h4>
                            <!-- <select class="btn btn-secondary btn-icon" id="idFilter" name="status">
                                <option>schedule</option>
                                <option>travelling</option>
                                <option>on site</option>
                                <option>complete</option>
                            </select> -->
                    
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
                            <table id="table1" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>UN#</th>
                                        <th>Meter#</th>
                                        <!-- <th>Sector</th> -->
                                        <!-- <th>Plot</th> -->
                                        <th>Address</th>
                                        <!-- <th>Per Name EN</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody1">

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


<script>
    $(document).ready(function(){
        user_fetchdata('<?= $un;?>');
    });
    //
    // $(document).on('change','#idFilter',function(){
    //     var status = $(this).val();
    //     user_fetchdata(status);
    // });
    //
    function user_fetchdata(status){
        var loader = `<tr><td colspan="11" class="text-center"><div class="spinner-border text-primary" role="status" id="loading"></div></td></tr>`;
        $('#table1').dataTable().fnDestroy();
        $('#tbody1').html(loader);
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url();?>/task/task_detail_content',
            data:'un='+status,
            success: function(data){
                $('#tbody1').html(data);
                $('#table1').DataTable();
            }
        })
    }

 </script>
