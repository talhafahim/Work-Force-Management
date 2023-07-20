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
						<h4 class="page-title">All Work Order <small></small></h4>
					</div>
                    <div class="col-sm-6">
                        <div class="float-right">


                            <select class="btn btn-secondary btn-icon" id="status" name="status">
                                <option value="all">All</option>
                                <option value="unallocated">Unallocated</option>
                                <option value="schedule">Schedule</option>
                                <option value="travelling">Travelling</option>
                                <option value="on site">On Site</option>
                                <option value="complete">Installed</option>
                                <option value="commission">Commission</option>
                                <option value="reject">Return</option>
                            </select>


                        <a type="button" class="btn btn-primary" href="<?= base_url();?>/task/upload">
                            <span class="btn-icon-label"><i class="fa fa-arrow-up"></i></span> Task Upload
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
                                        <th>Utility #</th>
                                        <th>Meter Serial</th>
                                        <th>Scenario</th>
                                        <th>Meter Type</th>
                                        <th>Protocol</th>
                                        <th>Meter Model</th>
                                        <th>Premise Type</th>
                                        <th>Status</th>
                                        <th>Assign To</th>
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
                    <div class="mb-3">

                        <label for="exampleFormControlInput1">Assign To</label>
                        <select class="form-control js-select2" required="" name="technician_id">
                        </select>

                    </div>
                    <div class="mb-3">

                     <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label class="btn btn-secondary btn-sm">
                        <input type="radio" name="options" id="option1" value="single" autocomplete="off" required> Just this one
                    </label>
                    <label class="btn btn-secondary btn-sm">
                        <input type="radio" name="options" id="option2" value="multiple" autocomplete="off" required> Complete UN#
                    </label>
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
<?php 
// echo view('cpanel-layout/action_loader');
echo view('cpanel-layout/footer');
?>
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
                url: '<?php echo base_url();?>/customer/show_list',
                method: 'POST',
                data: function (d) {
                    d.status = $('#status').val();
                }   
            },
            columns: [
                {data: 'un_number'},
                {data: 'meter_number'},
                {data: 'scenario'},
                {data: 'meter_type'},
                {data: 'protocol'},
                {data: 'meter_model'},
                {data: 'prem_type'},
                {data: 'taskStatus'},
                {data: 'username'},
                {data: 'action', orderable: false, searchable: false},
                ]  
        });

        $('#status').change(function(event) {
            table.ajax.reload();
        });
    }
    //////////////////////////////////////////////////////////////
    $(document).on('click','#assignBtn',function(){
        var assignid = $(this).attr('assign-id');
        var dataid = $(this).attr('data-id');
        $('#dataid').val(dataid);
        //
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>/Customer/technician_list',
            data:'id='+assignid,
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

</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#updUserForm").submit(function() {
      $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>/Customer/update_technician',
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

</script>
<script>
    $(document).on('click','.delete',function(){
        var val = $(this).attr('data-serial');
//
        if(confirm("Do you really want to delete this?")){
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>/customer/delete_task_action",
                data:'id='+val,
                success: function(data){
                    toastr.success(data);
                    table.ajax.reload();  
                },error: function(jqXHR, text, error){
                    toastr.error(error);
                }
            });
        }
    });
</script>



