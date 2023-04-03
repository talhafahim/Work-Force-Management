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
						<h4 class="page-title">Taxation <small>List</small></h4>
					</div>
                    <div class="col-sm-6">
                        <div class="float-right">
                            <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                              <a type="button" class="btn btn-secondary btn-icon" href="<?= $_SERVER['HTTP_REFERER'];?>">
                                <span class="btn-icon-label"><i class="fa fa-arrow-left mr-2"></i></span> Go Back
                            </a>
                        <?php } ?>
                        <a type="button" class="btn btn-primary btn-icon" href="<?= base_url();?>/taxation/create">
                            <span class="btn-icon-label"><i class="fa fa-plus mr-2"></i></span> Create New
                        </a>
                    </div>
                </div>
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
                                        <th>#</th>
                                        <th>City</th>
                                        <th>Internet sst</th>
                                        <th>Internet adv</th>
                                        <th>Tv sst</th>
                                        <th>Tv adv</th>
                                        <th>Phone sst</th>
                                        <th>Phone adv</th>
                                        <th>Action</th>
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

<!-- content -->
<?php 
// echo view('cpanel-layout/action_loader');
echo view('cpanel-layout/footer');
echo view('cpanel/popup/view_taxation');
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
            url: '<?php echo base_url();?>/taxation/show_list',
            success: function(data){
                $('#tbody1').html(data);
                $('#table1').DataTable();
            }
        })
    }
</script>
<script>
    $(document).on('click','.infoBtn',function(){
        var val = $(this).attr('data-userid');
        $('#viewTable tr td').html('');
        $('#viewDiv #loading').show();
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "<?php echo base_url();?>/taxation/view",
            data:'custID='+val,
            success: function(data){
              $('#viewCustomerModel').modal('show');
              setTimeout(function(){ 
                    //
                $('#viewDiv #city').html(data.info.city);
                $('#viewDiv #int_sst').html(data.info.int_sst);
                $('#viewDiv #int_adv').html(data.info.int_adv);
                $('#viewDiv #tv_sst').html(data.info.tv_sst);
                $('#viewDiv #tv_adv').html(data.info.tv_adv);
                $('#viewDiv #phone_sst').html(data.info.phone_sst);
                $('#viewDiv #phone_adv').html(data.info.phone_adv);

                    //
                $('#viewDiv #loading').hide();
            }, 1000);
          }
      });
    });
</script>
<script>
    $(document).on('click','.delBtn',function(){
        var val = $(this).attr('data-userid');
//
        if(confirm("Do you really want to delete this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>/taxation/delete",
                data:'id='+val,
                success: function(data){
                    user_fetchdata();
                    toastr.success(data);
                },error: function(jqXHR, text, error){
                    toastr.error(error);
                }
            });
        }
    });
</script>


