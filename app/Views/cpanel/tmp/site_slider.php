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
						<h4 class="page-title">Slider</h4>
					</div>
					<div class="col-sm-6">
                        <div class="float-right">
                          <button type="button" class="btn btn-primary btn-icon" onclick="$('#addSliderModel').modal('show');">
                            <span class="btn-icon-label"><i class="fa fa-plus mr-2"></i></span>Add New
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row">
           <div class="col-md-12">
            <!-- <p>Page content here with seprate rows talkha</p> -->
            <div class="card">
             <div class="card-body">
						<!-- <button type="button" class="btn btn-primary btn-icon float-right btn-sm" onclick="$('#addSubMenuModel').modal('show');">
							<span class="btn-icon-label"><i class="fa fa-plus mr-2"></i></span>Add New
						</button> -->
						<!-- <h5>Sub Menu</h5> -->
						<div style="overflow-x:scroll;">
							<table id="sliderTable" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%; ">
								<thead>
									<tr>
										<th>#</th>
										<th>Title</th>
										<th>Slogan</th>
										<th>Image</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="slider_tbody">
                                    <?php 
                                    $sNo = 0;
                                    foreach($slider as $value) {
                                        $sNo++;
                                        $check = ($value->status == 1) ? 'checked' : '';
                                        ?>
                                        <tr>
                                          <td><?= $sNo ?></td>
                                          <td><?= $value->title ?></td>
                                          <td><?= $value->slogan ?></td>
                                          <td><img class="zoom-in" src="http://103.121.121.25:96/uploads/<?php echo 'slider'.$value->id.'.png' ?>" ></td>
                                          <td>
                                            <input type="checkbox" name="block" class="switchBtn sliderED" id="<?php echo $value->id ?>" switch="success" <?= $check;?>/>
                                            <label for="<?php echo $value->id ?>" data-on-label="ON" data-off-label="OFF"></label>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="mr-3 text-primary editSliderBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" data-sliderid="<?php echo $value->id;?>"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0);" class="text-danger delSliderBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" data-sliderid="<?php echo $value->id;?>"><i class="fa fa-trash-alt"></i></a>
                                        </td>

                                    </tr>
                                <?php } ?>
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
<footer class="footer">© 2021 <span class="d-none d-sm-inline-block">- Design & Developed with <i class="mdi mdi-heart text-danger"></i> by LOGON</span>.</footer>
</div>
<?php 
echo view('cpanel-layout/footer');
echo view('cpanel/popup/site_add_slider');

?>
<!-- sample modal content -->
<div id="updateSliderModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Edit Slider Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updSliderForm" class="form-horizontal form-label-left input_mask">
                <div class="modal-body" id="updateslider">
                <input type="hidden" name="sliderid" id="sliderid" val="">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Title</label>
						<input type="text" class="form-control" name="title" id="slider_name" required=""  >
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleFormControlInput1">Slogan</label>
						<input type="text" class="form-control" name="slogan" id="slogan" required="" >
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">

					<div class="custom-file">
								<input type="file" class="custom-file-input" id="customFile" name="image" >
								<label class="custom-file-label" for="customFile">Select Image</label>
							</div>
					</div>
				</div>
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
<script>
    $(document).ready(function() {
        $('#sliderTable').DataTable();
    } );
    // $(document).ready(function(){
    //     user_fetchdata();
    // });
  //
  function user_fetchdata(){
    var loader = `<tr><td colspan="10" class="text-center"><div class="spinner-border text-primary" role="status" id="loading"></div></td></tr>`;
    $('#sliderTable').dataTable().fnDestroy();
    $('#slider_tbody').html(loader);
    $.ajax({
        method: 'POST',
        url: '<?php echo base_url();?>/Site_Home/show_slider',
        success: function(data){
            // alert(data);
            // $('#slider_tbody').html(data);
            $('#sliderTable').DataTable();

        }
    })
}
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // var data = $("#addSliderForm").serialize();
        // console.log(data);
        $("#addSliderForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url();?>/Site_Home/create_slider',
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                    if(data.includes('Success')){
                        toastr.success(data);
                        $('#addSliderModel').modal('hide');
                        $('#addSliderForm').trigger('reset');

                        user_fetchdata();
                        location.reload();
                    }else{
                        toastr.error(data);
                    }
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
    $(document).on('click','.editSliderBtn',function(){
        var val = $(this).attr('data-sliderid');
        // alert(val);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>/Site_Home/edit_form",
            data:'sliderid='+val,
            dataType: "json",
            success: function(data){
                // $("#updateslider").html(data);
                $('#sliderid').val(data.id);
                $('#slider_name').val(data.title);
                $('#slogan').val(data.slogan);
                $('#updateSliderModel').modal('show');
            },
            error: function(jqXHR, text, error){
                console.log(error);
            }

        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#updSliderForm").submit(function() {
            $.ajax({
                url: '<?php echo base_url();?>/Site_Home/update_slider',
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                // data:$("#updSliderForm").serialize(),
                success: function (data) {
                    if(data.includes('Success')){
                        toastr.success(data);
                        $('#updateSliderModel').modal('hide');
                        user_fetchdata();
                        location.reload();
                    }else{
                        toastr.error(data);
                    }
                },
                error: function(jqXHR, text, error){
                // Displaying if there are any errors

            }
        });
            return false;
        });
    });
</script>

<script>
    $(document).on('change','.sliderED',function(){
        var id = $(this).attr('id');
        var checked = $('input[name="block"]').prop('checked');
        // var myId = 'id='+id;
        // var status = 'status='+checked;
        // alert(checked);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>/Site_Home/slider_flip",
            data: 'id='+id,
            success: function(data){
                toastr.success(data);
                location.reload();
            },error: function(jqXHR, text, error){
                toastr.error(error);
            }
        });
    });
</script>
<script>
    $(document).on('click','.delSliderBtn',function(){
        var val = $(this).attr('data-sliderid');
//      

if(confirm("Do you really want to delete this?")){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>/Site_Home/delete_slider",
        data:'id='+val,
        success: function(data){
            user_fetchdata();
            // snack('#59b35a','User Deleted Successfully','check-square-o');
            toastr.success(data);
            location.reload();
        },error: function(jqXHR, text, error){
            toastr.error(error);
        }
    });
}
});
</script>