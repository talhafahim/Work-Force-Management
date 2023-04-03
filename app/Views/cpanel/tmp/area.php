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
						<h4 class="page-title">Area <small></small></h4>
					</div>
                    <!-- <div class="col-sm-6">
                        <div class="float-right">
                          <button type="button" class="btn btn-primary btn-icon" onclick="$('#addUserModel').modal('show');">
                            <span class="btn-icon-label"><i class="fa fa-user-plus mr-2"></i></span>Add New User
                        </button>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- end row -->
        <div class="d-flex justify-content-end">
            <a class="btn btn-primary mb-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa fa-plus"></i> Add New
            </a>
        </div>
        <div class="collapse" id="collapseExample">
            <div class="card">
                <div class="card-body">
                    <form id="addNewAreaForm">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="city" class="form-control" required>
                                    <option value="">select city</option>
                                    <?php foreach ($city->get() -> getResult() as $value) { ?>
                                        <option value="<?= $value->city;?>"><?= $value->city;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Area Name" name="area" required>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-block" type="submit">Add</button>  
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">

            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div style="overflow-x:scroll;">
                            <table id="table1" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>City</th>
                                        <th>Area</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody1">
                                    <?php foreach($area->get()->getResult() as $key => $value){?>
                                        <tr>
                                            <td><?= $key+1;?></td>
                                            <td><?= $value->city;?></td>
                                            <td><?= $value->area;?></td>
                                            <td>
                                                <a href="javascript:void(0);" class="text-danger delete" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-serial="<?php echo $value->id;?>"><i class="fa fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
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
<script type="text/javascript">
    $(document).ready( function () {
        $('#table1').DataTable();
    } );
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addNewAreaForm").submit(function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/project/add_area',
                data:$("#addNewAreaForm").serialize(),
                success: function (data) {
                   toastr.success(data);
                   location.reload(); 
               },
               error: function(jqXHR, text, error){
                    // Displaying if there are any errors
                    toastr.error(error);
                }
            });
            return false;
        });
    });
</script>
<script>
    $(document).on('click','.delete',function(){
        var val = $(this).attr('data-serial');
//
if(confirm("Do you really want to delete this?")){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>/project/delete",
        data:'ser='+val+'&des=area',
        success: function(data){
            toastr.success(data);
            setTimeout(function(){ 
                location.reload();
            }, 2000);    
        },error: function(jqXHR, text, error){
            toastr.error(error);
        }
    });
}
});
</script>