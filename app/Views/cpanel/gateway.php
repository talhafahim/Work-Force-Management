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
                        <h4 class="page-title">Gateway <small></small></h4>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right">

                            <select class="btn btn-secondary btn-icon" id="status" name="status">
                                <option value="free">In Stock</option>
                                <option value="assigned">Assigned</option>
                                <option value="used">Utilized</option>
                            </select>

                        <!-- <a class="btn btn-primary mb-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-plus"></i> Upload Gateway
                        </a> -->
                        <a type="button" class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="btn-icon-label"><i class="fa fa-arrow-up"></i></span> Upload Gateway
                        </a>
                        <button class="btn btn-info" id="bulkAssign" style="display:none;">Assign To</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- end row -->
        
        <div class="collapse" id="collapseExample">
            <div class="card">
                <div class="card-body">
                    <form id="gatewayUploadForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                              <input type="file" name="file" required>
                          </div>
                          <div class="col-md-3 mb-3">
                            <button class="btn btn-primary btn-sm" type="submit">Upload</button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url();?>/gateway_sample_file.csv" type="button" class="btn btn-info btn-sm" style="color:white;">Download Sample File</a>
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
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Serial</th>
                                    <th>Vendor</th>
                                    <th>Model</th>
                                    <th>Scenario</th>
                                    <th>Cost</th>
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
<div id="assignModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updUserForm" class="form-horizontal form-label-left input_mask">
                <input type="hidden" name="dataid" id="dataid">
                <div class="modal-body">
                    <label for="exampleFormControlInput1">Assign To</label>
                    <select class="form-control" required="" name="technician_id">

                    </select>
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
<div id="bulkassignModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="bulkassignForm" class="form-horizontal form-label-left input_mask">
                <div class="modal-body">
                    <label for="exampleFormControlInput1">Assign To</label>
                    <select class="form-control" required="" name="technician_id" id="technician_id">
                        <option value="">select whom to assign</option>
                        <?php foreach ($users->get()->getResult() as $value) { ?>
                            <option value="<?= $value->id;?>" ><?= $value->firstname.' '.$value->lastname;?></option>
                        <?php } ?>
                    </select>
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
<?php 
// echo view('cpanel-layout/action_loader');
echo view('cpanel-layout/footer');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#gatewayUploadForm").submit(function() {
            $('#action_loader').modal('show');
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/general/gateway_upload_csv_action',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    setTimeout(function(){ 
                        $('#action_loader').modal('hide');
                        toastr.success(data);
                        user_fetchdata(); 
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
<script>

    $(document).ready(function(){
        user_fetchdata();
    });
  //
    function user_fetchdata(){

        $('#table1').dataTable().fnDestroy();
        table = $('#table1').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url();?>/general/get_getway_list',
                method: 'POST',
                data: function (d) {
                    d.status = $('#status').val();
                }    
            },
            order: [],
            columns: [
                {data: 'checkbox', orderable: false},
                {data: 'serial'},
                {data: 'vendor'},
                {data: 'model'},
                {data: 'scenario'},
                {data: 'cost'},
                {data: 'action', orderable: false, searchable: false},
                ]  
        });
        $('#status').change(function(event) {
            table.ajax.reload();
        });
    }

// ///////////////////////////////////////////////////

    $(document).on('click','.assignBtn',function(){
        // var assignid = $(this).attr('assign-id');
        var dataid = $(this).attr('data-id');
        $('#dataid').val(dataid);
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

////////////////////////////////////


    $(document).ready(function() {
        $("#updUserForm").submit(function() {
          $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>/general/assign_action',
            data:$("#updUserForm").serialize(),
            success: function (data) {
                toastr.success(data);
                $('#assignModel').modal('hide');
                user_fetchdata();
            },
            error: function(jqXHR, text, error){
                toastr.error(error);
            }
        });
          return false;
      });
    });
//////////////////////////////////////
    $(document).on('click','#table1 #checkAll',function(){
        if($(this).is(':checked')){
            $('#table1 tbody input:checkbox').prop('checked', true);
        }else{
            $('#table1 tbody input:checkbox').prop('checked', false);
        }
        enableDisable_assignBtn();
    });
    //
    $(document).on('click','#table1 tbody input:checkbox',function(){
        enableDisable_assignBtn();
    });
    //
    function enableDisable_assignBtn(){
        var gatewayIDList1 = new Array();
        $('#table1 tbody input:checkbox:checked').map(function() {
            gatewayIDList1.push(this.value);
        }).get();
        //
        if(gatewayIDList1.length > 0){
            $('#bulkAssign').show();
        }else{
            $('#bulkAssign').hide();
        }
    }
    //
    $(document).on('click','#bulkAssign',function(){
        $('#bulkassignModel').modal('show');
    });
    //
    $(document).ready(function() {
        $("#bulkassignForm").submit(function() {
            //
            var gatewayIDList = new Array();
            $('#table1 tbody input:checkbox:checked').map(function() {
                gatewayIDList.push(this.value);
            }).get();
            //
            var engineerID = $("#bulkassignForm #technician_id").val();
            //
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/general/assign_bulk_gateway',
                data: 'engineer_id='+engineerID+'&gatewayIDList='+gatewayIDList,
                success: function (data) {
                    toastr.success(data);
                    $('#bulkassignModel').modal('hide');
                    user_fetchdata();
                     enableDisable_assignBtn();
                },
                error: function(jqXHR, text, error){
                    toastr.error(error);
                }
            });
            return false;
        });
    });
</script>

