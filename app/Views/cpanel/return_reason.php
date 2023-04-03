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
						<h4 class="page-title">Return Reason <small></small></h4>
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
                             <input type="text" class="form-control" placeholder="Reason" name="reason" required>
                         </div>
                         <div class="col-md-3 mb-3">
                            <label>Picture Require</label>
                            <input type="hidden" name="picReq" value="0">
                            <input type="checkbox" name="picReq" value="1">
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
                                    <th>Reason</th>
                                    <th>Picture Require</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody1">
                                <?php foreach($return_reason->get()->getResult() as $key => $value){
                                    $picRequireCheck = ($value->pic_require == 1) ? 'checked' : '';
                                    ?>
                                    <tr>
                                        <td><?= $key+1;?></td>
                                        <td><?= $value->reason;?></td>
                                        <td><input type="checkbox" class="picRequire" data-id="<?= $value->id;?>" <?=$picRequireCheck;?> ></td>
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
        $("#addNewCityForm").submit(function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/general/add_return_reason',
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
                url: "<?php echo base_url();?>/general/delete_return_reason",
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
                console.log(data);

            },error: function(jqXHR, text, error){
                toastr.error(error);
            }
        });
    });
</script>