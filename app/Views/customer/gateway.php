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
                                <!-- <option value="free">In Stock</option> -->
                                <option value="assigned">Assigned</option>
                                <option value="used">Utilized</option>
                            </select>

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
                                            <!-- <th>#</th> -->
                                            <th>Serial</th>
                                            <th>Vendor</th>
                                            <th>Model</th>
                                            <th>CTN/Box#</th>
                                            <th>Received Date</th>
                                            <th>DN#</th>
                                            <!-- <th>Revenue (<?= get_setting_value('Currency');?>)</th> -->
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
                    url: '<?php echo base_url();?>/general/get_engineer_getway_list',
                    method: 'POST',
                    data: function (d) {
                        d.status = $('#status').val();
                    }    
                },
                order: [],
                columns: [
                    // {data: 'checkbox', orderable: false},
                    {data: 'serial'},
                    {data: 'vendor'},
                    {data: 'model'},
                    {data: 'ctn'},
                    {data: 'received_date'},
                    {data: 'dn'},
                    // {data: 'cost'},
                    {data: 'action', orderable: false, searchable: false},
                    ]  
            });
            $('#status').change(function(event) {
                table.ajax.reload();
            });
        }
    </script>

    <script>
        $(document).on('click','.return',function(){
            var val = $(this).attr('data-id');
//
            if(confirm("Do you really want to return this?")){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>/general/gateway_return_action",
                    data:'gateway_id='+val,
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

