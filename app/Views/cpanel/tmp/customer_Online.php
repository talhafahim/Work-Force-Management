<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End

?>
<style>
    .hide select{
      display:none;
  }
</style>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">Customer <small>Online</small></h4>
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
                  <!--   <div class="col-sm-6">
                        <div class="float-right">
                          <a type="button" class="btn btn-primary btn-icon" href="<?= base_url();?>/customer/create">
                            <span class="btn-icon-label"><i class="fa fa-user-plus mr-2"></i></span> Create New
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- end row -->
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div style="overflow-x:scroll;">
                            <table id="table1" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Session Start Time</th>
                                        <th>MAC Address</th>
                                        <th>Framed IP Address</th>
                                        <th>Package</th>
                                        <th>Status</th>
                                    </tr>

                                    <tr>
                                        <td class="hide"></td>
                                        <td class="hide"></td>
                                        <td class="hide"></td>
                                        <td class="hide"></td>
                                        <td></td>
                                        <td class="hide"></td>
                                    </tr>
                                </thead>
                                <tbody id="tbody1">

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

<!-- sample modal content -->

<!-- content -->
<?php 
// echo view('cpanel-layout/action_loader');
echo view('cpanel-layout/footer');
echo view('cpanel/popup/view_customer');
?>
<script>
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
            url: '<?php echo base_url();?>/Customer/get_online_users',
            success: function(data){
                $('#tbody1').html(data);
                var table = $('#table1').DataTable();

            // Filters Starts
                $("#table1 thead td").each(function(i){
                    var select = $('<select class="form-control"><option value="">Show All</option></select>')
                    .appendTo( $(this).empty() )
                    .on( 'change', function () {
                        table.column( i )
                        .search( $(this).val() )
                        .draw();
                    });

                    table.column( i ).data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    });
                });
            // Filter ends


            }
        })
    }
</script>



