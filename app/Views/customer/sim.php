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
                        <h4 class="page-title">SIM <small></small></h4>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right">

                            <select class="btn btn-secondary btn-icon" id="status" name="status">
                                <!-- <option value="in stock">In Stock</option> -->
                                <option value="assigned">Assigned</option>
                                <option value="utilized">Utilized</option>
                            </select>

                        <!-- <a class="btn btn-primary mb-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-plus"></i> Upload Gateway
                        </a> -->
                       <!--  <a type="button" class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <span class="btn-icon-label"><i class="fa fa-arrow-up"></i></span> Upload SIM
                        </a>
                        <button class="btn btn-info" id="bulkAssign" style="display:none;">Assign To</button> -->
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
                                    <!-- <th><input type="checkbox" id="checkAll"></th> -->
                                    <th>ICC ID</th>
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
                url: '<?php echo base_url();?>/general/get_engineer_sim_list',
                method: 'POST',
                data: function (d) {
                    d.status = $('#status').val();
                }    
            },
            order: [],
            columns: [
                // {data: 'checkbox', orderable: false},
                {data: 'icc_id'},
                {data: 'action', orderable: false, searchable: false},
                ]  
        });
        $('#status').change(function(event) {
            table.ajax.reload();
        });
    }

// ///////////////////////////////////////////////////
   
</script>

<script>
        $(document).on('click','.return',function(){
            var val = $(this).attr('data-id');
//
            if(confirm("Do you really want to return this?")){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>/general/sim_return_action",
                    data:'sim_id='+val,
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



