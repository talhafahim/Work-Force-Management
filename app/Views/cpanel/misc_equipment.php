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
						<h4 class="page-title">Equipment <small></small></h4>
					</div>
                    <div class="col-sm-6">
                        <div class="float-right">
                          <!-- <button type="button" class="btn btn-primary btn-icon" onclick="$('#addUserModel').modal('show');">
                            <span class="btn-icon-label"><i class="fa fa-user-plus mr-2"></i></span>Add New User
                        </button> -->
                        <a class="btn btn-primary mb-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-plus"></i> Add New
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
      <!--   <div class="d-flex justify-content-end">
            
      </div> -->
      
      <div class="collapse" id="collapseExample">
        <div class="card">
            <div class="card-body">
                <form id="addNewCityForm">
                    <div class="row">
                        <div class="col-md-4 mb-4 form-group">
                           <input type="text" class="form-control" placeholder="Equipment Name" name="name" required>
                       </div>
                       <div class="col-md-2 mb-2 form-group">
                           <input type="number" step="0.1" class="form-control" placeholder="Stock" name="stock" required>
                       </div>
                       <div class="col-md-2 mb-2 form-group">
                           <select class="form-control" name="uom" required>
                               <option>piece</option>
                               <option>meter</option>
                               <option>box</option>
                               <option>gallon</option>
                               <option>carton</option>
                           </select>
                       </div>
                       <div class="col-md-2 mb-2 form-group">
                           <input type="number" step="0.1" class="form-control" placeholder="Rate (<?= get_setting_value('Currency');?>)" name="rate" required>
                       </div>
                       <div class="col-md-2 mb-2 form-group">
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
                                <th>Stock</th>
                                <th>UOM</th>
                                <th>Rate (<?= get_setting_value('Currency');?>)</th>
                                <th>Action</th>
                                <th>Assign</th>
                            </tr>
                        </thead>
                        <tbody id="tbody1">
                            <?php foreach($misc_equipment->get()->getResult() as $key => $value){

                                ?>
                                <tr>
                                    <td><?= $key+1;?></td>
                                    <td><?= $value->name;?></td>
                                    <td><?= $value->stock;?></td>
                                    <td><?= $value->uom;?></td>
                                    <td><?= $value->rate;?></td>
                                    <td>

                                        <a href="javascript:void(0);" class="text-info edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" data-serial="<?php echo $value->id;?>"><i class="fa fa-edit"></i></a>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0);" class="text-danger delete" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-serial="<?php echo $value->id;?>"><i class="fa fa-trash-alt"></i></a>
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
<div id="updateModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Update Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="miscEquipUpdForm" class="form-horizontal form-label-left input_mask">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" id="id">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" id="name" readonly>
                        </div>
                        <div class="col-md-4 form-group">
                            <input type="number" class="form-control" id="stock" step="0.01" min="0" name="stock" required>
                        </div>
                        <div class="col-md-4 form-group">
                           <select class="form-control" name="uom" id="uom" required>
                               <option>piece</option>
                               <option>meter</option>
                               <option>box</option>
                               <option>gallon</option>
                               <option>carton</option>
                           </select>
                       </div>
                       <div class="col-md-4 mb-4 form-group">
                           <input type="number" step="0.01" class="form-control" placeholder="Rate (<?= get_setting_value('Currency');?>)" name="rate" id="rate" required>
                       </div>
                    </div>
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

<!-- sample modal content -->
<div id="assignModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updUserForm" class="form-horizontal form-label-left input_mask">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                         <div class="form-group"> 
                            <label for="exampleFormControlInput1">Assign To</label>
                            <select class="form-control" required="" name="technician_id">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" name="otherEquipmentId" id="otherEquipmentId">
                        <input type="text" class="form-control" id="otherEquipment" name="otherEquipment" readonly>
                    </div>
                    <div class="col-md-4">
                        <input type="number" step="0.1" min="0" class="form-control" name="equipQty" placeholder="quantity" value="0" required>
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
<!-- content -->

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
                url: '<?php echo base_url();?>/general/add_misc_equipment',
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
<script>
    $(document).on('click','.delete',function(){
        var val = $(this).attr('data-serial');
//
        if(confirm("Do you really want to delete this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>/general/delet_misc_equipment",
                data:'ser='+val,
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

<script>
    $(document).on('click','.picRequire',function(){
        var id = $(this).attr('data-id');
        var picReq = 0;
        if($(this).prop('checked')) {
            picReq = 1;
        } 
        //
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>/general/return_reason_pic_require_update",
            data:'id='+id+'&picReq='+picReq,
            success: function(data){
                // console.log(data);

            },error: function(jqXHR, text, error){
                toastr.error(error);
            }
        });
    });
</script>

<script>
    $(document).on('click','.edit',function(){
        var val = $(this).attr('data-serial');
//   
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "<?php echo base_url();?>/general/update_stock",
            data:'ser='+val,
            success: function(data){
                $('#updateModel #id').val(data.id);
                $('#updateModel #name').val(data.name);
                $('#updateModel #stock').val(data.stock);
                $('#updateModel #uom').val(data.uom);
                $('#updateModel #rate').val(data.rate);
                $('#updateModel').modal('show'); 
            },error: function(jqXHR, text, error){
                toastr.error(error);
            }
        });
        
    });
</script>
<script>
 $(document).ready(function() {
    $("#miscEquipUpdForm").submit(function() {
       //
        if(confirm("Do you really want to update this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>/general/update_stock_action",
                data:$("#miscEquipUpdForm").serialize(),
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
        return false;
    });
});   
</script>


<script type="text/javascript">

    // ///////////////////////////////////////////////////

    $(document).on('click','.assignBtn',function(){
        $("#updUserForm").trigger('reset');
        var dataname = $(this).attr('data-name');
        $('#otherEquipment').val(dataname);
        var dataid = $(this).attr('data-id');
        $('#otherEquipmentId').val(dataid);
        //
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>/Customer/technician_list',
            data:'id='+dataid,
            success: function(data){
                // toastr.success(data);
                $('#updUserForm select').html(data);
                $('#assignModel').modal('show');
            },
            error: function(jqXHR, text, error){
                toastr.error(error);
            }
        });
        //
        
    });

    // ///////////////////////////////////////////////////

    $(document).ready(function() {
        $("#updUserForm").submit(function() {
          $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>/general/equipment_assign_action',
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