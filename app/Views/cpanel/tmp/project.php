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
						<h4 class="page-title">Project <small></small></h4>
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
                                <div class="col-md-3 mb-3">
                                    <select name="city" id="city" class="form-control" required>
                                        <option value="">Select City</option>
                                        <?php foreach ($city->get() -> getResult() as $value) { ?>
                                            <option value="<?= $value->city;?>"><?= $value->city;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                 <select name="area" id="area" class="form-control" required>
                                    <option value="">Select Area</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Project Name" name="project" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <select name="olt" id="olt" class="form-control">
                                    <option value="">Select OLT</option>
                                    <?php foreach ($olt->get() -> getResult() as $value) { ?>
                                        <option value="<?= $value->id;?>" data-port="<?= $value->port;?>"><?= $value->name;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <select name="oltPort" id="oltPort" class="form-control">
                                    <option value="">Select Port</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" placeholder="GPS Coordinates" name="coordinate">
                            </div>
                            <div class="col-md-2 mb-3">
                                <button class="btn btn-primary btn-block" type="submit">Add New</button>
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
                                    <th>City</th>
                                    <th>Area</th>
                                    <th>Project</th>
                                    <th>OLT</th>
                                    <th>OLT Port</th>
                                    <th>Coordinates</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody1">
                                <?php foreach($project->get()->getResult() as $key => $value){?>
                                    <tr>
                                        <td><?= $key+1;?></td>
                                        <td><?= $value->city;?></td>
                                        <td><?= $value->area;?></td>
                                        <td><?= $value->project;?></td>
                                        <td><?= $value->olt_id ? $modelNetwork->get_olt($value->olt_id)->get()->getRow()->name : '';?></td>
                                        <td><?= $value->olt_port;?></td>
                                        <td><?= $value->coordinates;?></td>
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
                url: '<?php echo base_url();?>/project/add_project',
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
        data:'ser='+val+'&des=project',
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
    $(document).on('change','#city',function(){
        var city = $(this).val();
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "<?php echo base_url();?>/project/get_area",
            data:'city='+city,

            success: function(data){
            //
            $('#area').html('');
            $('#area').append('<option value="">select area</option>');
            $.each(data, function(index, value) {
                $('#area').append('<option>'+value.area+'</option>');
            });
            // console.log(data);
        },error: function(jqXHR, text, error){
            toastr.error(error);
        }
    });

    });
</script>
<script>
    $(document).on('change','#olt',function(){
        $('#oltPort').html('');
        $('#oltPort').append('<option value="">Select Port</option>');
        var port = $(this).find(':selected').attr('data-port');
        for (let i = 1; i <= port; i++) {
          $('#oltPort').append('<option>'+i+'</option>');
        } 
        if(port > 0){
            $('#olt').prop('required',true);
            $('#oltPort').prop('required',true);
        }else{
            $('#olt').prop('required',false);
            $('#oltPort').prop('required',false);
        }
      //
  });
</script>