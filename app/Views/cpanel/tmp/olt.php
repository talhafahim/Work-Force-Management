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
						<h4 class="page-title">OLT <small>Optical Line Terminal</small></h4>
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
                   <form id="oltAddForm">
                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" placeholder="OLT Name" name="name" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" placeholder="Version" name="version" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" placeholder="IP" name="ip" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" placeholder="Model" name="model" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="text" class="form-control" placeholder="Port" name="port" required>
                        </div>
                        <div class="col-md-3 mb-3">
                           <select name="pop" id="pop" class="form-control" required>
                            <option value="">Select Pop</option>
                            <?php foreach($pop as $value){ ?>
                                <option><?= $value->pop_name;?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" class="form-control" placeholder="Connected to" name="connectedto" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-primary btn-block" type="submit" style="float:right;">Add New</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div style="overflow-x:scroll;">
                    <table id="table1" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Version</th>
                                <th>IP</th>
                                <th>Model</th>
                                <th>Port</th>
                            </tr>
                        </thead>
                        <tbody id="tbody1">
                            <?php foreach($olt->get()->getResult() as $key => $value){?>
                                <tr>
                                    <td><?= $key+1;?></td>
                                    <td><?= $value->name;?></td>
                                    <td><?= $value->version;?></td>
                                    <td><?= $value->ip;?></td>
                                    <td><?= $value->model;?></td>
                                    <td><?= $value->port;?></td>
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
        $("#oltAddForm").submit(function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/network/add_olt',
                data:$("#oltAddForm").serialize(),
                success: function (data) {
                 toastr.success(data);
                 setTimeout(function(){ 
                    location.reload();
                }, 2000);
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
        url: "<?php echo base_url();?>/network/delete",
        data:'ser='+val+'&des=olt',
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

