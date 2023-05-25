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
						<h4 class="page-title">Devices & Tools <small></small></h4>
					</div>
                    <div class="col-sm-6">
                        <div class="float-right">
                          <a class="btn btn-primary mb-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <!-- <div class="d-flex justify-content-end">
            
        </div> -->
        
        <div class="collapse" id="collapseExample">
            <div class="card">
                <div class="card-body">
                    <form id="addNewCityForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                               <input type="text" class="form-control" placeholder="Name" name="name" required>
                           </div>
                           <div class="col-md-3 mb-3">
                            <button class="btn btn-primary" type="submit">Add</button>
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
                                    <th>In Stock</th>
                                    <th>Action</th>
                                    <th>Assign</th>
                                </tr>
                            </thead>
                            <tbody id="tbody1">
                                <?php foreach($devices_n_tools->get()->getResult() as $key => $value){
                                    ?>
                                    <tr>
                                        <td><?= $key+1;?></td>
                                        <td><?= $value->name;?></td>
                                        <td><?= $modelGeneral->get_devices_detail($value->id,null,'in stock')->countAllResults(); ?></td>
                                        <td>
                                           <a href="javascript:void(0);" class="text-info edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" data-id="<?= $value->id;?>" data-name="<?= $value->name;?>"><i class="fa fa-edit"></i></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a href="javascript:void(0);" class="text-danger delete" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-serial="<?= $value->id;?>"><i class="fa fa-trash-alt"></i></a>
                                       </td>
                                       <td>
                                        <button class="btn btn-primary btn-sm assignBtn" data-id="<?= $value->id;?>" data-name="<?= $value->name;?>">Assign to</button>
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


<!-- sample modal content -->
<div id="assignModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Assign</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updUserForm" class="form-horizontal form-label-left input_mask">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                           <div class="form-group"> 
                            <label for="exampleFormControlInput1">Assign To</label>
                            <select class="form-control js-select2" required="" name="technician_id">
                                <option value="">select whom to assign</option>
                                <?php foreach ($users->get()->getResult() as $value) { ?>
                                    <option value="<?= $value->id;?>" ><?= $value->firstname.' '.$value->lastname;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="hidden" name="deviceId" id="otherEquipmentId">
                        <input type="text" class="form-control" id="otherEquipment" readonly>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="serial" placeholder="serial/unique id">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Assign Now</button>
            </div>
        </form>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- sample modal content -->
<div id="uploadModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Update Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadDataForm">
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="deviceId" id="otherEquipmentId">
                        <input type="text" class="form-control" id="otherEquipment" readonly>
                    </div>
                    <div class="col-md-6">
                        <input type="file" class="form-control" name="file" required>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="<?= base_url();?>/csv_sample_files/device.csv" class="btn btn-info waves-effect">Download Sample File</a>
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
            </div>
        </form>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
        $("#addNewCityForm").submit(function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/general/add_devices_n_tools',
                data:$("#addNewCityForm").serialize(),
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


<script type="text/javascript">
   $(document).on('click','.assignBtn',function(){
    $("#updUserForm").trigger('reset');
    var dataname = $(this).attr('data-name');
    $('#updUserForm #otherEquipment').val(dataname);
    var dataid = $(this).attr('data-id');
    $('#updUserForm #otherEquipmentId').val(dataid);
        //
    $('#assignModel').modal('show');
        //
});


   $(document).on('click','.edit',function(){
    $("#uploadDataForm").trigger('reset');
    var dataname = $(this).attr('data-name');
    $('#uploadDataForm #otherEquipment').val(dataname);
    var dataid = $(this).attr('data-id');
    $('#uploadDataForm #otherEquipmentId').val(dataid);
        //
    $('#uploadModel').modal('show');
        //
});

   // ///////////////////////////////////////////////////

   $(document).ready(function() {
    $("#updUserForm").submit(function() {
      $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>/general/device_assign_action',
        data:$("#updUserForm").serialize(),
        success: function (data) {
            toastr.success(data);
            $('#assignModel').modal('hide');
            location.reload();
        },
        error: function(jqXHR, text, error){
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
                url: "<?php echo base_url();?>/general/delete_device_n_tool",
                data:'id='+val,
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
<script type="text/javascript">
    $(document).ready(function() {
        $("#uploadDataForm").submit(function() {
            $('#action_loader').modal('show');
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/General/device_upload_action',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    setTimeout(function(){ 
                        $('#action_loader').modal('hide');
                        toastr.success(data);
                        $('#uploadModel').modal('hide');
                        location.reload();
                    }, 2000); 

                },
                error: function(jqXHR, text, error){
                    setTimeout(function(){ 
                        $('#action_loader').modal('hide');
                        toastr.error(error);
                    }, 500);
                }
            });
            return false;
        });
    });
</script>
