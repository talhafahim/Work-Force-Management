<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End
?>
<!--  -->
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">Users <small>List</small></h4>
					</div>
                    <div class="col-sm-6">
                        <div class="float-right">
                            <?php if(isset($_SERVER['HTTP_REFERER'])){ ?>
                              <!-- <a type="button" class="btn btn-secondary btn-icon" href="<?= $_SERVER['HTTP_REFERER'];?>">
                                <span class="btn-icon-label"><i class="fa fa-arrow-left mr-2"></i></span> Go Back
                            </a> -->
                        <?php } ?>
                        <button type="button" class="btn btn-primary btn-icon" onclick="$('#addUserModel').modal('show');">
                            <span class="btn-icon-label"><i class="fa fa-user-plus mr-2"></i></span>Add New User
                        </button>
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
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Status</th>
                                        <th>Active|Block</th>
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

<!-- sample modal content -->
<div id="updateModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">User Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updUserForm" class="form-horizontal form-label-left input_mask">
                <div class="modal-body" id="updateuser">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- content -->
<?php 
// echo view('cpanel-layout/action_loader');
echo view('cpanel-layout/footer');
echo view('cpanel/popup/add_user');
?>
<script>

   $(document).ready(function() {

   });
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
        url: '<?php echo base_url();?>/User/show_users',
        success: function(data){
            $('#tbody1').html(data);
            $('#table1').DataTable();
        }
    })
}
</script>
<script>
    $(document).on('click','.updUserBtn',function(){
        var val = $(this).attr('data-userid');
        // alert(val);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>/User/update_form",
            data:'userid='+val,
            success: function(data){
                $("#updateuser").html(data);
                $('#updateModel').modal('show');

                $('#updateModel').find('#deviceList').select2({
                    placeholder: 'select device and tools',
                    allowClear: true,
                });

            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#updUserForm").submit(function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/user/update_user',
                data:$("#updUserForm").serialize(),
                success: function (data) {
                    if(data.includes('Success')){
                        toastr.success(data);
                        $('#updateModel').modal('hide');
                        user_fetchdata();
                    }else{
                        toastr.error(data);
                    }
                },
                error: function(jqXHR, text, error){
// Displaying if there are any errors

                }
            });
            return false;
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#adduserform").submit(function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/user/add_user',
                data:$("#adduserform").serialize(),
                success: function (data) {
                    if(data.includes('Success')){
                        toastr.success(data);
                        $('#addUserModel').modal('hide');
                        $('#adduserform').trigger('reset');
                        user_fetchdata();
                    }else{
                        toastr.error(data);
                    }
                },
                error: function(jqXHR, text, error){
// Displaying if there are any errors
                    $('#addoutput').hide();
                    $('#error').show();
                    $('#error').html('Error:Username already exist');

                }
            });
            return false;
        });
    });
</script>
<script>
    $(document).on('click','.delUserBtn',function(){
        var val = $(this).attr('data-userid');
//
        if(confirm("Do you really want to delete this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>/user/delete_user",
                data:'id='+val,
                success: function(data){
                    user_fetchdata();
            // snack('#59b35a','User Deleted Successfully','check-square-o');
                    toastr.success(data);
                },error: function(jqXHR, text, error){
                    toastr.error(error);
                }
            });
        }
    });
</script>