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
						<h4 class="page-title">Team Detail<small></small></h4>
					</div>
                    <div class="col-sm-6">
                        <div class="float-right">

                            <!-- <button class="btn btn-success mb-3" onclick="exportTableToCSV('#table1','export.csv')">
                                <i class="fa fa-download"></i> Download Sheet
                            </button> -->


                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        <!-- <div class="d-flex justify-content-end">
            
        </div> -->
        
        <div class="row">


            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div style="overflow-x:scroll;">
                            <table id="table1" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
                                <thead>
                                    <tr>
                                        <th>Team Name</th>
                                        <th>Engineer</th>
                                        <th>Technician</th>
                                        <th>Driver</th>
                                        <th>Trainee</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody1">
                                    <!--  -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->

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
    //
   $(document).ready(function(){
    user_fetchdata();
});
  //
   function user_fetchdata(){
    var loader = `<tr><td colspan="10" class="text-center"><div class="spinner-border text-primary" role="status" id="loading"></div></td></tr>`;
    $('#table1').dataTable().fnDestroy();
    $('#tbody1').html(loader);
    $.ajax({
        method: 'POST',
        url: '<?php echo base_url();?>/team/show_team_detail_content',
        success: function(data){
            $('#tbody1').html(data);
            $('#table1').DataTable();
        }
    })
}
</script>

