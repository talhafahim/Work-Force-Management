<?php
echo view('cpanel-layout/header');
// Top Bar Start
echo view('cpanel-layout/topbar');
// Top Bar End
echo view('cpanel-layout/navbar');
// Left Sidebar End

?>
<head>
    <link rel='stylesheet' href='<?= base_url();?>/assets/css/spectrum.css' />
</head>
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<div class="page-title-box">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<h4 class="page-title">ADT <small>Access Detail Topology</small></h4>
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
                            <div class="col-md-6 mb-3">
                                <select name="project" id="project" class="form-control" required>
                                    <option value="">Select Project</option>
                                    <?php foreach ($project->get() -> getResult() as $value) { ?>
                                        <option value="<?= $value->id;?>"><?= $value->project;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <select name="splitter" id="splitter" class="form-control" required>
                                    <option value="">Select Splitter</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="text" class="form-control" placeholder="Splitter Tag" name="splittertag" id="splittertag" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="number" class="form-control" placeholder="Customer Distance (meter)" name="distance" required step="0.001">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="number" class="form-control" placeholder="Customer Power" name="power" required step="0.001" min="-40" max="40">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="text" class="form-control" placeholder="Customer Username" name="customer" required data-mask="bo-999999999999">
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-primary btn-block" type="submit">Add</button>
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
                                        <th>Project</th>
                                        <th>Splitter</th>
                                        <th>Splitter Tag</th>
                                        <th>Distance (m)</th>
                                        <th>Power</th>
                                        <th>Customer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody1">
                                    <?php foreach($adt->get()->getResult() as $key => $value){?>
                                        <tr>
                                            <td><?= $key+1;?></td>
                                            <td><?= $value->project_id ? $modelProject->get_project($value->project_id)->get()->getRow()->project : '';?></td>
                                            <td><?= $value->splitter;?></td>
                                            <td><?= $value->splitter_tag;?></td>
                                            <td><?= $value->distance;?> m</td>
                                            <td><?= $value->power;?></td>
                                            <td><?= $value->customer;?></td>
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
<!-- <script src='<?= base_url();?>/assets/js/spectrum.js'></script> -->
<script type="text/javascript">
    $(document).ready( function () {
        $('#table1').DataTable();

        // colorClass();

    } );

    // function colorClass(){
    //     $("#coreColor").spectrum({
    //         showPaletteOnly: true,
    //         showPalette:true,
    //         color: '#fefefe',
    //         palette: [
    //         ['#0067aa', '#f57921', '#71bf45','#764e2a','#bcbdbf','#fffeff'],
    //         ['#d71a20', '#231f20', '#e9c800', '#762282', '#f499c2','#01a99c']
    //         ]
    //     });
    // }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#addNewAreaForm").submit(function() {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>/field/add_adt',
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
        url: "<?php echo base_url();?>/field/delete",
        data:'ser='+val+'&des=adt',
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
    $(document).on('change','#project',function(){
        var project = $(this).val();
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "<?php echo base_url();?>/field/get_splitter",
            data:'project='+project,
            //
            success: function(data){
            //
            $('#splitter').html('');$('#splittertag').val('');
            $('#splitter').append('<option value="">Select Splitter</option>');
            $.each(data, function(index, value) {
                $('#splitter').append('<option value="'+value.splitter+'" tag="'+value.splitter_tag+'">'+value.splitter+'</option>');
            });
            // console.log(data);
        },error: function(jqXHR, text, error){
            toastr.error(error);
        }
    });

    });
</script>

<script>
    $(document).on('change','#splitter',function(){
        var tag = $(this).find(':selected').attr('tag');
        $('#splittertag').val(tag);
    });
</script>

