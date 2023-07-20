<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End
?>
<link href="<?= base_url();?>/assets/css/select2.min.css" rel="stylesheet" type="text/css">
<style>
    .select2-search__field{
        color:black !important;
    }
</style>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
     <div class="container-fluid">
      <div class="page-title-box">
       <div class="row align-items-center">
        <div class="col-sm-6">
            <h4 class="page-title">My Task <small></small></h4>
        </div>
        <div class="col-sm-6">
            <div class="float-right">


                <select class="btn btn-secondary btn-icon" id="status" name="status">
                    <option value="schedule">Schedule</option>
                    <option value="travelling">Travelling</option>
                    <option value="on site">On Site</option>
                    <option value="complete">Installed</option>
                    <option value="commission">Commission</option>
                    <option value="reject">Return</option>
                </select>

            </div>
        </div>
    </div>
</div>
<!-- end row -->
<div class="row">
    <div class="col-md-12">

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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody1">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- end row -->
</div>
<!-- container-fluid -->
</div>

<!-- content -->

<!-- sample modal content -->
<div id="updateTaskModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form id="updTaskForm" class="form-horizontal form-label-left input_mask">
            <input type="hidden" name="un_number" id="modal_un">
            <input type="hidden" name="task_id" id="modal_id">
            <div class="modal-body">
                <div class="mb-3">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons" style="width:100%">

                        <label class="btn btn-secondary task-status" id="status-travelling">
                            <input type="radio" name="status" value="travelling" autocomplete="off" required> Travelling
                        </label>
                        <label class="btn btn-secondary task-status" id="status-on-site">
                            <input type="radio" name="status" value="on site" autocomplete="off" required> On Site
                        </label>
                        <label class="btn btn-secondary task-status" id="status-complete">
                            <input type="radio" name="status" value="complete" autocomplete="off" required> Installed
                        </label>
                        <label class="btn btn-secondary task-status" id="status-commission">
                            <input type="radio" name="status" value="commission" autocomplete="off" required> Commission
                        </label>
                        <label class="btn btn-secondary task-status" id="status-reject">
                            <input type="radio" name="status" value="reject" autocomplete="off" required> Return
                        </label>

                        <!--  -->   
                    </div>
                </div>

                <div class="mb-3">
                 <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary btn-sm">
                    <input type="radio" name="options" value="single" autocomplete="off" required> Just this one
                </label>
                <label class="btn btn-secondary btn-sm">
                    <input type="radio" name="options" value="multiple" autocomplete="off" required> Complete UN#
                </label>
            </div>
        </div>

        <div class="mb-3" id="equipDiv">
        <!-- <div class="form-group"> 
            <label>Gateway</label>
            <input list="gatewayList" class="form-control" name="gateway" id="gateway" autocomplete="off">
            <datalist id="gatewayList">
            </datalist>
        </div> -->
    <!-- <div class="form-group"> 
        <label>Other Equipment</label>
        <textarea class="form-control" name="otherEquipment"></textarea>
    </div> -->
    <div class="form-group"> 
        <label>Gateway</label>
        <select class="form-control multi-select" name="gateway[]"  id="gateway" multiple="multiple">
            <!-- <option value="">select equipment</option> -->
        </select>
    </div>
    <div class="form-group"> 
        <label>SIM</label>
        <select class="form-control multi-select" name="sim[]"  id="sim" multiple="multiple">
            <!-- <option value="">select equipment</option> -->
        </select>
    </div>
    <div class="form-group"> 
        <label>Other Equipment</label>
        <table id="equipTable">
            <?php 
            $miscEquip = $misc_equipment;
            foreach ($miscEquip->getResult() as $key => $value) { ?>
                <tr>
                    <td width="50%">
                        <input type="hidden" name="otherEquipment[]" value="<?= $value->id;?>"><?= $value->name;?>
                    </td>
                    <td width="35%">
                        <input type="number" step="0.1" min="0" class="form-control" name="equipQty[]" placeholder="quantity" value="0" required>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="mb-3" id="returnDiv">
    <div class="form-group"> 
        <label>Return Reason</label>
        <select class="form-control" name="returnReason">
            <option value="">select return reason</option>
            <?php foreach($return_reason->getResult() as $returnValue){?>
                <option value="<?= $returnValue->id;?>"><?= $returnValue->reason;?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="mb-3" id="pictureDiv">
    <div class="form-group"> 
        <label>Picture</label>
        <table style="width:100%;">
            <tr>
                <td style="width:60%;"><input type="file" class="form-control" name="pic1"></td>
                <td style="width:40%;">
                    <div class="btn-group" style="float:right;width:100%;">
                        <button type="button" class="btn btn-success btn-sm addRow"><i class="fa fa-plus"></i></button>
                        <button type="button" class="btn btn-danger btn-sm deleteRow"><i class="fa fa-minus"></i></button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <!-- <div class="form-group"> 
        <label>Picture 1</label>
        <input type="file" class="form-control" name="pic1">
    </div> -->
    <!-- <div class="form-group"> 
        <label>Picture 2</label>
        <input type="file" class="form-control" name="pic2">
    </div>
    <div class="form-group"> 
        <label>Picture 3</label>
        <input type="file" class="form-control" name="pic3">
    </div> -->
</div>





</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
</div>
</form>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php 
// echo view('cpanel-layout/action_loader');
echo view('cpanel-layout/footer');
?>
<script src="<?= base_url();?>/assets/js/select2.min.js"></script>


<script>
    $(document).ready(function() {
        $('.multi-select').select2({
            placeholder: 'select',
            allowClear: true,
        });
    });


    $('#updateTaskModel').on('shown.bs.modal', function () {
        $(this).find('form').trigger('reset');
    });

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
                url: '<?php echo base_url();?>/task/show_assign_list', 
                method: 'POST',
                data: function (d) {
                    d.status = $('#status').val();
                }            
            },
            order: [],
            columns: [
                {data: 'un_number'},
                {data: 'meter_number'},
                {data: 'scenario'},
                {data: 'meter_type'},
                {data: 'protocol'},
                {data: 'meter_model'},
                {data: 'prem_type'},
                {data: 'taskStatus'},
                {data: 'action', orderable: false, searchable: false},
                ]  
        });

        $('#status').change(function(event) {
            table.ajax.reload();
        });
    }

</script>


<script type="text/javascript">
    $(document).on('click','#updateUN',function(){
        var un = $(this).attr('data-un');
        var id = $(this).attr('task-id');
//
        $('#updTaskForm').trigger('reset');
//
        $('#modal_un').val(un);
        $('#modal_id').val(id);
//
        $('#equipDiv,#pictureDiv,#returnDiv').hide();
        $('.task-status').hide();
//
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url();?>/task/show_update_modal_content',
            data:'un='+un+'&id='+id,
            dataType : 'json',
            success: function(data){
                if(data.currentStatus == 'schedule'){
                    $('#status-travelling,#status-reject').show();
                }else if(data.currentStatus == 'travelling'){
                    $('#status-on-site,#status-reject').show();
                }else if(data.currentStatus == 'on site'){
                    $('#status-complete,#status-reject').show();
                }else if(data.currentStatus == 'complete'){
                    $('#status-commission').show();
                }
                //
                $('#gateway').html('');
                jQuery.each(data.gateway, function(index, item) {
                    $('#gateway').append('<option>'+item+'</option>');
                });
                //
                $('#sim').html('');
                jQuery.each(data.sim, function(index, item) {
                    $('#sim').append('<option>'+item+'</option>');
                });
                //
                $('#updateTaskModel').modal('show');

            }
        })

    });
///////////////////////////////////
    $(document).on('click','.task-status',function(){
        $('#pictureDiv,#equipDiv,#returnDiv').hide();
        $('#equipDiv :input').removeAttr('required');
        $('#returnDiv select').removeAttr('required');
        var status = $(this).find(":input").val();
        if(status == 'complete' || status == 'reject' || status == 'on site'){
            $('#pictureDiv').show();
        }if(status == 'complete'){
         $('#equipDiv').show(); 
         $('#gateway').prop('required',true);
         $('#sim').prop('required',true);
     }if(status == 'reject'){
        $('#returnDiv').show(); 
        $('#returnDiv select').prop('required',true);  
    }if(status == 'commission'){
        $('#equipDiv').show();
        $('#pictureDiv').show();  
    }
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#updTaskForm").submit(function() {
            $('#action_loader').modal('show');
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/task/update_task',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    setTimeout(function(){ 
                        $('#updateTaskModel').modal('hide');
                        user_fetchdata();
                        $('#action_loader').modal('hide');
                        toastr.success(data);
                    }, 2000);
                },
                error: function(jqXHR, text, error){
                    setTimeout(function(){
                        $('#action_loader').modal('hide');
                        toastr.error(error);
                    }, 2000);
                }
            });
            return false;
        });
    });

</script>


<script type="text/javascript">
    $(document).ready(function(){
        var num = 2;

        $(".addRow").click(function(){
            if(num <= 5){

                var markup = '<tr><td colspan="2"><input type="file" class="form-control" name="pic'+num+'"></td></tr>';

                $("#pictureDiv table").append(markup);
                num++;
            }
        });
// Find and remove selected table rows
        $("body").on("click",".deleteRow",function(){
            deleteRow();
        });

        function deleteRow(){
        if(num > 2){
            $("#pictureDiv table tr:last-child").remove();
            num--;
        }
    }

    });

</script>

<script type="text/javascript">
//     $(document).ready(function(){
//      var arrayFromPHP = <?php echo json_encode($misc_equipment->getResult()); ?>;
//      $(".addRow").click(function(){
//         var markup = '<tr><td width="50%"><select class="form-control" name="otherEquipment[]" required><option value="">select</option>';
//         jQuery.each(arrayFromPHP, function(index, item) {
//             markup += '<option value="'+item['id']+'">'+item['name']+'</option>';
//         });
//         markup += '</select></td><td width="35%"><input type="number" step="0.1" min="0" class="form-control" name="equipQty[]" placeholder="quantity" value="0" required></td><td width="15%"><div class="btn-group" style="float:right;"><button type="button" class="btn btn-danger btn-sm deleteRow"><i class="fa fa-minus"></i></button></div></td></tr>';

//         $("#equipTable").append(markup);
//     });
// // Find and remove selected table rows
//      $("body").on("click",".deleteRow",function(){
//         $(this).parents("tr").remove();
//     });
//  });

</script>



